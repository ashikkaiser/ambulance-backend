<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Admitro - Admin Panel HTML template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin panel ui, user dashboard template, web application templates, premium admin templates, html css admin templates, premium admin templates, best admin template bootstrap 4, dark admin template, bootstrap 4 template admin, responsive admin template, bootstrap panel template, bootstrap simple dashboard, html web app template, bootstrap report template, modern admin template, nice admin template"/>

		<!-- Title -->
		<title>Ambulance Service</title>

		<!--Favicon -->
		<link rel="icon" href="{{ asset('Html/assets/images/brand/favicon.ico') }}" type="image/x-icon"/>

		<!--Bootstrap css -->
		<link href="{{ asset('Html/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

		<!-- Style css -->
		<link href="{{ asset('Html/assets/css/style.css') }}" rel="stylesheet" />
		<link href="{{ asset('Html/assets/css/dark.css') }}" rel="stylesheet" />
		<link href="{{ asset('Html/assets/css/skin-modes.css') }}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{ asset('Html/assets/css/animated.css') }}" rel="stylesheet" />

        <!-- INTERNAL Select2 css -->
		<link href="{{ asset('Html/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{ asset('Html/assets/css/icons.css') }}" rel="stylesheet" />

	    <!-- Color Skin css -->
		<link id="theme" href="{{ asset('Html/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>

		<!-- custom css -->
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>

	</head>

	<body class="h-100vh bg-primary">

		<div class="page">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-5">
									<form action="{{ route('admin.login.submit') }}" method="post">
										@csrf
										@method('post')
										<div class="card">
											<div class="card-body">
												<div class="timeout">
													@if ($message = Session::get('error'))
													<div class="w-100 text-center">
														<div class="alert alert-danger mx-auto">
															<p>{{ $message }}</p>
														</div>
													</div>
													@endif
												</div>
												
												<label class="form-label">Email</label>
												<div class="input-group mb-4">                                                
													<input type="text" name="email" placeholder="email" value="{{ old('email') }}"
													class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>
													@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>

												<label class="form-label">Password</label>
												<div class="input-group mb-4 login-password">                                                
													<input type="password" name="password" placeholder="password"
													class="form-control @error('password') is-invalid @enderror" autocomplete="email" required>
													@error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>

												<div class="row">
													<div class="col-12">
														<button class="btn  btn-primary btn-block px-4">Login</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Jquery js-->
		<script src="{{ asset('Html/assets/js/jquery-3.5.1.min.js') }}"></script>

		<!-- Bootstrap4 js-->
		<script src="{{ asset('Html/assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('Html/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Othercharts js-->
		<script src="{{ asset('Html/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

		<!-- Circle-progress js-->
		<script src="{{ asset('Html/assets/js/circle-progress.min.js') }}"></script>

		<!-- Jquery-rating js-->
		<script src="{{ asset('Html/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

        <!-- INTERNAL Select2 js -->
		<script src="{{ asset('Html/assets/plugins/select2/select2.full.min.js') }}"></script>
		<script src="{{ asset('Html/assets/js/select2.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('Html/assets/js/custom.js') }}"></script>

		<script>
			$(document).ready(function() {
				setTimeout(function() { 
					$('.timeout').hide(); 
				}, 5000);
			})
		</script>

	</body>
</html>