@php
// dd($invoices);
@endphp


@extends('layouts.app')

@section('content')
    <div class="py-5 text-left">
        <img class="" src="{{ asset('images/invoice-logo.png') }}" alt="" width="72" height="72">
        <h2>Invoice Lists</h2>
    </div>
    <div class="row">
        <div class="col-sm-3 mb-3">
            <a href="{{ route('invoices.create') }}" class='btn btn-primary glyphicon glyphicon-remove row-remove'><span
                    aria-hidden="true">Add
                    Invoice</span></a>

        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">To</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Payments</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>
                                {{ $invoice->id }}
                            </td>
                            <td>
                                {{ $invoice->customer->name }}
                            </td>
                            <td>
                                {{ $invoice->subject }}
                            </td>
                            <td>
                                {{ $invoice->subtotal }}
                            </td>
                            <td>
                                {{ $invoice->payments }}
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                    class='btn btn-success fa Example of eye fa-eye'><span aria-hidden="true"></span></a>
                                {{-- <a href="" class='btn btn-primary fa fa-pencil-square-o'><span
                                        aria-hidden="true"></span></a> --}}
                                <a href="#"
                                    onclick="event.preventDefault();document.getElementById('destroy-form').submit();"
                                    class='btn btn-danger fa fa-trash'>
                                    <span aria-hidden="true"></span></a>
                                <form id="destroy-form" action="{{ route('invoices.destroy', $invoice->id) }}"
                                    method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
