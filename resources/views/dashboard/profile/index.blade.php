@extends('layouts.dashboard')

@section('header')
 Profile
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item active"> Profile  </li>
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
                <h3 class="card-title">Show Profile</h3>


                  <h1>user profile</h1>

                  <a href="{{route('dashboard.profile.edit')}}" class="btn btn-success">Edit Profile</a>

              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


