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

		<!---Icons css-->
		<link href="{{ asset('Html/assets/css/icons.css') }}" rel="stylesheet" />

	    <!-- Color Skin css -->
		<link id="theme" href="{{ asset('Html/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>

	</head>

	<body class="h-100vh bg-primary">

		<div class="box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>

		<div class="page">
			<div class="page-content">
				<div class="container text-center">
					<div class="row">
						<div class="col-12">
							<div class="">
								<div class="text-white">
									<div class="display-1 mb-5 font-weight-bold error-text">404</div>
									<h1 class="h3  mb-3 font-weight-bold">Sorry, Requested Page not found!</h1>
									<p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
									<a class="btn btn-secondary" href="{{ route('admin.index') }}"><i class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
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

		<!-- Custom js-->
		<script src="{{ asset('Html/assets/js/custom.js') }}"></script>

	</body>
</html>