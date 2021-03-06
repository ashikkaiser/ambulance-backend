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
		<title>Admitro - Admin Panel HTML template</title>

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

		<!---Icons css-->
		<link href="{{ asset('Html/assets/css/icons.css') }}" rel="stylesheet" />

	    <!-- Color Skin css -->
		<link id="theme" href="{{ asset('Html/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>

	</head>

	<body class="h-100vh bg-primary">

		<div class="page">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-5">
									<div class="card">
										<div class="card-body">
											<div class="text-center title-style mb-6">
												<h1 class="mb-2">Login</h1>
												<hr>
												<p class="text-muted">Sign In to your account</p>
											</div>
											<div class="btn-list d-flex">
												<a href="https://www.google.com/gmail/" class="btn btn-google btn-block"><i class="fa fa-google fa-1x mr-2"></i> Google</a>
												<a href="https://twitter.com/" class="btn btn-twitter"><i class="fa fa-twitter fa-1x"></i></a>
												<a href="https://www.facebook.com/" class="btn btn-facebook"><i class="fa fa-facebook fa-1x"></i></a>
											</div>
											<hr class="divider my-6">
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fe fe-user"></i>
													</div>
												</div>
												<input type="text" class="form-control" placeholder="Username">
											</div>
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fe fe-lock"></i>
													</div>
												</div>
												<input type="password" class="form-control" placeholder="Password">
											</div>
											<div class="row">
												<div class="col-12">
													<button type="button" class="btn  btn-primary btn-block px-4">Login</button>
												</div>
												<div class="col-12 text-center">
													<a href="forgot-password.html" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
												</div>
											</div>
											<div class="text-center pt-4">
												<div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal" href="#">Register Here</a></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Jquery js-->
		<script src="{{ asset('Html/assets/js/jquery-3.5.1.min.js') }} "></script>

		<!-- Bootstrap4 js-->
		<script src="{{ asset('Html/assets/plugins/bootstrap/popper.min.js') }} "></script>
		<script src="{{ asset('Html/assets/plugins/bootstrap/js/bootstrap.min.js') }} "></script>

		<!--Othercharts js-->
		<script src="{{ asset('Html/assets/plugins/othercharts/jquery.sparkline.min.js') }} "></script>

		<!-- Circle-progress js-->
		<script src="{{ asset('Html/assets/js/circle-progress.min.js') }} "></script>

		<!-- Jquery-rating js-->
		<script src="{{ asset('Html/assets/plugins/rating/jquery.rating-stars.js') }} "></script>

		<!-- Custom js-->
		<script src="{{ asset('Html/assets/js/custom.js') }} "></script>

	</body>
</html>