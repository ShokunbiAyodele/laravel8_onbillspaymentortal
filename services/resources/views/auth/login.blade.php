
@extends('admin.admin_master')
@section('admin')

	
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<h4>Login</h4>
                            <form method="POST" action="{{ route('login') }}">
                              @csrf
								<div class="form-group">
									<label>Username</label>
									<input type="text" name="email" id="email" class="form-control">
									@error('email')
									<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group">
									<label class="fw">Password
										<a href="{{ route('password.request') }}" class="pull-right">Forgot Password?</a>
									</label>
									<input type="password" id="password" name="password" class="form-control">
									@error('password')
									<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group text-right">
									<button class="btn btn-primary btn-block">Login</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">Don't have an account?</span> <a href="{{ route('register') }}">Create one</a>
								</div>
								<div class="title-line">
									or
								</div>
              	<a href="#" class="btn btn-social btn-block facebook"><i class="ion-social-facebook"></i> Login with Facebook</a>
							</form>
						</div>
					</div>
				</div>
			</div>

        
@endsection