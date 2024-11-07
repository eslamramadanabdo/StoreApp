@extends('layouts.dashboard')

@section('header')
  Edit Category
  <a class="btn btn-sm btn-outline-primary ml-3" href="{{ route('dashboard.categories.index') }}" >List All Categories</a>
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item ">Categories</li>
  <li class="breadcrumb-item active">Edit Category</li>
@endsection


@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row ">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" class="pt-3" action="{{ route('dashboard.categories.update' , [$category->id] ) }}" 
                    method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('dashboard.categories._form' , [
                  'button_label' => 'Update'
                ])
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


