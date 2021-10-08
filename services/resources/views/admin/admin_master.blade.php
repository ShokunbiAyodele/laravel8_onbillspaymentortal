<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Magz is a HTML5 & CSS3 magazine template is based on Bootstrap 3.">
		<meta name="author" content="Kodinger">
		<meta name="keyword" content="magz, html5, css3, template, magazine template">
		<!-- Shareable -->
		<meta property="og:title" content="HTML5 & CSS3 magazine template is based on Bootstrap 3" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="http://github.com/nauvalazhar/Magz" />
		<meta property="og:image" content="https://raw.githubusercontent.com/nauvalazhar/Magz/master/images/preview.png" />
		<title>B2B &mdash; Portal</title>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="{{ asset('assets/scripts/bootstrap/bootstrap.min.css') }}">
		<!-- IonIcons -->
		<link rel="stylesheet" href="{{ asset('assets/scripts/ionicons/css/ionicons.min.css') }}">
		<!-- Toast -->
		<link rel="stylesheet" href="{{ asset('assets/scripts/toast/jquery.toast.min.css') }}">
		<!-- OwlCarousel -->
		<link rel="stylesheet" href="{{ asset('assets/scripts/owlcarousel/dist/assets/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/scripts/owlcarousel/dist/assets/owl.theme.default.min.css') }}">
		<!-- Magnific Popup -->
		<link rel="stylesheet" href="{{ asset('assets/scripts/magnific-popup/dist/magnific-popup.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/scripts/sweetalert/dist/sweetalert.css') }}">
		<!-- Custom style -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/skins/all.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		 <!-- toastr cdn -->
		 <link  rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
		 
		


	</head>

	<body class="skin-orange">
		<header class="primary">
			<div class="firstbar">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-12">
							<div class="brand">
								<a href="index.html">
									<img src="{{ asset('assets/images/ebill.png') }}" alt="Magz Logo">
								</a>
							</div>						
						</div>
						<div class="col-md-6 col-sm-12">
							<!-- <form class="search" autocomplete="off">
								<div class="form-group">
									<div class="input-group">
										<input type="text" name="q" class="form-control" placeholder="Type something here">									
										<div class="input-group-btn">
											<button class="btn btn-primary"><i class="ion-search"></i></button>
										</div>
									</div>
								</div>
							</form>								 -->
						</div>
						<div class="col-md-3 col-sm-12 text-right">
							@if(!Auth::user())
							<ul class="nav-icons">
								<li><a href="{{ route('register') }}"><i class="ion-person-add"></i><div>Register</div></a></li>
								<li><a href="{{ route('login') }}"><i class="ion-person"></i><div>Login</div></a></li>
							</ul>
							@else
							<ul class="nav-icons">
								<li><a href="{{ route('user.logout') }}"><i class="ion-person"></i><div>Logout</div></a></li>
							</ul>
							@endif


						
						</div>
					</div>
				</div>
			</div>

			<!-- Start nav -->
			<nav class="menu">
				<div class="container">
					<div class="brand">
						<a href="#">
							<img src="{{ asset('assets/images/ebill.png') }}" alt="Magz Logo">
						</a>
					</div>
					<div class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-list"><i class="ion-navicon-round"></i></a>
					</div>
					<div class="mobile-toggle">
						<a href="#" data-toggle="sidebar" data-target="#sidebar"><i class="ion-ios-arrow-left"></i></a>
					</div>
					<div id="menu-list">
						<ul class="nav-list">
							<li class="for-tablet nav-title"><a >Menu</a></li>
							<li class="for-tablet"><a href="login.html">Login</a></li>
							<li class="for-tablet"><a href="register.html">Register</a></li>
							<li><a href="category.html">Home</a></li>
							@if(Auth::user())
							<li class="dropdown magz-dropdown">
								<a href="category.html">Cable Subscription <i class="ion-ios-arrow-right"></i></a>
								<ul class="dropdown-menu">
							  	<li class="dropdown magz-dropdown"><a href="category.html">Multichoice<i class="ion-ios-arrow-right"></i></a>
										<ul class="dropdown-menu">
										<li><a href="{{ route('gotv_details_view') }}">GOTV Subscription</a>
										 <li><a href="{{ route('dstv_details_view') }}">DSTVSubscription </a>
										</ul>
									</li>
							
									<li class="dropdown magz-dropdown"><a href="category.html">Smiles <i class="ion-ios-arrow-right"></i></a>
										<ul class="dropdown-menu">
											<li><a href="{{ route('smiles_recharge.purchase') }}">Smiles Recharge</a></i>
											<li><a href="{{ route('smiles_bundle_purchase') }}">Smile Bundle</a></i>
										</ul>
									</li> 
									<li><a href="{{ route('startimes_details_view') }}">Startimes</a>
								</ul>
							</li>						
							<li class="dropdown magz-dropdown magz-dropdown-megamenu"><a href="#">Electricity Payment <i class="ion-ios-arrow-right"></i></a>
								<div class="dropdown-menu megamenu">
									<div class="megamenu-inner">
										<div class="row">
											<div class="col-md-3">
												<h2 class="megamenu-title">EKO ELECTRICITY</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('eko_electricity.prepaid') }}">Prepaid</a></i>
									   		<li><a href="{{ route('eko_electricity.postpaid') }}">Postpaid</a></i>
												</ul>
											</div>
											<div class="col-md-3">
												<h2 class="megamenu-title">IBADAN DISCO</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('ibadan_disco.prepaid_view') }}">Prepaid</a></i>
											<li><a href="{{ route('ibadan_disco.postpaid_view') }}">Postpaid</a></i>
												</ul>
											</div>
											<div class="col-md-3">
												<h2 class="megamenu-title">ABUJA ELECTRIC</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('abuja_electric.prepaid') }}">Prepaid</a></i>
										  	<li><a href="{{ route('abuja_electric.postpaid_view') }}">Postpaid</a></i>
										  	</ul>
											</div>
											<div class="col-md-3">
												<h2 class="megamenu-title">IKEJA ELECTRIC</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('ikeja_electric.prepaid') }}">Prepaid</a></i>
											<li><a href="{{ route('ikeja_electric.postpaid_view') }}">Postpaid</a></i>
										  	</ul>
											</div>
											<div class="col-md-3">
												<h2 class="megamenu-title">JOS ELECTRICITY</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('jos_electric.prepaid_view') }}">Prepaid</a></i>
												<li><a href="{{ route('jos_electric.postpaid_view') }}">Postpaid</a></i>
												</ul>
											</div>
											<div class="col-md-3">
												<h2 class="megamenu-title">ENUGU ELECTRICITY</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('enugu.prepaid_view') }}">Prepaid</a>
											  <li><a href="{{ route('enugu.postpaid_view') }}">Postpaid</a>
												</ul>
											</div>
