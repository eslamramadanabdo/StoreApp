@extends('layouts.dashboard')

@section('header')
  Edit Profile
@endsection

@section('breadcrumb')
  @parent
  <li class="breadcrumb-item ">Profile</li>
  <li class="breadcrumb-item active">Edit</li>
@endsection


@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          {{-- get all alerts for update and create successfully --}}
          <x-alert type="success"/>
          <x-alert type="info"/>
          <x-alert type="danger"/>
        <div class="row ">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" class="pt-3" action="{{ route('dashboard.profile.update') }}" 
                    method="POST" >
                @csrf
                @method('patch')

                <div class="card-body">
                  <div class="form-row">
                    <div class="col-6">
                      <div class="form-group">
                        <x-form.input name="first_name"  label="First Name" :value="$user->profile->first_name" />
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <x-form.input name="last_name"  label="Last Name" :value="$user->profile->last_name"  />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-12">
                      <div class="form-group">
                        <x-form.input name="birthday"  label="Birthday" type="date" :value="$user->profile->birthday"  />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-4">
                      <div class="form-group">
                        <x-form.input name="street_address"  label="Street Address" type="text" :value="$user->profile->street_address"  />
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <x-form.input name="city"  label="City" :value="$user->profile->city"   />
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <x-form.input name="state"  label="State"  :value="$user->profile->state"  />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-4">
                      <div class="form-group">
                        <x-form.input name="postal_code"  label="Postal Code" type="text" :value="$user->profile->postal_code"  />
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <x-form.label id="country"> Country </x-form.label>
                        <x-form.select name="country"  label="Country" :options="$countries" :select="$user->profile->country"   />
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <x-form.label id="Locale"> Locale </x-form.label>
                        <x-form.select name="locale"  label="Locale" :options="$locales" :select="$user->profile->locale" />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    
                    <div class="col-12 ">
                      <div class="form-group">
                        <x-form.label id="gender">Gender</x-form.label>
                        <x-form.radio name="gender"  label="Gender" :options="['male'=>'Male' , 'female'=>'Female']" :checked="$user->profile->gender"   />
                      </div>
                    </div>
                  </div>
                </div>

                <div class=" text-center mb-5">
                  <button type="submit" class="btn btn-primary w-50">Update</button>
                </div>

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


