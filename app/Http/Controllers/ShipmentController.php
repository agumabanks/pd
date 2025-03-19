<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentLine;
use App\Models\ShipmentReceipt;
use App\Models\ShipmentReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShipmentController extends Controller
{
    /**
     * INDEX: List all shipments with search & pagination.
     */
    public function index(Request $request)
    {
        $query = Shipment::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('shipment_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('incoterm', 'like', "%{$search}%");
        }

        $shipments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    /**
     * CREATE: Show form to create a new shipment.
     */
    public function create()
    {
        return view('shipments.create');
    }

    /**
     * STORE: Save a new shipment to the DB.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipment_number'      => 'required|string|max:50|unique:shipments',
            'status'               => 'required|string|max:50',
            'shipped_date'         => 'nullable|date',
            'expected_receipt_date'=> 'nullable|date',
            'actual_receipt_date'  => 'nullable|date',
            'incoterm'             => 'nullable|string|max:20',
            'shipping_method'      => 'nullable|string|max:50',
            'bol_awb_number'       => 'nullable|string|max:50',
            'comments'             => 'nullable|string',
        ]);

        // If you have an ASN file to upload
        // For example: $request->file('asn_file')...

        $shipment = Shipment::create($request->all());

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'Shipment created successfully.');
    }

    /**
     * SHOW: Display shipment details, lines, receipts, returns.
     */
    public function show($id)
    {
        $shipment = Shipment::with(['lines', 'receipts', 'returns'])->findOrFail($id);
        return view('shipments.show', compact('shipment'));
    }

    /**
     * EDIT: Show the form for editing an existing shipment.
     */
    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
        return view('shipments.edit', compact('shipment'));
    }

    /**
     * UPDATE: Modify an existing shipment.
     */
    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $request->validate([
            'shipment_number'      => 'required|string|max:50|unique:shipments,shipment_number,' . $shipment->id,
            'status'               => 'required|string|max:50',
            'shipped_date'         => 'nullable|date',
            'expected_receipt_date'=> 'nullable|date',
            'actual_receipt_date'  => 'nullable|date',
            'incoterm'             => 'nullable|string|max:20',
            'shipping_method'      => 'nullable|string|max:50',
            'bol_awb_number'       => 'nullable|string|max:50',
            'comments'             => 'nullable|string',
        ]);

        $shipment->update($request->all());

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'Shipment updated successfully.');
    }

    /**
     * DESTROY: Delete a shipment (and cascade lines, receipts, returns).
     */
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return redirect()->route('shipments.index')
                         ->with('success', 'Shipment deleted successfully.');
    }

    /**
     * CREATE LINE: Show form for adding a line item to the shipment.
     */
    public function createLine($shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);
        return view('shipments.create_line', compact('shipment'));
    }

    /**
     * STORE LINE: Add line item (partial shipment).
     */
    public function storeLine(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        $request->validate([
            'item_code'  => 'nullable|string|max:50',
            'description'=> 'nullable|string|max:255',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric',
        ]);

        $line = new ShipmentLine($request->all());
        $line->shipment_id = $shipment->id;
        $line->save();

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'Shipment line added successfully.');
    }

    /**
     * UPLOAD ASN: Attach the ASN doc to a shipment record.
     */
    public function uploadASN(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        $request->validate([
            'asn_file' => 'required|file|mimes:pdf,doc,docx,xlsx,xls,csv,jpg,png',
        ]);

        $fileName = time() . '-' . $request->file('asn_file')->getClientOriginalName();
        $path = $request->file('asn_file')->storeAs('public/asn_docs', $fileName);

        // Update or append to "attachments" field (store as JSON or text)
        $existing = $shipment->attachments ? json_decode($shipment->attachments, true) : [];
        $existing[] = $fileName;

        $shipment->attachments = json_encode($existing);
        $shipment->save();

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'ASN document uploaded successfully.');
    }

    /**
     * CREATE RECEIPT: Show form for receiving goods (partial or full).
     */
    public function createReceipt($shipmentId)
    {
        $shipment = Shipment::with('lines')->findOrFail($shipmentId);
        return view('shipments.create_receipt', compact('shipment'));
    }

    /**
     * STORE RECEIPT: Save actual receipt data.
     */
    public function storeReceipt(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        $request->validate([
            'shipment_line_id'   => 'nullable|exists:shipment_lines,id',
            'received_quantity'  => 'required|integer|min:1',
            'receipt_date'       => 'required|date',
            'remarks'            => 'nullable|string',
        ]);

        ShipmentReceipt::create([
            'shipment_id'      => $shipment->id,
            'shipment_line_id' => $request->input('shipment_line_id'),
            'received_quantity'=> $request->input('received_quantity'),
            'receipt_date'     => $request->input('receipt_date'),
            'remarks'          => $request->input('remarks'),
        ]);

        // Optionally update the shipment's status if fully received
        // Or partially if only partial lines are received, etc.
        // This is custom business logic as needed.

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'Receipt recorded successfully.');
    }

    /**
     * CREATE RETURN: Show form for returning goods (damaged, etc.).
     */
    public function createReturn($shipmentId)
    {
        $shipment = Shipment::with('lines')->findOrFail($shipmentId);
        return view('shipments.create_return', compact('shipment'));
    }

    /**
     * STORE RETURN: Save return data.
     */
    public function storeReturn(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        $request->validate([
            'shipment_line_id'  => 'nullable|exists:shipment_lines,id',
            'returned_quantity' => 'required|integer|min:1',
            'return_reason'     => 'nullable|string',
            'return_date'       => 'required|date',
        ]);

        ShipmentReturn::create([
            'shipment_id'       => $shipment->id,
            'shipment_line_id'  => $request->input('shipment_line_id'),
            'returned_quantity' => $request->input('returned_quantity'),
            'return_reason'     => $request->input('return_reason'),
            'return_date'       => $request->input('return_date'),
        ]);

        return redirect()->route('shipments.show', $shipment->id)
                         ->with('success', 'Return recorded successfully.');
    }


    public function createASN()
    {
        // If you need an existing shipment, you can pass an ID, e.g.:
        // $shipment = Shipment::findOrFail($shipmentId);
        // return view('shipments.create_asn', compact('shipment'));

        return view('shipments.create_asn');
    }

    /**
     * Show a form to create an ASBN.
     */
    public function createASBN()
    {
        return view('shipments.create_asbn');
    }

    /**
     * Show a form to upload an ASN or ASBN document.
     */
    public function uploadAsnAsbn()
    {
        return view('shipments.upload_asn_asbn');
    }

    /**
     * Display a page listing receipts.
     */
    public function viewReceipts()
    {
        // For demonstration, we might load all shipments that have receipts
        // but let's just show a 'coming soon' page or load a partial list
        // $shipmentsWithReceipts = Shipment::has('receipts')->get();

        return view('shipments.view_receipts' /*, compact('shipmentsWithReceipts') */);
    }

    /**
     * Display a page listing returns.
     */
    public function viewReturns()
    {
        // Similarly, we might load shipments that have returns
        // $shipmentsWithReturns = Shipment::has('returns')->get();

        return view('shipments.view_returns' /*, compact('shipmentsWithReturns') */);
    }
}
