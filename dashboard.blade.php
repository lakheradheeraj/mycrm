@include('inc.header')


<div class="container-fluid py4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 postion-relative mt-n4 mx-3 z-index-2">
          <div class="shadow-primary border-radius-lg pt4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Out Of Stock</h6>
          </div>
        </div>


        <div class="card-body px-4 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="out-of-stock-table">
              <thead>
                <tr class="text-center">
                  <th class="text-uppercase  font-weight-bolder opacity-7 ">Sr. No.</th>
                  <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Category Name</th>
                  <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Product Name</th>
                  <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Stock</th>

                </tr>
              </thead>
              <tbody>
                <?php 
                        // $productNames = [];
                        // foreach ($product as $sale) {
                        //   //  $product = \App\Models\Product::find($sale->pro_id);
                        //     $productNames[] = $sale->product_name;
                        // }
                        // sort($productNames);
                        ?>
                @foreach($product as $sale)
                <?php
                $category = \App\Models\Category::find($sale->cat_id);
              //  $product = \App\Models\Product::find($sale->pro_id);
              //  $productNames[] = $sale->product_name;
              //  $productDATA = sort($productNames);
                
                
              ?>
                <tr class="text-center">

                  <td>
                    <h6 class="mb-0 text-sm">{{$loop->index+1}}</h6>
                  </td>

                  <td>
                    <h6 class="mb-0 text-sm">{{ $category->category }}</h6>
                  </td>

                  <td>
                    <h6 class="mb-0 text-sm"> {{ $sale->product_name }}</h6>
                  </td>

                  <td>
                    <h6 class="mb-0 text-sm"><b class="text-danger">{{$sale->stock}}</b></h6>
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

  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 postion-relative mt-n4 mx-3 z-index-2">
          <div class="shadow-primary border-radius-lg pt4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Sales</h6>
          </div>
        </div>

        <div class="card-body">
          <form action="Sales_Data" method="post">
            @csrf
            <div class="row">
              <div class="col-md-3">
                <div class="form-group input-group input-group-outline mb-3 focused is-focused">
                  <label class="form-label">From Date</label>
                  <input type="date" name="from_date" class="form-control" onfocus="focused(this)"
                    onfocusout="defocused(this)">
                </div>
                @error('from_date')
                <div class="alert text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <button class="btn btn-success">Search</button>
                </div>
              </div>
            </div>
          </form>

          @if(session('search_date'))
          <div class="card-body px-4 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0" id="out-of-stock-table">
                <thead>
                  <tr class="text-center">
                    <th class="text-uppercase  font-weight-bolder opacity-7 ">Sr. No.</th>
                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Category Name</th>
                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">Product Name</th>
                    <th class="text-uppercase  font-weight-bolder opacity-7 ps-2">quantity</th>

                  </tr>
                </thead>
                <tbody>
                @php
                  $counter = 1;
              @endphp
                  @foreach(session('search_date') as $date)
          
                  <?php 
                    $category = \App\Models\Category::find($date->cat_id);
                    $product = \App\Models\Product::find($date->pro_id);

                  ?>

                  <tr class="text-center">

                    <td>
                      <h6 class="mb-0 text-sm">{{$counter}}</h6>
                    </td>

                    <td>
                      <h6 class="mb-0 text-sm">{{ $category->category }}</h6>
                    </td>

                    <td>
                      <h6 class="mb-0 text-sm">{{$product->product_name}}</h6>
                    </td>

                    <td>
                      <h6 class="mb-0 text-sm">{{$date->stock}}</h6>
                    </td>

                  </tr>
                  @php
                      $counter++;
                  @endphp
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>

          @endif

          @if(session('dateError'))
          <div class="alert">
            {{ session('dateError') }}
          </div>
          @endif
        </div>

      </div>
    </div>
  </div>



  @include('inc.footer')

  <script>
    $(document).ready(function () {
      $('#out-of-stock-table').DataTable();
      

      var timeout = 3000;

      $('.alert').delay(timeout).fadeOut(300);
    });
  </script>