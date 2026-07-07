{{-- Extends layout --}}
@extends('layout.fullwidth2')



{{-- Content --}}
@section('content')
   <div class="col-xl-12 mt-3">
		<div class="card">
			<div class="card-body p-0">
				<div class="row m-0">
					<div class="col-xl-6 col-md-6 sign text-center">
						<div>
							<div class="text-center my-5">
								<a href="{!! url('/index') !!}"><img width="200" src="images/logo-full.png" alt=""></a>
							</div>
							<img src="images/log.png" class="education-img"></img>
						</div>	
					</div>
					<div class="col-xl-6 col-md-6">
						<div class="sign-in-your">
							<h4 class="fs-20 font-w800 text-black">Sign in your account</h4>
							<span>Welcome back! Login with your data that you entered<br> during registration</span>
							<div class="login-social">
								<a href="javascript:void(0);" class="btn font-w800 d-block my-4"><i class="fab fa-google me-2 text-primary"></i>Login with Google</a>
								<a href="javascript:void(0);" class="btn font-w800 d-block my-4"><i class="fab fa-facebook-f me-2 facebook-log"></i>Login with Facebook</a>
							</div>
							<form action="{!! url('/index') !!}">
								<div class="mb-3">
									<label class="mb-1"><strong>Email</strong></label>
									<input type="email" class="form-control" value="hello@example.com">
								</div>
								<div class="mb-3">
									<label class="mb-1"><strong>Password</strong></label>
									<input type="password" class="form-control" value="Password">
								</div>
								<div class="row d-flex justify-content-between mt-4 mb-2">
									<div class="mb-3">
									   <div class="form-check custom-checkbox ms-1">
											<input type="checkbox" class="form-check-input" id="basic_checkbox_1">
											<label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
										</div>
									</div>
									<div class="mb-3">
										<a href="{{ url('/page-forgot-password') }}">Forgot Password?</a>
									</div>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection  