@include('inc.header')


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class=" shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Product</h6>
                    </div>
                </div>
                <div class="nav-item d-flex align-items-center">
                    <a class="btn btn-outline-success bg-success text-white btn-sm mb-0 me-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"  href="#">Add +</a>
                </div>

                @if(session('success'))
                <div class="alert text-success">
                    {{ session('success') }}
                </div>
                @endif
                <span id="responseMessage" class=" alert text-success"></span>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="product-table">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ">Sr. No.</th>
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Category Name</th>
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Product Name</th>
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Price</th>
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Stock</th>
                                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($product as $data)

                                <tr class="text-center">


                                    <td>
                                        <h6 class="mb-0 text-sm">{{$loop->index+1}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="mb-0 text-sm">

                                            @foreach($category as $cat)
                                            @if($cat->id == $data->cat_id)
                                            {{$cat->category}}
                                            @endif
                                            @endforeach

                                        </h6>
                                    </td>

                                    <td>
                                        <h6 class="mb-0 text-sm">{{$data->product_name}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="mb-0 text-sm">{{$data->price}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="mb-0 text-sm">{{$data->stock}}</h6>
                                    </td>


                                    <td class="align-middle">
                                        <a class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{$data->id}}" href="#"><i
                                                class="material-icons text-sm me-2">edit</i>
                                        </a>

                                        <a class="btn btn-link text-danger text-gradient px-3 mb-0 confirm-delete" id="{{$data->id}}"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                                class="material-icons text-sm me-2">delete</i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!------------------------------------------------------- add product -------------------------------------------->


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-header shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0" >Add Product</h4>
                    </div>

                    <form  id="myForm" role="form" class="text-start" action="<?php  echo url('/insert_product') ?>" method="post">
                        @csrf

                        <div class="input-group input-group-outline my-3">
                            <select name="cat_id" class="form-control" id="select_category" required>

                                <option value="">Select Category </option>
                                @foreach($category as $data)

                                <option value="{{$data->id}}">{{$data->category}}</option>

                                @endforeach
                            </select>
                        </div>



                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Product</label>
                            <input type="text" name="product_name"  class="form-control" required>
                        </div>
                        <span id="alreadyproduct" class=" text-danger"></span>

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="price"  class="form-control" id="price" required>
                        </div>
                        <span id="alreadyprice" class=" text-danger"></span>

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Stock</label>
                            <input type="text" name="stock"  class="form-control" id="stock" required>
                        </div>
                        <span id="alreadystock" class=" text-danger"></span>

                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- -------------------------------------edit product ---------------------------------------------------------->


    @foreach($product as $data)

    <div class="modal fade" id="editModal-{{$data->id}}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-header shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Update Product</h4>
                    </div>
                    <form role="form" class="text-start" action="<?php echo url('/update_product/' . $data->id)?>" method="post">
                        @csrf
                        @method('PUT')

                        <div class="input-group input-group-outline my-3 focused is-focused">
                        <label class="form-label">Select Category</label>
                            <select name="cat_id" class="form-control">

                                @foreach($category as $cat)
                                <option value="{{ $cat->id }}" {{  $data->cat_id == $cat->id ?
                                    'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Product</label>
                            <input type="text" name="product_name"value="{{  $data->product_name }}" class="form-control" required>
                        </div>


                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Price</label>
                            <input type="text" name="price" value="{{ $data->price }}"
                                class="form-control" required>
                        </div>
                        <span id="alreadyprice" class=" text-danger"></span>



                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Stock</label>
                            <input type="text" name="stock" value="{{  $data->stock }}"
                                class="form-control" id="stock" required>
                        </div>
                        <span id="alreadystock" class=" text-danger"></span>


                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @endforeach



     <!-- ------------------------------------delete  product -------------------------------------------------------- -->

  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
            <span class="text-danger" style="font-size: 30px;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
            <h4 >Are you sure, you want to delete this Product<span id=""></span>?</h4>
            </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
          <a type="button" class="btn btn-success delete-more" id="deleteConfirmButton">Yes</a>
        </div>
      </div>
    </div>
  </div>


    @include('inc.footer')

    <script>
        $(document).ready(function () {
            $('#product-table').DataTable();

            var timeout = 3000;

            $('.alert').delay(timeout).fadeOut(300);

        });
    </script>

<script>

$(document).on('click', '.confirm-delete', function () {
  var id = $(this).attr('id');

  $('#deleteModal .delete-more').attr('data-id', id);
  $('#deleteModal').modal('show');
});

$(document).on('click', '#deleteConfirmButton', function () {
  var id = $(this).attr('data-id');

  $.ajax({
      type: "GET",
      url: "delete_product/" + id, 
      success: function (response) {
        $('#responseMessage').text('Product has been successfully deleted!');
        $('#deleteModal').modal('hide');
        location.reload();
      },
    });

});
</script>


<script>
   $(document).ready(function() {
        $("#price").keyup(function() {
            var price = $("#price").val();
            if (!/^\d+$/.test(price)) { 
                $("#alreadyprice").html("The price must be a number.");
            } else {
                $("#alreadyprice").html("");
            }
        });

        $("#stock").keyup(function() {
            var stock = $("#stock").val();
            if (!/^\d+$/.test(stock)) { 
                $("#alreadystock").html("The stock must be a number.");
            } else {
                $("#alreadystock").html("");
            }
        });

     
    });
</script>


