@include('inc.header')

<div class="container">
    <div class="row my-4">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-secondary-subtle sales-header">
                    <h4 class="text-center">Add Sales</h4>
                    <div class="card-body p-4">
                        <span class='alert text-success' id="responseMessage"></span>
                        <form action="#" method="post" id="add_form">
                            @csrf
                            <div id="show_item">
                                <div class="row align-items-center item-row">

                                    <div class="col-md-12 mt-4 text-end">
                                        <a class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" id="add_row">Add More</a>
                                        <!-- add_item_btn -->
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <input type="submit" value="Save" class="btn btn-primary w-20 d-none" id="add_btn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="sales-header p-5">
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                            <div class="input-group-outline focused is-focused">
                                <label class="form-label">Category</label>
                                <select name="cat_id[]" class="form-control" placeholder="Select Category"
                                    id="category_selectID" required>
                                    <option value="">Select Category </option>
                                    @foreach($category as $data)
                                    <option value="{{$data->id}}">{{$data->category}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group-outline focused is-focused">
                                <label class="form-label">Product</label>
                                <select name="product_name[]" id="productNAME" class="form-control"
                                    placeholder="Select Product" required>
                                    <option value="">Select Product </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group-outline focused is-focused">
                                <label class="form-label">Stock</label>
                                <input type="text" id="stockDATA" name="stock[]" class="form-control"
                                    placeholder="Product Stock" required>
                            </div>
                            <span class="aler text-danger" id="alreadystock"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <a class="btn btn-success save_data" data-bs-dismiss="modal">Add</a>
            </div>
        </div>
    </div>
</div>




@include('inc.footer')

<!-- <script>
    $(document).ready(function () {
        $(".add_item_btn").click(function (e) {
            e.preventDefault();
            $("#show_item").append(`
                <div class="row align-items-center item-row">
                    <div class="col-md-4 mb-3">
                        <div class="input-group-outline focused is-focused">
                            <label class="form-label">Category</label>
                            <select name="cat_id[]" class="form-control" placeholder="Select Category" id="category_select" required>
                            <option value="">Select Category </option>
                            @foreach($category as $data)
                            <option value="{{$data->id}}">{{$data->category}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="input-group-outline focused is-focused">
                            <label class="form-label">Product</label>
                            <select name="product_name[]" class="form-control" placeholder="Select Product" id="product_select" >
                                <option value="">Select Product </option>                                        
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="input-group-outline focused is-focused">
                            <label class="form-label">Stock</label>
                            <input type="number" id="stock_product" name="stock[]" class="form-control"
                                placeholder="Product Stock" required>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button class="btn btn-danger remove_item_btn">Remove</button>
                    </div>
                </div>`);

        });


        $("#show_item").on("click", ".remove_item_btn", function (e) {
            e.preventDefault();
            $(this).closest(".item-row").remove();
        });

        $('#add_form').submit(function (e) {
            e.preventDefault();
            $('#add_btn').val('Save');

            $.ajax({
                type: 'post',
                url: 'submitsales',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script> -->



<script>
    $(document).ready(function () {
        $('#category_select').change(function () {
            var category = $('#category_select').val();

            $.ajax({

                type: 'POST',
                url: 'getproduct',
                data: {
                    'cat_id': category,
                    '_token': '{{ csrf_token() }}',
                },
                success: function (response) {
                    var productNames = response.split(', ');
                    var selectElement = document.getElementById('product_select');

                    selectElement.innerHTML = '';
                    var defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.text = 'Select Product';
                    selectElement.appendChild(defaultOption);

                    for (var i = 0; i < productNames.length; i++) {
                        var option = document.createElement('option');
                        option.value = productNames[i];
                        option.text = productNames[i];
                        selectElement.appendChild(option);
                    }

                }
            });
        });

        $('#product_select').change(function () {
            var product = $('#product_select').val();
            if (product) {
                $.ajax({
                    type: 'POST',
                    url: 'getstock',
                    data: {
                        'product_name': product,
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        stockQUANTITY = response;
                        if (stockQUANTITY) {
                            $('#stock_product').val(stockQUANTITY);
                        }

                    }
                });
            }
            else {
                $('#stock_product').val('');
            }
        });

    });
</script>

<script>
    $(document).ready(function () {
        $('#category_selectID').change(function () {
            var category = $('#category_selectID').val();

            $.ajax({

                type: 'POST',
                url: 'getproduct',
                data: {
                    'cat_id': category,
                    '_token': '{{ csrf_token() }}',
                },
                success: function (response) {
                    var dataArray = response.split('|');
                    var productNames = dataArray[0].split(', ');
                    var productIds = dataArray[1].split(', ');

                    var selectElement = $('#productNAME');
                    selectElement.empty();

                    var defaultOption = $('<option>').val('').text('Select Product');
                    selectElement.append(defaultOption);

                    for (var i = 0; i < productNames.length; i++) {
                        var option = $('<option>').val(productIds[i]).text(productNames[i]);
                        selectElement.append(option);
                    }

                }
            });
        });

        $('#productNAME').change(function () {
            var product = $('#productNAME').val();
            if (product) {
                $.ajax({
                    type: 'POST',
                    url: 'getstock',
                    data: {
                        'product_ID': product,
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        stockQUANTITY = response;
                        if (stockQUANTITY) {
                            $('#stockDATA').val(stockQUANTITY);
                        }

                    }
                });
            }
            else {
                $('#stockDATA').val('');
            }
        });

    });
</script>


<script>
    $(document).ready(function () {
        $(".save_data").click(function (e) {
            e.preventDefault();
            var selectedCategory = $('#category_selectID option:selected').text();
            var selectedProduct = $('#productNAME option:selected').text();
            var selectedStock = $('#stockDATA').val();
            var catId = $('#category_selectID option:selected').val();
            var selectedProductID = $('#productNAME option:selected').val();


            $('#show_item').append(` <div class="row align-items-center item-row">
            <div class="col-md-4 mb-3">
                <div class="input-group-outline focused is-focused">
                    <label class="form-label">Category</label>                           
                    <input type="hidden" name="cat_id_hidden[]" class="form-control" value="${catId}">
                    <input type="text" name="cat_id[]" class="form-control" placeholder="Select Category" value="${selectedCategory}" readonly>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="input-group-outline focused is-focused">
                    <label class="form-label">Product</label>
                    <input type="hidden" name="pro_id[]" class="form-control" value="${selectedProductID}">
                    <input type="text" name="product_name[]" class="form-control" placeholder="Select Product" value="${selectedProduct}" readonly>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="input-group-outline focused is-focused">
                    <label class="form-label">Stock</label>
                    <input type="number" id="stock_product" name="stock[]" class="form-control"
                        placeholder="Product Stock" value="${selectedStock}" readonly>
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <button class="btn btn-danger remove_item_btn">Remove</button>
            </div>
        </div>`);
            $('#add_btn').removeClass('d-none')
        });

        $("#show_item").on("click", ".remove_item_btn", function (e) {
            e.preventDefault();
            $(this).closest(".item-row").remove();
        });

        $('#add_form').submit(function (e) {
            e.preventDefault();
            $('#add_btn').val('Save');

            $.ajax({
                type: 'post',
                url: 'submitsales',
                data: $(this).serialize(),
                success: function (response) {
                    // $('#responseMessage').text(response);
                    // var timeout = 3000;
                    // $('.alert').delay(timeout).fadeOut(300);
                    // $('#add_btn').remove();
                    console.log(response);

                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        
        $("#stockDATA").keyup(function() {
            var stock = $("#stockDATA").val();
            if (!/^\d+$/.test(stock)) { 
                $("#alreadystock").html("The stock must be a number.");
            } else {
                $("#alreadystock").html("");
            }
        });
        
        
    });
</script>

<script>
    $(document).ready(function () {
   
        $("#add_row").click(function () {
            $("#category_selectID").val(""); 
            $("#productNAME").val("");
            $("#stockDATA").val("");
            $("#alreadystock").html("");
        });
    });
</script>