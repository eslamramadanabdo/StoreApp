@extends('layouts.dashboard')

@section('header')
  Categories
  <a class="btn btn-sm btn-outline-primary ml-3" href="{{ route('dashboard.categories.create') }}" >Create</a>
  <a class="btn btn-sm btn-outline-dark ml-3" href="{{ route('dashboard.categories.trash') }}" >Trashed Categories</a>
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item active">Categories  </li>
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
                <h3 class="card-title">List of All Categories</h3>

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
                  <thead class="bg-info ">
                    <tr>
                      <th>Image</th>
                      <th>ID</th>
                      <th>Name</th>
                      {{-- <th>Description</th> --}}
                      <th>Status</th>
                      <th>Parent Name</th>
                      <th>Products #</th>
                      <th>Created At </th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($categories as $category)
                      <tr>
                        <td><img class="rounded-circle" src="{{ asset('storage/' . $category->image) }}" alt="" height="50" width="50"></td>
                        <td>{{ $category->id  }}</td>
                        <td><a href="{{route('dashboard.categories.show' , $category->id)}}">{{ $category->name  }}</a></td>
                        {{-- <td>{{ $category->description  }}</td> --}}
                        <td>{{ $category->status  }}</td>
                        <td>{{ $category->parent->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->created_at  }}</td>
                        <td>
                          <a href="{{route('dashboard.categories.edit' , [$category->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                        </td>
                        <td>
                          <form action="{{ route('dashboard.categories.destroy' , [$category->id])  }}" method="POST" >
                            {{-- Form Method Spofing --}}
                            {{-- <input type="hidden" name="_method" value="delete"> --}}
                            @method('delete')
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                          </form>
                        </td>
                      </tr>

                      @empty
                        <tr>
                          <td colspan="9" class="text-center fw-bold fs-1">No Categories Founded</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          {{ $categories->withQueryString()->links() }}
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


