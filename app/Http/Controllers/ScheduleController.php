<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     * Optionally filter by order_number, date range, or status.
     */
    public function index(Request $request)
    {
        $query = Schedule::with('order');

        // Filter by order number
        if ($request->filled('order_number')) {
            $orderNum = $request->order_number;
            $query->whereHas('order', function($q) use ($orderNum) {
                $q->where('order_number', 'like', "%{$orderNum}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter (on requested_date, for example)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('requested_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $schedules = $query->orderBy('requested_date', 'asc')->paginate(10);

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        // We might pass a list of orders to choose from
        $orders = Order::all();
        return view('schedules.create', compact('orders'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'       => 'required|exists:orders,id',
            'requested_date' => 'required|date',
            'promised_date'  => 'nullable|date',
            'status'         => 'required|string|max:50',
            'remarks'        => 'nullable|string|max:255',
            'quantity'       => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Schedule::create($request->all());

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified schedule.
     */
    public function show($id)
    {
        $schedule = Schedule::with('order')->findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $orders   = Order::all();
        return view('schedules.edit', compact('schedule', 'orders'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_id'       => 'required|exists:orders,id',
            'requested_date' => 'required|date',
            'promised_date'  => 'nullable|date',
            'status'         => 'required|string|max:50',
            'remarks'        => 'nullable|string|max:255',
            'quantity'       => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule->update($request->all());

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    /**
     * Set the schedule status to "Acknowledged".
     */
    public function acknowledge($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'Acknowledged']);

        return redirect()->route('schedules.show', $id)
            ->with('success', 'Schedule acknowledged successfully.');
    }

    /**
     * Display a form for bulk uploading schedules or acknowledgements via CSV.
     */
    public function bulkUploadForm()
    {
        return view('schedules.bulk_upload');
    }

    /**
     * Handle the uploaded CSV, updating or creating schedules in bulk.
     */
    public function bulkUpload(Request $request)
    {
        // Very minimal example. 
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimetypes:text/csv,text/plain,application/csv,application/octet-stream',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $filePath = $request->file('csv_file')->store('temp');
        $fullPath = storage_path('app/'.$filePath);

        // Open file, parse lines, assume each line has columns: 
        // order_number, requested_date, promised_date, status, remarks, quantity
        $handle = fopen($fullPath, 'r');
        $rowCount = 0;
        $updatedCount = 0;
        $createdCount = 0;

        // Skip header row if present
        // fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $rowCount++;
            // Example indexing if each line has:
            // 0 => order_number, 1 => requested_date, 2 => promised_date, 3 => status, 4 => remarks, 5 => quantity

            $orderNumber = $data[0] ?? null;
            $requested   = $data[1] ?? null;
            $promised    = $data[2] ?? null;
            $status      = $data[3] ?? 'Pending';
            $remarks     = $data[4] ?? null;
            $quantity    = $data[5] ?? null;

            // Find the order
            $order = Order::where('order_number', $orderNumber)->first();
            if (!$order) {
                // skip or create a new order if your logic allows
                continue;
            }

            // Attempt to find an existing schedule with this order & requested_date
            $schedule = Schedule::where('order_id', $order->id)
                ->where('requested_date', $requested)
                ->first();

            if ($schedule) {
                // Update
                $schedule->update([
                    'promised_date' => $promised,
                    'status'        => $status,
                    'remarks'       => $remarks,
                    'quantity'      => $quantity
                ]);
                $updatedCount++;
            } else {
                // Create
                Schedule::create([
                    'order_id'       => $order->id,
                    'requested_date' => $requested,
                    'promised_date'  => $promised,
                    'status'         => $status,
                    'remarks'        => $remarks,
                    'quantity'       => $quantity
                ]);
                $createdCount++;
            }
        }

        fclose($handle);
        Storage::delete($filePath);

        return redirect()->route('schedules.index')->with('success', 
            "Processed {$rowCount} lines. {$updatedCount} updated, {$createdCount} created."
        );
    }
}
