<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Customer;
use App\Models\Item;
use App\Models\SubItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $invoices = Invoice::with('customer')->latest()->paginate(5);

    return view('invoices.index', compact('invoices'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $customers = Customer::latest()->paginate(5);
    $items = Item::latest()->paginate(5);
    $sub_items = SubItem::latest()->paginate(5);

    $data = [
      'customers' => $customers,
      'items' => $items,
      'sub_items' => $sub_items,
    ];

    return view('invoices.create')->with('data', $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // dd($request);

    $invoice = new Invoice;

    $invoice->customer_id = $request->input('customer');
    $invoice->subject = $request->input('subject');
    $invoice->subtotal = $request->input('sub-total');
    $invoice->due_date = $request->input('due-date');
    $invoice->payments = $request->input('payments');
    $invoice->tax = $request->input('tax');
    // $invoice->status = 'unpaid';

    $invoice->save();
    $invoice_id = $invoice->id;

    $data = [];

    for ($i = 0; $i < sizeof($request->input('item')); $i++) {
      $invoice_detail = [
        'sub_item_id' => $request->input('description')[$i],
        'quantity' => $request->input('quantity')[$i],
        'invoice_id' => $invoice_id,
        'amount' => $request->input('amount')[$i],
      ];

      array_push($data, $invoice_detail);
    }

    InvoiceDetail::insert($data);
    return redirect()->route('invoices.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function show(Invoice $invoice)
  {
    $customer = Customer::find($invoice);
    $invoiceDetails = InvoiceDetail::with(['subitem', 'subitem.item'])->whereBelongsTo($invoice)->get();
    $data = [
      'details' => $invoiceDetails,
      'invoice' => $invoice,
      'customer' => $customer,
    ];

    return view('invoices.show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function edit(Invoice $invoice)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Invoice $invoice)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function destroy(Invoice $invoice)
  {
    $invoice->delete();

    return redirect()->route('invoices.index');
  }
}