<!-- 
											<div class="col-md-3">
												<h2 class="megamenu-title">KEDCO ELECTRICITY</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('kedco.prepaid_view') }}">Prepaid</a>
											  <li><a href="{{ route('ikeja_electric.postpaid_view') }}">Postpaid</a>
												</ul>
											</div> -->
											<div class="col-md-3">
												<h2 class="megamenu-title">Kaduna Electricity</h2>
												<ul class="vertical-menu">
												<li><a href="{{ route('kaduna.prepaid_view') }}">Prepaid</a></i>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
							@endif	
							<li style="float: right" class="dropdown magz-dropdown"><a href="#">Account Name: {{ (Auth::user()) ? Auth::user()->name :'My Profile'}} <i class="ion-ios-arrow-right"></i></a>
								<ul class="dropdown-menu">
									<li><a href="#"><i class="icon ion-person"></i> My Account</a></li>
									<li><a href="#"><i class="icon ion-heart"></i> Favorite</a></li>
									<li><a href="#"><i class="icon ion-chatbox"></i> Comments</a></li>
									<li><a href="#"><i class="icon ion-key"></i> Change Password</a></li>
									<li><a href="#"><i class="icon ion-settings"></i> Settings</a></li>
									<li class="divider"></li>
									<li><a href="#"><i class="icon ion-log-out"></i> Logout</a></li>
								</ul>
							</li>	
						</ul>
					</div>
				</div>
			</nav>
			<!-- End nav -->
		</header>
		<section class="home">
		 
      @yield('admin')
			</section>
		<!-- Start footer -->
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="block">
							<h1 class="block-title">Company Info</h1>
							<div class="block-body">
								<figure class="foot-logo">
									<img src="{{ asset('assets/images/ebill.png') }}" class="img-responsive" alt="Logo">
								</figure>
								<p class="brand-description">
									VAS2Nets Technologies E-Bills Payments.
								</p>
								<a href="page.html" class="btn btn-magz white">About Us <i class="ion-ios-arrow-thin-right"></i></a>
							</div>
						</div>
					</div>
			
					<div class="col-md-6 col-xs-12 col-sm-6">
						<div class="block">
							<h1 class="block-title">Follow Us</h1>
							<div class="block-body">
								<p>Follow us and stay in touch to get the latest news</p>
								<ul class="social trp">
									<li>
										<a href="#" class="facebook">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-facebook"></i>
										</a>
									</li>
									<li>
										<a href="#" class="twitter">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-twitter-outline"></i>
										</a>
									</li>
									<li>
										<a href="#" class="youtube">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-youtube-outline"></i>
										</a>
									</li>
									<li>
										<a href="#" class="googleplus">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-googleplus"></i>
										</a>
									</li>
									<li>
										<a href="#" class="instagram">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-instagram-outline"></i>
										</a>
									</li>
									<li>
										<a href="#" class="tumblr">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-tumblr"></i>
										</a>
									</li>
									<li>
										<a href="#" class="dribbble">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-dribbble"></i>
										</a>
									</li>
									<li>
										<a href="#" class="linkedin">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-linkedin"></i>
										</a>
									</li>
									<li>
										<a href="#" class="skype">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-skype"></i>
										</a>
									</li>
									<li>
										<a href="#" class="rss">
											<svg><rect width="0" height="0"/></svg>
											<i class="ion-social-rss"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="line"></div>
						<div class="block">
							<div class="block-body no-margin">
								<ul class="footer-nav-horizontal">
									<li><a href="index.html">Home</a></li>
									<li><a href="#">Partner</a></li>
									<li><a href="contact.html">Contact</a></li>
									<li><a href="page.html">About</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-12">
						<div class="copyright">
							COPYRIGHT &copy; MAGZ 2017. ALL RIGHT RESERVED.
							<div>
								Made with <i class="ion-heart"></i> by <a href="http://kodinger.com">Kodinger</a>
							</div>
						</div>
					</div>
				</div> -->
			</div>
		</footer>
		<!-- End Footer -->

		<!-- JS -->
		<script src="{{ asset('assets/js/jquery.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.migrate.js') }}"></script>
		<script src="{{ asset('assets/scripts/bootstrap/bootstrap.min.js') }}"></script>
		<script>var $target_end=$(".best-of-the-week");</script>
		<script src="{{ asset('assets/scripts/jquery-number/jquery.number.min.js') }}"></script>
		<script src="{{ asset('assets/scripts/owlcarousel/dist/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('assets/scripts/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
		<script src="{{ asset('assets/scripts/easescroll/jquery.easeScroll.js') }}"></script>
		<script src="{{ asset('assets/scripts/sweetalert/dist/sweetalert.min.js') }}"></script>
		<script src="{{ asset('assets/scripts/toast/jquery.toast.min.js')}}"></script>
		<!-- <script src="{{ asset('assets/js/demo.js') }}"></script> -->
		<script src="{{ asset('assets/js/e-magz.js') }}"></script>

		<!-- toastr cd -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


	


	<script>
@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}";

switch(type){
  case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

  case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;
    
  case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

  case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break;
}
@endif
</script>




	
	</body>
</html>