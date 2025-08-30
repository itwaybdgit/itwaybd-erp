@extends('admin.master')


@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Create' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label for="">Choose Lead <span style="color: red">*</span></label>
                                    <select name="lead_generation_id" id="lead_generation_id"
                                            class="form-control lead_generation_id select2" required>
                                        <option value="">Select Lead</option>
                                        @foreach ($leads as $val)
                                            <option value="{{ $val->id }}">{{ $val->company_owner_name?:$val->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lead_generation_id')
                                    <span class="error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="">Choose recurring Type <span style="color: red">*</span></label>
                                    <select name="recurring_type" class="form-control" required>
                                        <option value="Project">Project</option>
                                        <option value="Monthly_Subscription">Monthly Subscription</option>
                                        <option value="Yearly_Subscription">Yearly Subscription</option>
                                    </select>
                                    @error('recurring_type')
                                    <span class="error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Commission </label>
                                    <input type="text" name="commission" class="form-control">
                                </div>
                            </div>


                                <hr>
                                <div class="col-md-12 mb-1">
                                    <table id="table3" class="w-100 ">
                                        <thead>
                                        <tr>
                                            <th colspan="8">Select Service Item</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" width="25%">
                                                <small class="text-secondary">Category <span
                                                        class="text-danger">*</span></small>
                                            </th>
                                            <th scope="col" width="25%">
                                                <small class="text-secondary">Item <span
                                                        class="text-danger">*</span></small>
                                            </th>
                                            <th scope="col" width="20%">
                                                <small class="text-secondary">Quantity <span
                                                        class="text-danger">*</span></small>
                                            </th>
                                            <th scope="col" width="25%"><span class="text-danger">*</span>
                                                <small class="text-secondary">Asking Price</small>
                                            </th>

                                            <th scope="col" width="10%">
                                                <small class="text-secondary">Action</small>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="package">
                                        <tr>
                                            <th>
                                                <!-- Category Dropdown -->
                                                <select name="category_id[]" id="category_id"
                                                        class="form-control category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <!-- Item Dropdown -->
                                                <select name="item_id[]" id="item_id" class="form-control item_id"
                                                        required>
                                                    <option value="">Select Item</option>
                                                    <!-- Items will be loaded here based on the selected category -->
                                                </select>
                                            </th>


                                            <th>
                                                <input type="number" value="" name="quantity[]"
                                                       class="form-control qty " required>
                                            </th>
                                            <th>
                                                <input type="text" value="" name="asking_price[]"
                                                       class="form-control rate " required>
                                            </th>
                                            <th>
                                                <button class="btn btn-danger remove w-100">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: right;">
                                                <button type="button" class="btn btn-success aligh-right"
                                                        id="addrow">
                                                    Add New
                                                </button>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <hr>
                                <div class="col-md-12 mb-1">
                                    <table id="show_item" class="w-100">
                                        <thead>
                                        <tr>
                                            <th colspan="8">Select Product Item</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Category</td>
                                            <td class="text-center" width="20%">Product</td>
                                            <td class="text-center">Quantity</td>
                                            <td class="text-center">Unit Price</td>
                                            <td class="text-center">Total</td>
                                            <td class="text-center" style="width: 10%">Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select onchange="getProductList(this.value)"
                                                        class="form-control catName reset" id="form-field-select-3"
                                                        data-placeholder="Search Category">
                                                    <option disabled selected>---Select Category---</option>
                                                    @foreach ($category_info as $eachInfo)
                                                        <option catName="{{ $eachInfo->name }}"
                                                                value="{{ $eachInfo->id }}">
                                                            {{ $eachInfo->name }} ({{ $eachInfo->products_count }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control proName reset" id="productID"
                                                        data-placeholder="Search Product" onchange="getUnitPrice(this.value)">
                                                    <option disabled selected>---Select Product---</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="any"
                                                       class="form-control text-right buildColumn qty reset_qty"
                                                       oninput="customColumn()" placeholder="Qty" min="0">
                                            </td>
                                            <td>
                                                <input type="number" step="any" min="0" id="unitprice"
                                                       class="form-control text-right unitprice reset_unitprice"
                                                       placeholder="Unit Price">
                                            </td>
                                            <td>
                                                <input type="number" step="any" readonly
                                                       class="form-control text-right total reset_total" id="total"
                                                       placeholder="Total">
                                            </td>
                                            <td class="text-center">
                                                <!-- <button id="add_item" type="button" class="btn btn-info open_model btn-sm"
                                                                                                                                                                                                            style="white-space: nowrap" data-toggle="modal" data-target="#xlarge"
                                                                                                                                                                                                            href="javascript:;" title="Add Item">
                                                                                                                                                                                                            <i class="far fa-clipboard"></i>
                                                                                                                                                                                                        </button> -->
                                                <a id="add_item" class="btn btn-info " style="white-space: nowrap"
                                                   href="javascript:;" title="Add Item">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>
                                        <tfoot>
                                        <tr>
{{--                                            <td class="text-right"><strong>Sub-Total(BDT)</strong></td>--}}
{{--                                            <td class="text-right"><strong class=""></strong></td>--}}
{{--                                            <td class="text-right"><strong class="ttlqty"></strong>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-right"><strong class="ttlunitprice"></strong></td>--}}
{{--                                            <td class="text-right"><strong class="grandtotal"></strong></td>--}}
{{--                                            <td class="text-right"><strong class=""></strong></td>--}}
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>




                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>

                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#myForm').submit(function(event) {
                                var licenseType = $('select[name="license_type"]').val();
                                if (licenseType === '') {
                                    alert('Please choose a license type.');
                                    event.preventDefault(); // Prevent form submission
                                }
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function customColumn() {

            let productName = $('.buildColumn').closest('tr').find('.proName option:selected').attr('proname'); //proname
            let product = $('.buildColumn').closest('tr').find('.proName option:selected').val(); //product
            let columnNum = $('.buildColumn').closest('tr').find('.proName option:selected').attr('column'); //column
            let row = $('.buildColumn').closest('tr').find('.qty').val(); //row
            let html = "";
            if (Number(columnNum) != 0) {
                Array(Number(row)).fill(0).map((_, ind) => {
                    html += `<tr class="productid` + product + ` d-none">`;
                    html += `<input type="hidden" name="stock_product_id[]" class="form-control" value="` +
                        product + `" />`;
                    Array(Number(columnNum)).fill(0).map((_, ind) => {
                        html += `<th>`;
                        html += `<input name="column_` + numberToWord(ind + 1) +
                            `[]" class="form-control"/>`;
                        html += `</th>`;
                    })
                    html += `</tr>`;
                })
            }
            $('.productid' + product).remove();
            $('#custome_column_list').append(html);
            console.log('colume Number ' + columnNum + "<br>,Row " + row);
        }
        function number_format(number, decimal = 2) {
            number = Number(number);
            return Number(parseFloat(number).toFixed(decimal));
        }
        var findqtyamoun = function() {
            var ttlqty = 0;
            $.each($('.ttlqty'), function() {
                qty = number_format($(this).val());
                ttlqty += qty;
            });
            $('.ttlqty').text(number_format(ttlqty));
        };

        var findunitamount = function() {
            var ttlunitprice = 0;
            $.each($('.ttlunitprice'), function() {
                unitprice = number_format($(this).val());
                ttlunitprice += unitprice;
            });
            $('.ttlunitprice').text(number_format(ttlunitprice));
        };

        var findgrandtottal = function() {
            $('.reset_unitprice').val('');
            $('.reset_qty').val('');
            $('.reset_total').val('');
            $(".reset").val(null).trigger("change");

            var grandtotal = 0;

            $.each($('.total'), function(index, item) {
                total = number_format($(item).val());
                grandtotal += total;
            });

            // let vatE = $('.vat');
            let discountE = $('.discount');
            let paidAmountE = $('.paid_amount');

            let vat = 0; //number_format(vatE.val());
            let discount = number_format(discountE.val());
            let paidAmount = number_format(paidAmountE.val());

            //calculate discount
            let cal_vat = percentageCalculate(grandtotal, vat);


            let cal_grandtotal = grandTotalCalculate(grandtotal, discount, cal_vat);
            let cal_due = dueCalculate(cal_grandtotal, paidAmount);

            let cart_net_total = $('.cart_net_total');
            let cart_due = $('.cart_due');
            let paid_amount = $('.paid_amount');

            $('.grandtotal').text(number_format(grandtotal));
            cart_net_total.text(cal_grandtotal);
            cart_due.text(cal_due);
            $('.input_vat').val(cal_vat);
            $('.input_net_total').val(cal_grandtotal);

            let paymenttypes = $('.payment_type').val();
            if (paymenttypes.toLowerCase() == 'cash' || paymenttypes.toLowerCase() == 'check') {
                paid_amount.val(cal_grandtotal);
                $('#submit').prop('disabled', false);
            }
            $('.input_due').val(cal_due);

        };


        $(document).on('click', '#add_item', function() {

            var parent = $(this).parents('tr');
            var supid = $('.supid').val();
            var catId = $('.catName').val();
            var catName = $(".catName").find('option:selected').attr('catName');
            var proId = $('.proName').val();
            var proName = $(".proName").find('option:selected').attr('proName');
            var qty = number_format(parent.find('.qty').val());
            var unitprice = number_format(parent.find('.unitprice').val());


            // if (supid == '' || supid == null) {
            //     alertMessage.error("Supplier can't be empty.");
            //     return false;
            // }
            if (catId == '' || catId == null) {
                alertMessage.error("Category can't be empty.");
                return false;
            }
            if (proId == '' || proId == null) {
                alertMessage.error("Product can't be empty.");
                return false;
            }

            // start check duplicate product
            let seaschproduct = $('#productID option:selected')[0].getAttribute("value");
            let tbody = $('tbody').find(".new_item" + seaschproduct).length;
            let tbody2 = $('tbody').find("new_item" + seaschproduct);
            console.log(tbody);

            if (tbody > 0) {
                alertMessage.error('This product already exist');
                return;
            }

            // end check duplicate product

            if (qty == '' || qty == null || qty == 0) {
                alertMessage.error('Quantity cannot be empty');
                return false;
            } else {
                var total = qty * unitprice;

                var grandtotal = 0;

                $.each($('.checktotal'), function(index, item) {

                    totaltt = number_format($(item).val());
                    grandtotal += totaltt;
                });





                const row = `
            <tr class="new_item${proId}">
                <td style="padding-left:15px;">${catName}<input type="hidden" name="catName[]" value="${catId}"></td>
                <td class="text-right">${proName}<input type="hidden" class="add_quantity" product-id="${proId}" name="proName[]" value="${proId}"></td>

                <td class="text-right">${qty}<input type="hidden" class="ttlqty" name="qty[]" value="${qty}"></td>
                <td class="text-right">${unitprice}<input type="hidden" class="ttlunitprice" name="unitprice[]" value="${unitprice}">
                </td>
                <td class="text-right">${total}
                    <input type="hidden" class="total checktotal" name="total[]" value="${total}">
                </td>
                <td>
                    <a del_id="${proId}" class="delete_item btn btn-danger btn-sm" href="javascript:;" >
                        <i class="fa fa-times"></i>&nbsp;
                    </a>
                </td>
            </tr>
            `;
                $("#show_item tbody").append(row);
            }

            $('.reset_unitprice').val('');
            $('.reset_qty').val('');
            $('.reset_total').val('');
            $(".reset").val(null).trigger("change");

            findqtyamoun();
            findunitamount();
            findgrandtottal();
        });

        $(document).on('click', '.delete_item', function() {
            if (confirm('Are You Sure')) {
                let product_id = $(this).parents('tr').find('.add_quantity').val();
                $('.productid' + Number(product_id)).remove();
                $(this).parents('tr').remove();
                findqtyamoun();
                findunitamount();
                findgrandtottal();
            }
        });
        $(document).on('input', '.qty', function() {
            let self = $(this);
            let parent = self.parents('tr');
            let qty = number_format(self.val());

            if (qty == '' || qty == null) {
                $(this).val(1);
                qty = 1;
            }

            let unitPrice = number_format(parent.find('.unitprice').val());

            let total = number_format(unitPrice * qty);

            parent.find('.total').val(number_format(total));

        });

        // unit price to Quantity calculate
        $(document).on('input', '.unitprice', function() {

            let self = $(this);
            let parent = self.parents('tr');
            let unitprice = number_format(self.val());

            if (unitprice == '' || unitprice == null) {
                $(this).val(1);
                unitprice = 1;
            }

            let qty = number_format(parent.find('.qty').val());

            let total = number_format(unitprice * qty);

            parent.find('.total').val(number_format(total));

        });

        $(document).on('input', '.input-checker', function() {
            var grandtotal = $('.grandtotal').text();
            grandtotal = Number(grandtotal);

            if (isNaN(grandtotal) || grandtotal < 1) {
                alertMessage.error('Please Add some item first.');
                return false;
            }
            findgrandtottal();

        });
        function getProductList(cat_id) {
            if (cat_id == '' || cat_id == null || cat_id == 0) {
                return false;
            }
            $.ajax({
                "url": "{{ route('purchases.get.product') }}",
                "type": "GET",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    cat_id: cat_id
                },
                success: function(data) {
                    // $('#productID').select2();
                    $('#productID option').remove();
                    $('#productID').append($(data));
                    $("#productID").trigger("select2:updated");
                }
            });
        }

        function getUnitPrice(productId) {

            if (productId == '' || productId == null || productId == 0) {
                return false;
            }

            $.ajax({
                "url": "{{ route('purchases.unitPice') }}",
                "type": "GET",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    productId: productId
                },
                success: function(data) {
                    $("#unitprice").val(data);
                }
            });
        }
        $(document).ready(function() {
            $('.division_id').on('change', function() {
                let self = $(this);
                $.ajax({
                    "url": "{{ route('lead.division') }}",
                    "type": "GET",
                    "data": {
                        division_id: self.val()
                    },
                    cache: false,
                    success: function(data) {
                        $('.district_id').html(data);
                    }
                });
            })
            $('.district_id').on('change', function() {
                let self = $(this);
                $.ajax({
                    "url": "{{ route('lead.upazila') }}",
                    "type": "GET",
                    "data": {
                        district_id: self.val()
                    },
                    cache: false,
                    success: function(data) {
                        $('.upazila_id').html(data);
                    }
                });
            })
        });

        $('#newrow').on('click', function() {
            const addrow = `<tr>
                                                <td>
                                                    <input type="text" name="contact_person_name[]" class="form-control" >
                                                </td>
                                                <td>
                               <input type="text" name="contact_person_email[]" class="form-control" >
                           </td>
                                                <td>
                                                    <input type="tel" name="contact_person_phone[]" class="form-control" >
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger delete w-100">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
              `;
            $('.contact_row').append(addrow);
        })



        $('#addrow').on('click', function() {
            const addrow = `
        <tr>
                                                   <th>
                                                    <!-- Category Dropdown -->
                                                    <select name="category_id[]" id="category_id" class="form-control category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
            </select>
        </th>
        <th>
            <!-- Item Dropdown -->
            <select name="item_id[]" id="item_id" class="form-control item_id" required>
                <option value="">Select Item</option>
                <!-- Items will be loaded here based on the selected category -->
            </select>
        </th>
        <th>
            <input type="number" value="" name="quantity[]"
                class="form-control qty ">
        </th>
        <th>
            <input type="text" value="" name="asking_price[]"
                class="form-control rate ">
        </th>
        <th>
            <button class="btn btn-danger remove w-100">
                <i class="fas fa-trash-alt"></i>
            </button>
        </th>
    </tr>
`;
            $('.package').append(addrow);
        })

        $(document).on('change', '.item_id', function() {
            let thisval = $(this);
            $.ajax({
                'url': "{{ route('bandwidthsaleinvoice.getItemVal') }}",
                'method': "get",
                'dataType': "JSON",
                'data': {
                    item_id: thisval.val()
                },
                success: (data) => {
                    thisval.closest('tr').find('.unit').val(data.unit);
                    thisval.closest('tr').find('.vat').val(data.vat);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            $(this).closest('tr').remove();
        })

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        })

        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal);
            });
        }

        function getDay(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            return diffDays;
        }

        $(document).on('input', '.calculation', function() {
            let unitVal = Number($(this).closest('tr').find('.unit').val());
            let qtyVal = Number($(this).closest('tr').find('.qty').val());
            let rateVal = Number($(this).closest('tr').find('.rate').val());
            let vatVal = Number($(this).closest('tr').find('.vat').val());
            let from_date = $(this).closest('tr').find('.from_date').val() ? $(this).closest('tr').find(
                '.from_date').val() : '2022-12-1';
            let to_date = $(this).closest('tr').find('.to_date').val() ? $(this).closest('tr').find('.to_date')
                .val() : '2022-12-30';
            let countDay = getDay(from_date, to_date);
            let sum = qtyVal * rateVal
            let onedaysalary = sum / 30;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.total').val(total.toFixed(1));

            totalvalue();

        })

        $(document).on('change', ".category_id", function() {
            let categoryId = $(this).val();
            let $row = $(this).closest("tr"); // Get the current row

            // Clear previous items in the item dropdown
            $row.find('.item_id').html('<option value="">Select Item</option>');

            if (categoryId) {
                $.ajax({
                    url: '/admin/lead/get-items-by-category/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        // Populate the item dropdown with new options
                        $.each(data.items, function(key, item) {
                            $row.find('.item_id').append('<option value="' + item
                                .id + '">' + item.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error in AJAX request:", error);
                    }
                });
            }
        });
    </script>
@endsection
