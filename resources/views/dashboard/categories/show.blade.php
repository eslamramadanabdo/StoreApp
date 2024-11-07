@extends('layouts.dashboard')

@section('header')
{{$category->name}} Category
  <a class="btn btn-sm btn-outline-primary ml-3" href="{{ route('dashboard.categories.create') }}" >Create</a>
  <a class="btn btn-sm btn-outline-info ml-3" href="{{ route('dashboard.categories.index') }}" >All Categories</a>
  <a class="btn btn-sm btn-outline-dark ml-3" href="{{ route('dashboard.categories.trash') }}" >Trash</a>
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item active">Categories  </li>
  <li class="breadcrumb-item active"> {{$category->name}}  </li>
@endsection



@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      {{-- get all alerts for update and create successfully --}}
        <x-alert type="success"/>
        <x-alert type="info"/>
        <x-alert type="danger"/>
        <!-- /.row -->
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{$category->name}} Category</h3>

                <div class="card-tools">
                  <form action="{{ URL::current() }}" method="GET"> 
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="text" name="name" class="form-control float-right" placeholder="Search" value="{{request('name')}}">

                      <select name="status" class="form-control" id="" placeholder="Status">
                          <option value="">All</option>
                          <option value="active"   @selected(request('status') == 'active')>Active</option>
                          <option value="archived" @selected(request('status') == 'archived')>Archived</option>
                      </select>
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap ">
                  <thead class="bg-info">
                    <tr>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Store</th>
                      <th>Description</th> 
                      <th>Status</th>
                      <th>Created At </th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $products = $category->products()->with('store')->paginate();    
                    @endphp
                    @forelse ($products as $product)
                      <tr>
                        <td><img class="rounded-circle" src="{{ asset('storage/' . $product->image) }}" alt="" height="50" width="50"></td>
                        <td>{{ $product->name  }}</td>
                        <td>{{ $product->store->name }}</td>
                        <td>{{ $product->description  }}</td>
                        <td>{{ $product->status  }}</td>
                        <td>{{ $product->created_at  }}</td>
                      </tr>

                      @empty
                        <tr>
                          <td colspan="6" class="text-center fw-bold fs-1">No Products Founded</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          {{ $products->withQueryString()->links() }}
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


