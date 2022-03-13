@extends('layouts.app')

@php
// dump($data);
@endphp

@section('content')
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="{{ asset('images/invoice-logo.png') }}" alt="" width="72" height="72">
        <h2>Invoice Form</h2>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST" class="needs-validation" novalidate="">
        @csrf
        <div class="row">
            <div class="col-md">
                <div class="col-md-5 mb-3">
                    <label for="customer">Customer</label>
                    <select class="form-select" name="customer" aria-label="Default select example">
                        <option selected>---</option>
                        @foreach ($data['customers'] as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" class="form-control" id="subject" placeholder="" value=""
                        required="">
                </div>
                <div class="col-md-5 mb-3">
                    <label for="dueDate">Due Date</label>
                    <input type="date" name="due-date" class="form-control" id="dueDate" placeholder="" value=""
                        required="">
                </div>
                <div class="col-md-5 mb-3">
                    <label for="payments">Payments</label>
                    <input type="number" name="payments" class="form-control" id="payments" placeholder="" value=""
                        required="">
                </div>
                <div class="col-md">
                    <input type="hidden" name="sub-total" class="form-control" id="sub-total">
                    <input type="hidden" name="tax" class="form-control" id="tax">
                </div>
            </div>
        </div>
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
                            <th scope="col"><a id="add_row" class="btn btn-primary float-right">Add Row</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row0" data-id="0">
                            <td data-name="item">
                                <select class="form-select item-input" name="item[]" aria-label="Default select example">
                                    <option value="-" selected>---</option>
                                    @foreach ($data['items'] as $item)
                                        <option value="{{ $item->id }}">{{ ucwords($item->item_type) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-name="description">
                                <select class="form-select description-input" name="description[]"
                                    aria-label="Default select example">
                                    <option value="-" selected>---</option>
                                </select>
                            </td>
                            <td data-name="quantity">
                                <div class="col-md">
                                    <input type="number" name="quantity[]" class="form-control quantity-input" id="subject"
                                        placeholder="" value="" required="">
                                </div>
                            </td>
                            <td data-name="unit-price">
                                <div class="col-md">
                                    <input type="number" name="unit-price[]" class="form-control unit-price-input"
                                        id="subject" placeholder="" value="" required="" readonly>
                                </div>
                            </td>
                            <td data-name="amount">
                                <div class="col-md">
                                    <input type="number" name="amount[]" class="form-control amount-input" id="subject"
                                        placeholder="" value="" required="" readonly>
                                </div>
                            </td>
                            <td data-name="del">
                                <a name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span
                                        aria-hidden="true">×</span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <hr class="mb-4"> --}}
        <button id="submit" class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
    </form>
@endsection

@push('scripts')
    <script>
        function toTitleCase(str) {
            return str.replace(
                /\w\S*/g,
                function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                }
            );
        }

        const data = {!! json_encode($data) !!};
        const {
            sub_items
        } = data;
        console.log(data);

        $(document).ready(function() {
            $("#add_row").on("click", function() {

                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("table tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "row" + newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("table tbody tr:nth(0) td"), function() {
                    var td;
                    var cur_td = $(this);

                    var children = cur_td.children();

                    // add new td and element if it has a nane
                    if ($(this).data("name") !== undefined) {
                        td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });

                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                        c.attr("name", $(cur_td).data("name") + '[]');
                        if ($(this).data('name') === 'item' || $(this).data('name') ===
                            'description') {
                            $(c).val('-')
                        }
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }
                });

                // add the new row
                $(tr).appendTo($('table'));

                $(tr).find(".row-remove").on("click", function() {
                    $(this).closest("tr").remove();
                });

                $('.item-input').on('change', function(e) {
                    console.log('oi');
                    const changeVal = parseInt($(this).val());
                    const $descInput = $(this).closest('tr').find('.description-input');

                    const subItemsData = sub_items.data;
                    const filterBySelectedItem = subItemsData.filter(item => {
                        return item.item_id === changeVal
                    });

                    const holderDiv = [];
                    const defOption = $('<option selected="">---</option>')
                    holderDiv.push(defOption);
                    filterBySelectedItem.forEach(item => {
                        const option = $(
                            `<option value = "${item.id}"> ${toTitleCase(item.description)} </option>`
                        );
                        holderDiv.push(option);
                    });

                    $descInput.html(holderDiv);
                });

                $('.description-input').on('change', function(e) {
                    const changeVal = parseInt($(this).val());
                    const $priceInput = $(this).closest('tr').find('.unit-price-input');

                    const subItemsData = sub_items.data;
                    const subItem = subItemsData.find(item => item.id === changeVal);

                    let unitPrice = '';
                    if (subItem) {
                        unitPrice = subItem.unit_price;
                    }

                    $priceInput.val(unitPrice);
                    // const data = subItemsData.find(); 
                    const $amountInput = $(this).closest('tr').find('.amount-input');
                    const quantity = parseInt($(this).closest('tr').find('.quantity-input')
                        .val()) || 0;
                    const unitPriceVal = parseFloat($(this).closest('tr').find('.unit-price-input')
                        .val()) || 0;

                    const amount = unitPriceVal * quantity;
                    $amountInput.val(amount);
                });

                $('.quantity-input').on('change', function(e) {
                    const changeVal = parseInt($(this).val());
                    const $amountInput = $(this).closest('tr').find('.amount-input');
                    const unitPriceVal = parseFloat($(this).closest('tr').find('.unit-price-input')
                        .val()) || 0;

                    const amount = changeVal * unitPriceVal;
                    $amountInput.val(amount);
                });
            });

            $('.item-input').on('change', function(e) {
                console.log('oi');
                const changeVal = parseInt($(this).val());
                const $descInput = $(this).closest('tr').find('.description-input');

                const subItemsData = sub_items.data;
                const filterBySelectedItem = subItemsData.filter(item => {
                    return item.item_id === changeVal
                });

                const holderDiv = [];
                const defOption = $('<option selected="">---</option>')
                holderDiv.push(defOption);
                filterBySelectedItem.forEach(item => {
                    const option = $(
                        `<option value = "${item.id}"> ${toTitleCase(item.description)} </option>`
                    );
                    holderDiv.push(option);
                });

                $descInput.html(holderDiv);
            });

            $('.description-input').on('change', function(e) {
                const changeVal = parseInt($(this).val());
                const $priceInput = $(this).closest('tr').find('.unit-price-input');

                const subItemsData = sub_items.data;
                const subItem = subItemsData.find(item => item.id === changeVal);

                let unitPrice = '';
                if (subItem) {
                    unitPrice = subItem.unit_price;
                }

                $priceInput.val(unitPrice);
                // const data = subItemsData.find(); 
                const $amountInput = $(this).closest('tr').find('.amount-input');
                const quantity = parseInt($(this).closest('tr').find('.quantity-input').val()) || 0;
                const unitPriceVal = parseFloat($(this).closest('tr').find('.unit-price-input').val()) || 0;

                const amount = unitPriceVal * quantity;
                $amountInput.val(amount);
            });

            $('.quantity-input').on('change', function(e) {
                const changeVal = parseInt($(this).val());
                const $amountInput = $(this).closest('tr').find('.amount-input');
                const unitPriceVal = parseFloat($(this).closest('tr').find('.unit-price-input').val()) || 0;

                const amount = changeVal * unitPriceVal;
                $amountInput.val(amount);
            });

            $('#submit').on('click', function(e) {
                const amounts = $('.amount-input');
                console.log({
                    amounts
                });
                let subTotal = 0;
                amounts.each((index, item) => {
                    subTotal += parseFloat($(item).val());
                });

                const tax = subTotal * 10 / 100;

                $('#sub-total').val(subTotal);
                $('#tax').val(tax);
            });
        });
    </script>
@endpush
