<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ContractLine;
use App\Models\ContractRevision;
use App\Models\Supplier; // If you tie to a Supplier model
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ContractController extends Controller
{
    /**
     * Display a list of contracts with advanced search & pagination.
     */
    public function index(Request $request)
    {
        $query = Contract::query()->with('supplier');

        // Basic free-text search
        if ($request->filled('search')) {
            $search = $request->input('search');
            // We group so 'orWhere' doesn't override other conditions
            $query->where(function($q) use ($search) {
                $q->where('contract_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Optional supplier filter
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->input('supplier_id'));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter for effective_date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->input('start_date'));
            $end   = Carbon::parse($request->input('end_date'));
            $query->whereBetween('effective_date', [$start, $end]);
        }

        // Sort by or default to created_at desc
        $contracts = $query->orderBy('created_at', 'desc')->paginate(10);

        // For advanced filtering, pass suppliers if needed for a dropdown
        $suppliers = Supplier::orderBy('name')->get(); // If you have a "name" column
        return view('contracts.index', compact('contracts', 'suppliers'));
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create()
    {
        // Load suppliers for a dropdown if relevant
        $suppliers = Supplier::orderBy('name')->get();
        $lifecycleStages = Contract::lifecycleStages();

        return view('contracts.create', compact('suppliers', 'lifecycleStages'));
    }

    /**
     * Store a newly created contract with advanced fields.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_number'  => 'required|string|max:50|unique:contracts',
            'title'            => 'nullable|string|max:255',
            'status'           => 'required|string|max:50',
            'effective_date'   => 'nullable|date',
            'expiration_date'  => 'nullable|date',
            'total_value'      => 'nullable|numeric',
            'currency'         => 'nullable|string|max:10',
            'supplier_id'      => 'nullable|exists:suppliers,id',
            'lifecycle_stage'  => 'nullable|string|max:50',
            'auto_renew'       => 'boolean',
            'max_renewals'     => 'nullable|integer|min:0',
            'attachments'      => 'nullable|array',
            // etc. for risk_level, etc.
        ]);

        // Create contract
        $contract = Contract::create($request->all());

        // If user uploaded attachments
        if ($request->hasFile('attachments')) {
            $uploadedFiles = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '-' . $file->getClientOriginalName();
                $path     = $file->storeAs('public/contract_attachments', $fileName);
                $uploadedFiles[] = $fileName;
            }
            $contract->attachments = $uploadedFiles;
            $contract->save();
        }

        // Example: send notification / email to relevant user(s)
        // Notification::send($contract->supplier->user, new ContractCreatedNotification($contract));

        return redirect()->route('contracts.show', $contract->id)
                         ->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified contract with lines & revisions.
     */
    public function show($id)
    {
        $contract = Contract::with(['lines', 'revisions', 'supplier'])->findOrFail($id);

        // Example: Check if near expiration or auto_renew
        if ($contract->auto_renew && $contract->isNearExpiration(30)) {
            // Potential logic: automatically renew if under max_renewals
            if ($contract->current_renewal_count < $contract->max_renewals) {
                // Auto renew
                // e.g. $contract->expiration_date = $contract->expiration_date->addYear();
                // $contract->current_renewal_count++;
                // $contract->save();
                // with a message or notification
            }
        }

        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing a contract (advanced fields).
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $suppliers = Supplier::orderBy('name')->get();
        $lifecycleStages = Contract::lifecycleStages();

        return view('contracts.edit', compact('contract', 'suppliers', 'lifecycleStages'));
    }

    /**
     * Update the specified contract (with advanced logic).
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $request->validate([
            'contract_number' => 'required|string|max:50|unique:contracts,contract_number,' . $contract->id,
            'title'           => 'nullable|string|max:255',
            'status'          => 'required|string|max:50',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'total_value'     => 'nullable|numeric',
            'currency'        => 'nullable|string|max:10',
            'supplier_id'     => 'nullable|exists:suppliers,id',
            'lifecycle_stage' => 'nullable|string|max:50',
            'auto_renew'      => 'boolean',
            'max_renewals'    => 'nullable|integer|min:0',
            // etc. for risk_level, performance_rating, etc.
        ]);

        // If user re-uploads attachments
        if ($request->hasFile('attachments')) {
            $uploadedFiles = $contract->attachments ?? [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '-' . $file->getClientOriginalName();
                $path     = $file->storeAs('public/contract_attachments', $fileName);
                $uploadedFiles[] = $fileName;
            }
            $request->merge(['attachments' => $uploadedFiles]);
        }

        $contract->update($request->all());

        // Possibly trigger eSignature or updated notification 
        // e.g. if ($request->input('status') === 'Pending Approval') ...
        //    dispatch new ApproveContractWorkflow($contract);

        return redirect()->route('contracts.show', $contract->id)
                         ->with('success', 'Contract updated successfully.');
    }

    /**
     * Delete a contract (and cascade lines & revisions).
     */
    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        // Possibly remove files from storage
        // if ($contract->attachments) { ... }

        return redirect()->route('contracts.index')
                         ->with('success', 'Contract deleted successfully.');
    }

    /**
     * Add a new line to the contract.
     */
    public function createLine($contractId)
    {
        $contract = Contract::findOrFail($contractId);
        return view('contracts.create_line', compact('contract'));
    }

    public function storeLine(Request $request, $contractId)
    {
        $contract = Contract::findOrFail($contractId);

        $request->validate([
            'line_item'   => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'unit_price'  => 'nullable|numeric',
            'quantity'    => 'required|integer|min:1',
        ]);

        $line = new ContractLine($request->all());
        $line->contract_id = $contract->id;
        $line->save();

        return redirect()->route('contracts.show', $contract->id)
                         ->with('success', 'Contract line added successfully.');
    }

    /**
     * Create a new revision for the contract.
     */
    public function createRevision($contractId)
    {
        $contract = Contract::findOrFail($contractId);

        // Generate next revision number based on existing revisions
        $nextNumber = $contract->revisions()->max('revision_number') + 1;

        return view('contracts.create_revision', [
            'contract' => $contract,
            'nextRevisionNumber' => $nextNumber,
        ]);
    }

    public function storeRevision(Request $request, $contractId)
    {
        $contract = Contract::findOrFail($contractId);

        $request->validate([
            'revision_number' => 'required|integer',
            'revision_notes'  => 'nullable|string',
            'initiated_by'    => 'nullable|string|max:100',
        ]);

        // Optionally, replicate contract data into the revision record
        ContractRevision::create([
            'contract_id'     => $contract->id,
            'revision_number' => $request->input('revision_number'),
            'revision_notes'  => $request->input('revision_notes'),
            'revision_status' => 'Pending',
            'initiated_by'    => $request->input('initiated_by'),
        ]);

        // Could also send an “approval request” notification to a manager
        // e.g. Notification::send($approvalManager, new RevisionApprovalRequest($revision))

        return redirect()->route('contracts.show', $contract->id)
                         ->with('success', 'Revision created and is pending approval.');
    }

    /**
     * Approve or reject a revision (PhD-level advanced workflow).
     */
    public function updateRevision(Request $request, $revisionId)
    {
        $revision = ContractRevision::findOrFail($revisionId);
        
        $request->validate([
            'revision_status' => 'required|string|max:50',
        ]);

        $revision->update([
            'revision_status' => $request->input('revision_status')
        ]);

        // If status = 'Approved', optionally apply changes to the main contract fields,
        // or store an official "Amendment" record, or trigger e-signature.

        return redirect()->route('contracts.show', $revision->contract_id)
                         ->with('success', "Revision #{$revision->revision_number} {$revision->revision_status}.");
    }

    /**
     * EXAMPLE: Export a single contract to PDF using barryvdh/laravel-dompdf or similar.
     */
    public function exportPdf($id)
    {
        $contract = Contract::with('lines', 'revisions', 'supplier')->findOrFail($id);

        $pdf = \PDF::loadView('contracts.pdf', compact('contract'));
        $filename = 'contract-'.$contract->contract_number.'.pdf';

        return $pdf->download($filename);
    }

    /**
     * EXAMPLE: Bulk export or advanced analytics (PhD-level).
     */
    public function analytics(Request $request)
    {
        // Could show aggregated data: total contract spend, # of lines, average performance rating, etc.
        // Possibly filter by supplier, date range, status
        $query = Contract::query();

        // Filter logic...

        $contracts = $query->with('supplier', 'lines')->get();

        // Summarize data
        $totalValue = $contracts->sum('total_value');
        $avgRating  = $contracts->avg('performance_rating');

        // Return a specialized analytics view
        return view('contracts.analytics', compact('contracts', 'totalValue', 'avgRating'));
    }
}
