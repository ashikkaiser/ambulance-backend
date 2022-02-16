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

        <!-- INTERNAL File Uploads css -->
		<link href="{{ asset('Html/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

		<!-- INTERNAL File Uploads css-->
        <link href="{{ asset('Html/assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

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
								<div class="col-md-8">
									<div class="card">
										<div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="form-label">Full Name</label>
                                                    <div class="input-group mb-4">
                                                        <input type="text" class="form-control" placeholder="Full Name">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="form-label">NID Number</label>
                                                    <div class="input-group mb-4">
                                                        <input type="text" class="form-control" placeholder="NID number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12">
                                                    <label class="form-label">Profile Picture</label>
                                                    <input type="file" class="dropify" data-height="200" name="nid_pic" required/>
                                                </div>

                                                <div class="col-lg-6 col-sm-12">
                                                    <label class="form-label">NID Picture</label>
                                                    <input type="file" class="dropify" data-height="200" name="nid_pic" required/>
                                                </div>
                                            </div>

											<div class="row">
												<div class="col-12">
													<button type="button" class="btn  btn-primary btn-block px-4">Submit</button>
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
		</div>

		<!-- Jquery js-->
		<script src="{{ asset('Html/assets/js/jquery-3.5.1.min.js') }}"></script>

		<!-- Bootstrap4 js-->
		<script src="{{ asset('Html/assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('Html/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Othercharts js-->
		<script src="{{ asset('Html/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

        <!-- INTERNAL File-Uploads Js-->
		<script src="{{ asset('Html/assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
        <script src="{{ asset('Html/assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
        <script src="{{ asset('Html/assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
        <script src="{{ asset('Html/assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
        <script src="{{ asset('Html/assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

		<!-- INTERNAL File uploads js -->
        <script src="{{ asset('Html/assets/plugins/fileupload/js/dropify.js') }}"></script>
		<script src="{{ asset('Html/assets/js/filupload.js') }}"></script>

		<!-- Circle-progress js-->
		<script src="{{ asset('Html/assets/js/circle-progress.min.js') }}"></script>

		<!-- Jquery-rating js-->
		<script src="{{ asset('Html/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('Html/assets/js/custom.js') }}"></script>

	</body>
</html>