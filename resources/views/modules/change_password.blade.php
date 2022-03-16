@extends('layout')

@section('styles')

@endsection

@section('content')
<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-6">
        <h3>Your Account</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Your Account</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" class="row justify-content-md-center" autocomplete="off">
            @csrf
            <div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> Full Name</label>
              <div class="col-sm-8">
                <input class="form-control {{ $errors->first('name')==''?'':'is-invalid'}}" type="text" value="{{ old('name', $d->users_name) }}"
                  disabled="">
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> Email</label>
              <div class="col-sm-8">
                <input class="form-control {{ $errors->first('username')==''?'':'is-invalid'}}" type="email" value="{{ old('username', $d->users_email) }}"
                  disabled="">
                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> Old Password</label>
              <div class="col-sm-8">
                <input class="form-control {{ $errors->first('old_password')==''?'':'is-invalid'}}"  type="password" name="old_password">
                <div class="invalid-feedback">{{ $errors->first('old_password') }}</div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> New Password</label>
              <div class="col-sm-8">
                <input class="form-control {{ $errors->first('new_password')==''?'':'is-invalid'}}" type="password" name="new_password">
                <div class="invalid-feedback">{{ $errors->first('new_password') }}</div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> Password Confirmation</label>
              <div class="col-sm-8">
                <input class="form-control {{ $errors->first('c_password')==''?'':'is-invalid'}}" type="password" name="c_password">
                <div class="invalid-feedback">{{ $errors->first('c_password') }}</div>
              </div>
            </div>
            <div class="form-buttons-w">
              <a class="btn btn-default" href="{{ url('/') }}"> Cancel</a>
              <button class="btn btn-primary btn-right" type="submit"> Save</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection

@section('scripts')

@endsection