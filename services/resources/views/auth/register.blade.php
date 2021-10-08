@extends('admin.admin_master')
@section('admin')

  <div class="container">
  <div class="box-wrapper">				
      <div class="box box-border">
        <div class="box-body">
          <h4>Register</h4>
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
              <label>Name</label>
              <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            
            <div class="form-group">
              <label class="fw">Password</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
              <label class="fw">Confirm Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <div class="form-group text-center">
              <span class="text-muted">Already have an account?</span> <a href="{{ route('login') }}">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection