<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agreement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AgreementController extends Controller
{
    /**
     * Display a listing of the agreements with advanced search.
     */
    public function index(Request $request)
    {
        $query = Agreement::query();

        // Advanced search: by agreement number, business unit, type, or status.
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('agreement_number', 'like', "%{$search}%")
                  ->orWhere('business_unit', 'like', "%{$search}%")
                  ->orWhere('agreement_type', 'like', "%{$search}%")
                  ->orWhere('agreement_status', 'like', "%{$search}%");
            });
        }

        // If you want to filter specifically by "agreement_status" from a dropdown
        if ($request->filled('status')) {
            $query->where('agreement_status', $request->status);
        }

        // Optional date range filtering (advanced feature)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('effective_date', [$request->input('from_date'), $request->input('to_date')]);
        }

        // Sorting logic if needed
        // e.g. $query->orderBy('agreement_number', 'asc');

        $agreements = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('agreements.index', compact('agreements'));
    }

    /**
     * Show the form for creating a new agreement.
     */
    public function create()
    {
        return view('agreements.create');
    }

    /**
     * Store a newly created agreement in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'agreement_number'       => 'required|string|max:50|unique:agreements',
            'legal_entity'           => 'required|string|max:20',
            'business_unit'          => 'required|string|max:10',
            'agreement_type'         => 'required|string|max:20',
            'agreement_status'       => 'required|string|max:20',
            'agreement_amount'       => 'nullable|numeric',
            'minimum_release_amount' => 'nullable|numeric',
            'released_amount'        => 'nullable|numeric',
            'effective_date'         => 'nullable|date',
            'expiration_date'        => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Agreement::create($request->all());

        return redirect()->route('agreements.index')->with('success', 'Agreement created successfully.');
    }

    /**
     * Display the specified agreement.
     */
    public function show($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('agreements.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified agreement.
     */
    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('agreements.edit', compact('agreement'));
    }

    /**
     * Update the specified agreement in storage.
     */
    public function update(Request $request, $id)
    {
        $agreement = Agreement::findOrFail($id);

        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'agreement_number'       => 'required|string|max:50|unique:agreements,agreement_number,' . $agreement->id,
            'legal_entity'           => 'required|string|max:20',
            'business_unit'          => 'required|string|max:10',
            'agreement_type'         => 'required|string|max:20',
            'agreement_status'       => 'required|string|max:20',
            'agreement_amount'       => 'nullable|numeric',
            'minimum_release_amount' => 'nullable|numeric',
            'released_amount'        => 'nullable|numeric',
            'effective_date'         => 'nullable|date',
            'expiration_date'        => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $agreement->update($request->all());

        return redirect()->route('agreements.index')->with('success', 'Agreement updated successfully.');
    }

    /**
     * Remove the specified agreement from storage.
     */
    public function destroy($id)
    {
        $agreement = Agreement::findOrFail($id);
        $agreement->delete();

        return redirect()->route('agreements.index')->with('success', 'Agreement deleted successfully.');
    }

    /**
     * Export agreements to CSV.
     */
    public function export()
    {
        $agreements = Agreement::all();

        $filename = "agreements_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'Agreement Number', 'Legal Entity', 'Business Unit',
            'Agreement Type', 'Agreement Status', 'Agreement Amount',
            'Minimum Release Amount', 'Released Amount', 'Effective Date', 'Expiration Date'
        ];

        $callback = function() use ($agreements, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($agreements as $agreement) {
                fputcsv($file, [
                    $agreement->id,
                    $agreement->agreement_number,
                    $agreement->legal_entity,
                    $agreement->business_unit,
                    $agreement->agreement_type,
                    $agreement->agreement_status,
                    $agreement->agreement_amount,
                    $agreement->minimum_release_amount,
                    $agreement->released_amount,
                    $agreement->effective_date,
                    $agreement->expiration_date,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Bulk Upload form for CSV/Excel updates (optional).
     */
    public function bulkUploadForm()
    {
        return view('agreements.bulk_upload');
    }

    /**
     * Handle the bulk upload of new or updated agreements (CSV).
     */
    public function bulkUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimetypes:text/csv,text/plain,application/csv,application/octet-stream'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $filePath = $request->file('csv_file')->store('temp');
        $fullPath = storage_path('app/'.$filePath);

        $handle = fopen($fullPath, 'r');
        $rowCount = 0;
        $createdCount = 0;
        $updatedCount = 0;

        // Optionally skip header row
        // fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $rowCount++;
            // Suppose each row is:
            // 0 => agreement_number, 1 => legal_entity, 2 => business_unit, 3 => agreement_type,
            // 4 => agreement_status, 5 => agreement_amount, 6 => minimum_release_amount,
            // 7 => released_amount, 8 => effective_date, 9 => expiration_date

            $agreementNumber = $data[0] ?? null;
            if (!$agreementNumber) {
                // skip if no agreement number
                continue;
            }

            $agreement = Agreement::where('agreement_number', $agreementNumber)->first();

            $fields = [
                'agreement_number'       => $agreementNumber,
                'legal_entity'           => $data[1] ?? '',
                'business_unit'          => $data[2] ?? '',
                'agreement_type'         => $data[3] ?? '',
                'agreement_status'       => $data[4] ?? 'Draft',
                'agreement_amount'       => $data[5] ?? null,
                'minimum_release_amount' => $data[6] ?? null,
                'released_amount'        => $data[7] ?? null,
                'effective_date'         => $data[8] ?? null,
                'expiration_date'        => $data[9] ?? null,
            ];

            // If found, update. Otherwise create new
            if ($agreement) {
                $agreement->update($fields);
                $updatedCount++;
            } else {
                Agreement::create($fields);
                $createdCount++;
            }
        }

        fclose($handle);
        Storage::delete($filePath);

        return redirect()->route('agreements.index')->with('success', 
            "Processed {$rowCount} rows. {$createdCount} created, {$updatedCount} updated."
        );
    }
}
