@php
// dd($data);
@endphp


@extends('layouts.app')

@section('content')
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="{{ asset('images/invoice-logo.png') }}" alt="" width="72" height="72">
        <h2>Invoice Detail</h2>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="{{ route('invoices.index') }}" class="btn btn-danger btn-lg btn-block">Back</a>
        </div>
    </div>
    <div class="row bg-white">
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-2">From</div>
            <div class="col-sm-2">
                <div><b>Discovery Designs</b></div>
                <div>41 St Vincent Place</div>
                <div>Glasgow G1 2ER</div>
                <div>Scotland</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div>Invoice ID</div>
                <div>Issued Date</div>
                <div>Due Date</div>
                <div>Subject</div>
            </div>
            <div class="col-sm-6">
                <div><b>{{ $data['invoice']->id }}</b></div>
                <div>{{ $data['invoice']->created_at }}</div>
                <div>{{ $data['invoice']->due_date }}</div>
                <div>{{ $data['invoice']->subject }}</div>
            </div>
            <div class="col-sm-2">For</div>
            <div class="col-sm-2">
                <div><b>{{ $data['customer'][0]->name }}</b></div>
                <div>{{ $data['customer'][0]->address }}</div>
            </div>
        </div>
        <div class="row">&nbsp</div>
        <div class="row">&nbsp</div>
        <div class="row">
            <div class="col-md">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Item Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['details'] as $detail)
                            <tr id="row0" data-id="0">
                                <td>
                                    {{ ucwords($detail->subitem->item->item_type) }}
                                </td>
                                <td>
                                    {{ ucwords($detail->subitem->description) }}
                                </td>
                                <td>
                                    {{ $detail->quantity }}
                                </td>
                                <td>
                                    {{ $detail->subitem->unit_price }}
                                </td>
                                <td>
                                    {{ $detail->amount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">&nbsp</div>
        <div class="row">&nbsp</div>
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-2">
                <div>Subtotal</div>
                <div>Tax (10%)</div>
                <div>Payments</div>
            </div>
            <div class="col-sm-2">
                <div>{{ $data['invoice']->subtotal }}</div>
                <div>{{ $data['invoice']->tax }}</div>
                <div>{{ $data['invoice']->payments }}</div>
            </div>
        </div>
    </div>
@endsection
