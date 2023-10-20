@include('inc.header')


<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class=" shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Category</h6>
          </div>
        </div>
        <div class="nav-item d-flex align-items-center">
          <a class="btn btn-outline-success bg-success text-white btn-sm mb-0 me-3 add_btn" data-bs-toggle="modal"
            data-bs-target="#exampleModal" href="#">Add +</a>

        </div>
        @if(session('success'))
        <div class="alert text-success">
          {{ session('success') }}
        </div>
        @endif

        <span id="responseMessage" class=" alert text-success"></span>

        <div class="card-body px-4 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="category-table">
              <thead>
                <tr class="text-center">
                  <th class="text-uppercase  font-weight-bolder opacity-7 ">Sr. No.</th>
                  <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Category Name</th>
                  <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)

                <tr class="text-center">
                  <td>
                    <h6 class="mb-0 text-sm">{{$loop->index+1}}</h6>
                  </td>

                  <td>
                    <h6 class="mb-0 text-sm">{{$user->category}}</h6>
                  </td>


                  <td class="align-middle">
                    <a class="btn btn-link text-dark px-3 mb-0" id="edit_categoryclickbutton" data-bs-toggle="modal"
                      data-bs-target="#editModal-{{$user->id}}"><i class="material-icons text-sm me-2">edit</i></a>
                    <a class="btn btn-link text-danger text-gradient px-3 mb-0 confirm-delete" id="{{$user->id}}"
                      data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                        class="material-icons text-sm me-2">delete</i>
                    </a>
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

  <!-- ------------------------------------add category -------------------------------------------------------- -->

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <form action="<?php  echo url('/add_category') ?>" method="post">

            @csrf

            <div class="input-group input-group-outline my-3">
              <label class="form-label">Add Category</label>
              <input type="text" name="category" value="{{old('category')}}" class="form-control" required
                id="add_category">
            </div>
            <span id="alreadycategory" class=" text-danger"></span>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>


  <!-- ------------------------------------edit  category -------------------------------------------------------- -->

  @foreach($users as $user)
  <div class="modal fade" id="editModal-{{$user->id}}" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <form action="<?php echo url('/update_category/' . $user->id)?>" method="post">
            @csrf
            @method('PUT')
            <div class="input-group input-group-outline my-3 focused is-focused">
              <label class="form-label"> Category</label>
              <input type="text" name="category" value="{{$user->category}}" class="form-control"
                onfocus="focused(this)" onfocusout="defocused(this)" id="edit_category" required>
            </div>
            <span id="alreadyeditcategory" class=" text-danger"></span>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  @endforeach

  <!-- ------------------------------------delete  category -------------------------------------------------------- -->

  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <span class="text-danger" style="font-size: 30px;"><i class="fa fa-exclamation-circle"
              aria-hidden="true"></i></span>
          <h4>Are you sure, you want to delete this category<span id=""></span>?</h4>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-danger delete_no" data-bs-dismiss="modal">No</button>
          <a type="button" class="btn btn-success delete-more" id="deleteConfirmButton">Yes</a>
        </div>
      </div>
    </div>
  </div>


  @include('inc.footer')

  <script>
    $(document).ready(function () {
      $('#category-table').DataTable();

      var timeout = 3000;

      $('.alert').delay(timeout).fadeOut(300);

    });
  </script>


  <script>

    $(document).on('click', '.confirm-delete', function () {
      var id = $(this).attr('id');

      $('#deleteModal .delete-more').attr('data-id', id);
      $('#deleteModal').modal('show');

      $.ajax({
        type: 'POST',
        url: 'check_catID',
        data: {
          'cat_id': id,
          '_token': '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response === 'exists') {

            $('#deleteConfirmButton').hide();
            $('.delete_no').hide();
            $('#deleteModal .modal-body h4').html('Cannot delete this category because it is associated with other products.');
          } else if (response === 'not_exists') {

            $('#deleteConfirmButton').show();
            $('.delete_no').show();
            $('#deleteModal .modal-body h4').html('Are you sure, you want to delete this category?');
          }

          $('#deleteModal').modal('show');
        }
      });

    });



    $(document).on('click', '#deleteConfirmButton', function () {
      var id = $(this).attr('data-id');

      $.ajax({
        type: "GET",
        url: "delete/" + id,
        success: function (response) {
          $('#responseMessage').text('Category has been successfully deleted!');
          $('#deleteModal').modal('hide');
          location.reload();
        },
      });

    });


  </script>

  <script>
    $(document).ready(function () {
      $('#add_category').keyup(function () {
        var category = $('#add_category').val();

        $.ajax({

          type: 'POST',
          url: 'checkcategory',
          data:
          {
            'category': category,
            '_token': '{{ csrf_token() }}',
          },
          success: function (response) {

            if (response === 'exists') {
              $("#alreadycategory").html("Category already exists.");
            } else {
              $("#alreadycategory").html("");
            }

          }

        });
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      $('#edit_category').keyup(function () {
        var editcategory = $('#edit_category').val();


        $.ajax({

          type: 'POST',
          url: 'checkcategory',
          data:
          {
            'category': editcategory,
            '_token': '{{ csrf_token() }}',
          },
          success: function (response) {

            if (response === 'exists') {
              $("#alreadyeditcategory").html("Category already exists.");
            } else {
              $("#alreadyeditcategory").html("");
            }

          }

        });
      });
    });
  </script>

  <script>
    $(document).ready(function () {

      $(".add_btn").click(function () {
        $("#add_category").val("");
        $("#alreadycategory").html("");
      });
    });
  </script>