<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function lifecycle()
    {
        $orders = Order::all(); // or filter by the logged-in user
        // dd($orders);
        return view('orders.lifecycle', compact('orders'));
    }
    

// Optional: Move order to the next status in the lifecycle
public function updateStatus(Order $order)
{
    // If you have an ownership check:
    // $supplier = Auth::user();
    // if ($order->supplier_id !== $supplier->id) { abort(403); }

    // Call the helper to increment status
    $order->moveToNextStatus();

    return redirect()->route('orders.show', $order->id)
        ->with('success', 'Order status updated to: ' . $order->status);
}

    // Optional: Move order to the next status in the lifecycle
    public function updateStatus2(Order $order)
    {
        $supplier = Auth::user();

        if ($order->supplier_id !== $supplier->id) {
            abort(403, 'Unauthorized action.');
        }

        // Call the helper to increment status
        $order->moveToNextStatus();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order status updated to: ' . $order->status);
    }

    /**
     * Display a listing of orders with advanced search.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Search by order number or status.
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('order_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }

        // Optional date range filtering on requested delivery date.
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('requested_delivery_date', [$request->input('from_date'), $request->input('to_date')]);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number'            => 'required|string|max:50|unique:orders',
            'status'                  => 'required|string|max:50',
            'change_order_status'     => 'nullable|string|max:50',
            'requested_delivery_date' => 'nullable|date',
            'promised_delivery_date'  => 'nullable|date',
            'acknowledge_due_date'    => 'nullable|date',
            'pdf_url'                 => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Order::create($request->all());
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'order_number'            => 'required|string|max:50|unique:orders,order_number,' . $order->id,
            'status'                  => 'required|string|max:50',
            'change_order_status'     => 'nullable|string|max:50',
            'requested_delivery_date' => 'nullable|date',
            'promised_delivery_date'  => 'nullable|date',
            'acknowledge_due_date'    => 'nullable|date',
            'pdf_url'                 => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Export orders to CSV.
     */
    public function export()
    {
        $orders = Order::all();
        $filename = "orders_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        $columns = [
            'ID', 'Order Number', 'Status', 'Change Order Status', 'Requested Delivery Date', 'Promised Delivery Date', 'Acknowledge Due Date', 'PDF URL'
        ];
        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->order_number,
                    $order->status,
                    $order->change_order_status,
                    $order->requested_delivery_date,
                    $order->promised_delivery_date,
                    $order->acknowledge_due_date,
                    $order->pdf_url,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Custom action to acknowledge an order.
     */
    public function acknowledge($id)
    {
        $order = Order::findOrFail($id);
        // Update the status to "Acknowledged" (or another status as per your business logic)
        $order->update(['status' => 'Acknowledged']);
        return redirect()->route('orders.show', $id)->with('success', 'Order acknowledged successfully.');
    }

    public function schedules()
    {
        // In a full implementation, you'd retrieve and pass schedules related to orders.
        return view('orders.schedules');
    }

    /**
     * Display the Acknowledge Schedules via Spreadsheet view.
     *
     * @return \Illuminate\View\View
     */
    public function acknowledgeSpreadsheet()
    {
        // This view could include a form to upload a spreadsheet.
        return view('orders.acknowledge_spreadsheet');
    }

    /**
     * Display the Order Lifecycle view.
     *
     * @return \Illuminate\View\View
     */
    


    /**
 * Display the Order Lifecycle page for a specific order.
 */
public function lifecycle2($id)
{
    $order = Order::findOrFail($id);

    // If you have a supplier or user-based ownership check, do it here:
    // if ($order->supplier_id !== Auth::id()) { abort(403); }

    // Now pass the order to a dedicated Blade view.
    return view('orders.lifecycle', compact('order'));
}

}
