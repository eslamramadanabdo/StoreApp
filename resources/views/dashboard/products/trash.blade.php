@extends('layouts.dashboard')

@section('header')
  Products
  <a class="btn btn-sm btn-outline-primary ml-3" href="{{ route('dashboard.products.index') }}" >List All Products</a>
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item ">Products  </li>
  <li class="breadcrumb-item active">Trashed  </li>
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
                <h3 class="card-title">List of All Deleted Products</h3>
                {{-- search --}}
                <div class="card-tools">
                  <form action="{{ URL::current() }}" method="GET"> 
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="text" name="name" class="form-control float-right" placeholder="Search" value="{{request('name')}}">
                      {{-- <x.form.input  type="text" name="name" placeholder="Search" class="form-control float-right" /> --}}
                      
                      
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
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>ID</th>
                      <th>Name</th>
                      {{-- <th>Description</th> --}}
                      <th>Status</th>
                      <th>Deleted At </th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($products as $product)
                      <tr>
                        <td><img class="rounded-circle" src="{{ asset('storage/' . $product->image) }}" alt="" height="50" width="50"></td>
                        <td>{{ $product->id  }}</td>
                        <td>{{ $product->name  }}</td>
                        {{-- <td>{{ $product->description  }}</td> --}}
                        <td>{{ $product->status  }}</td>
                        <td>{{ $product->deleted_at  }}</td>
                        <td>
                          <form action="{{ route('dashboard.products.restore' , [$product->id])  }}" method="POST" >
                            @method('PUT')
                            @csrf
                            <button class="btn btn-sm btn-outline-info" type="submit">Restore</button>
                          </form>                        
                        </td>
                        <td>
                          <form action="{{ route('dashboard.products.force-delete' , [$product->id])  }}" method="POST" >
                            @method('delete')
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit">Force Delete</button>
                          </form>
                        </td>
                      </tr>

                      @empty
                        <tr>
                          <td colspan="7" class="text-center fw-bold fs-1">No Products Founded</td>
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


