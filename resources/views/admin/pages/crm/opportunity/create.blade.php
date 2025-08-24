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
                                    <table id="table3" class="w-100">
                                        <thead>
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
