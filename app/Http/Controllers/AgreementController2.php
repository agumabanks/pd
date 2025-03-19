<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agreement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class AgreementController extends Controller
{
    /**
     * Display a listing of the agreements with advanced search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
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

        // Optional date range filtering (advanced feature)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('effective_date', [$request->input('from_date'), $request->input('to_date')]);
        }

        $agreements = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('agreements.index', compact('agreements'));
    }

    /**
     * Show the form for creating a new agreement.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('agreements.create');
    }

    /**
     * Store a newly created agreement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('agreements.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified agreement.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('agreements.edit', compact('agreement'));
    }

    /**
     * Update the specified agreement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $agreement = Agreement::findOrFail($id);
        $agreement->delete();

        return redirect()->route('agreements.index')->with('success', 'Agreement deleted successfully.');
    }

    /**
     * Export agreements to CSV.
     *
     * @return \Illuminate\Http\Response
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
}
