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
		<link href="{{ asset('Html/assets/plugins/quill/quill.bubble.css') }}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{ asset('Html/assets/css/animated.css') }}" rel="stylesheet" />

		<!--Sidemenu css -->
       <link href="{{ asset('Html/assets/css/sidemenu.css') }}" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{ asset('Html/assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{ asset('Html/assets/css/icons.css') }}" rel="stylesheet" />

		<!-- Simplebar css -->
		<link rel="stylesheet" href="{{ asset('Html/assets/plugins/simplebar/css/simplebar.css') }}">

		<!-- INTERNAL Select2 css -->
		<link href="{{ asset('Html/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

		<link rel="stylesheet" href="{{ asset('Html/assets/js/spectrum/spectrum.css') }}">

		<!-- INTERNAL File Uploads css -->
		<link href="{{ asset('Html/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

		<!-- INTERNAL File Uploads css-->
        <link href="{{ asset('Html/assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
		<link id="theme" href="{{ asset('Html/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>

	</head>

	<body class="app sidebar-mini">

		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{ asset('Html/assets/images/svgs/loader.svg') }}" alt="loader">
		</div>
		<!--- End Global-loader-->

		<!-- Page -->
		<div class="page">
			<div class="page-main">

				<!--aside open-->
				<aside class="app-sidebar">
					
					<div class="app-sidebar__logo">
						<a class="header-brand" href=" {{ route('admin.index') }}">
							<img src="{{ asset('Html/assets/images/brand/main_logo.png') }}" class="header-brand-img desktop-lgo" alt="Admitro logo">
						</a>
					</div>
					<div class="app-sidebar__user">
						<div class="dropdown user-pro-body text-center">
							{{-- 
							<div class="user-pic">
								<img src="{{ asset('Html/assets/images/brand/user.png') }}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							 --}}
							@if(Auth::guard('admin_user')->user()->user_category == 'Admin')
							<div class="user-pic">
								<img src="{{ asset('Html/assets/images/brand/user.png') }}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							@elseif(Auth::guard('admin_user')->user()->user_category == 'Partner')
							<div class="user-pic">
								<img src="{{ asset($data->imgPath . $data->nid . '/' . $data->profile_picture) }}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							@else
							<div class="user-pic">
								<img src="{{ asset($data->imgPath . $data->nid . '/' . $data->profile_pic) }}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							@endif
							<div class="user-info">
								<h5 class=" mb-1">{{ $data->name ?? 'Mr. Admin' }} <i class="ion-checkmark-circled  text-success fs-12"></i></h5>
								<span class="text-muted app-sidebar__user-name text-sm">{{ Auth::guard('admin_user')->user()->user_category }}</span>
							</div>
						</div>
					</div>
					<ul class="side-menu app-sidebar3">
						<li class="side-item side-item-category mt-4">Main</li>

						<li class="slide">
							<a class="side-menu__item"  href=" {{ route('admin.index') }} ">
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
							<span class="side-menu__label">Dashboard</span></a>
						</li>

						<!-- Menu Items for Admin-->
						@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class))
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Moderators</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.moderators.create') }}" class="slide-item">Add Moderator</a></li>
									<li><a href="{{ route('admin.moderators.index') }}" class="slide-item">Moderator List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Booth Management</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.agents.create') }}" class="slide-item">Add Agent</a></li>
									<li><a href="{{ route('admin.agents.index') }}" class="slide-item">Agent List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Partner Management</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.partners.create') }}" class="slide-item">Add Partner</a></li>
									<li><a href="{{ route('admin.partners.index') }}" class="slide-item">Partner List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Lists</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.vehicles.index') }}" class="slide-item">Vehicle List</a></li>
									<li><a href="{{ route('admin.drivers.index') }}" class="slide-item">Driver List</a></li>
									<li><a href="{{ route('admin.assistants.index') }}" class="slide-item">Assistant List</a></li>
									<li><a href="{{ route('admin.users') }}" class="slide-item">User List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item"  href="{{ route('admin.tripDetails.list') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Trip Details</span></a>
							</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Setting</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.categories') }}" class="slide-item">Vehicles Category</a></li>
									 <li><a href="{{ route('admin.email') }}" class="slide-item">Email Template</a></li>
									 <li><a href="{{ route('admin.conditions.index') }}" class="slide-item">Conditions</a></li>
								</ul>
							</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Fair Managements</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.fairmanagement.districts') }}" class="slide-item">Districts</a></li>
									 <li><a href="{{ route('admin.fairmanagement.locations') }}" class="slide-item">Location</a></li>
									 <li><a href="{{ route('admin.fairmanagement.index') }}" class="slide-item">Fair</a></li>
								</ul>
							</li>
						@endif
						<!-- ! Menu Items for Admin-->
						
						<!-- Menu Items for Moderator -->
						@if(Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Partners</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.partners.create') }}" class="slide-item">Add Partner</a></li>
									<li><a href="{{ route('admin.partners.index') }}" class="slide-item">Partner List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Vehicles</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.vehicles.create') }}" class="slide-item">Add Vehicle</a></li>
									<li><a href="{{ route('admin.vehicles.index') }}" class="slide-item">Vehicle List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Drivers</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.drivers.create') }}" class="slide-item">Add Driver</a></li>
									<li><a href="{{ route('admin.drivers.index') }}" class="slide-item">Driver List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Assistants</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.assistants.create') }}" class="slide-item">Add Assistant</a></li>
									<li><a href="{{ route('admin.assistants.index') }}" class="slide-item">Assistant List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item"  href="{{ route('admin.users') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Users</span></a>
							</li>
						@endif
						<!-- ! Menu Items for Moderator -->

						<!-- Menu Items for Partner -->
						@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class))
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Vehicles</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									<li><a href="{{ route('admin.vehicles.create') }}" class="slide-item">Add Vehicle</a></li>
									<li><a href="{{ route('admin.vehicles.index') }}" class="slide-item">Vehicle List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Drivers</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									{{-- <li><a href="{{ route('admin.drivers.create') }}" class="slide-item">Add Driver</a></li> --}}
									<li><a href="{{ route('admin.drivers.index') }}" class="slide-item">Driver List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
								<span class="side-menu__label">Assistants</span><i class="angle fa fa-angle-right"></i></a>
								<ul class="slide-menu ">
									{{-- <li><a href="{{ route('admin.assistants.create') }}" class="slide-item">Add Assistant</a></li> --}}
									<li><a href="{{ route('admin.assistants.index') }}" class="slide-item">Assistant List</a></li>
								</ul>
							</li>

							<li class="slide">
								<a class="side-menu__item"  href="{{ route('admin.tripDetails.list') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Trip Details</span></a>
							</li>

							{{-- <li class="slide">
								<a class="side-menu__item" href="{{ route('admin.vehicle.distribution') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Vehicle Distribution</span></a>
							</li> --}}
						@endif
						<!-- ! Menu Items for Partner -->

						<!-- Menu Items for Agent -->
						@if(Auth::guard('admin_user')->user()->can('haveAgentAccess', App\Models\AdminUser::class))
							<li class="slide">
								<a class="side-menu__item"  href="{{ route('admin.TripDetails.create') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Create Trip</span></a>
							</li>	

							<li class="slide">
								<a class="side-menu__item"  href="{{ route('admin.tripDetails.list') }}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
								<span class="side-menu__label">Trip Details</span></a>
							</li>
						@endif
						<!-- ! Menu Items for Agent -->


						<li class="slide">
							<form action="{{ route('admin.logout') }}" method="post">
								@csrf
								@method('post')
								<button class="side-menu__item text-left logout-btn" style="">
									<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
									<span class="side-menu__label">Logout</span></a>
								</button>
							</form>
						</li>
					</ul>
				</aside>
				<!--aside closed-->

				<style>
					.logout-btn {
						border: none; 
						outline: none; 
						width: 93%;
						background: none;
					}
					.logout-btn:hover {
						background: #EBEEF1;
					}
				</style>