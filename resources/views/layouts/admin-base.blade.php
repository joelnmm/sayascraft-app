<!DOCTYPE html>
<html lang="en">
<style>
  .badge:after{
      content:attr(value);
      font-size:16px;
      font-style: normal; 
      color: #fff;
      background: red;
      border-radius:50%;
      padding: 0 5px;
      position:relative;
      left:-60px;
      top:-12px;
      opacity:0.9;
  }
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>BraceletsNY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/assets/img/favicon.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Vendor CSS Files -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/css/main.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/chosen.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/style_products.css"> 
  <link rel="stylesheet" type="text/css" href="/assets/css/main.css"> 
  <!-- LEFT BAR ADMIN CSS -->
  <link rel="stylesheet" type="text/css" href="/assets/css/left-bar.css">
  <!-- Table admin css -->
  <link rel="stylesheet" type="text/css" href="/assets/css/admin-table.css"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="/assets/css/create-bracelet.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <section id="topbar" class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:sayasecucraft@gmail.com">sayasecucraft@gmail.com</a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 310 486 6870</span></i>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      </div>
    </div>
  </section><!-- End Top Bar -->

  <header id="header" class="header d-flex align-items-center">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center" style="font-size: 30px">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="/assets/img/sayascraft_logo.png" alt="">
        <!-- <h1>BraceletsNY<span></span></h1> -->
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li class="nav-top-li"></li>
          <li><a href="/" style="font-size: 20px">Home</a></li>
          <li><a href="/create-bracelet" style="font-size: 20px">Create</a></li>
          <li><a href="/products" style="font-size: 20px">Products</a></li>
          <li><a href="/#about" style="font-size: 20px">About</a></li>
          <!-- <li><a href="#portfolio" style="font-size: 20px">Products</a></li> -->
          <li><a href="/#contact" style="font-size: 20px">Contact</a></li>
          <!-- <li class="bi bi-person-circle" style="margin-right: -25px; color:aliceblue;"></li> -->
          @if(Route::has('login'))
            @auth
              <!-- Admin -->
              @if(Auth::user()->utype === 'ADM') 
                <li class="dropdown"><a href="#" style="font-size: 20px; display:block;"> <i class="bi bi-person-circle" style="margin-right: 4px; font-size:25px;"></i> <span>{{Auth::user()->name}}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                  <ul>
                    <li style="border-bottom:none;"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li style="border-bottom:none;"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                  </ul>
                </li>

              @else
              <!-- User/Customer -->
                <li class="dropdown"><a href="#" style="font-size: 20px; display:block;"> <i class="bi bi-person-circle" style="margin-right: 4px; font-size:25px;"></i> <span>{{Auth::user()->name}}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                  <ul>
                    <li style="border-bottom:none;"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li style="border-bottom:none;"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                  </ul>
                </li>
              @endif
            @else 
              
              <li class="dropdown"><a href="#" style="font-size: 20px; display:block;"> <i class="bi bi-person-circle" style="margin-right: 4px; font-size:25px;"></i> <span>User</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li style="border-bottom:none;"><a href="/login">Log in</a></li>
                  <li style="border-bottom:none;"><a href="/register">Sign up</a></li>
                </ul>
              </li>
            @endif
          @endif
          @if(Cart::instance('cart')->count() > 0)
            <li><a class="remove-left" href="/cart" style="font-size: 20px" title="Cart"><i class="badge bi bi-cart-fill" value="{{Cart::instance('cart')->count()}}" style="font-size:22px; font-style:normal; margin-left:-10px;">Cart</i></a></li>
          @else
            <li><a class="remove-left" href="/cart" style="font-size: 20px" title="Cart"><i class="bi bi-cart-fill" style="font-size:22px; font-style:normal;">Cart</i></a></li>
          @endif
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

        </div>
    </header><!-- End Header -->
    <!-- End Header -->

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h1><a href="index.html" class="logo">BraceletsNY</a></h1>
            <ul class="list-unstyled components mb-5">
              <li class="active">
                  <a href="{{ route('admin.dashboard')}}"><span class="fa  fa-tachometer mr-3"></span> Dashboard</a>
              </li>
              <li>
                  <a href="{{ route('admin.products')}}"><span class="fa fa-shopping-basket mr-3"></span> Products</a>
              </li>
              <li>
                  <a href="{{ route('admin.users')}}"><span class="fa fa-user mr-3"></span> Users</a>
              </li>
              <li>
                  <a href="{{ route('admin.coupons')}}"><span class="fa fa-ticket mr-3"></span> Coupons</a>
              </li>
              <li>
                  <a href="{{ route('admin.orders')}}"><span class="fa fa-usd mr-3"></span> Orders</a>
              </li>
              <li>
                  <a href="{{ route('admin.categories')}}"><span class="fa fa-list-alt mr-3"></span> Categories</a>
              </li>
            </ul>
        </nav>

            <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5" style="margin: auto;">
            <!-- Here goes the content of each page -->
            
            <!-- for views using controller -->
            @yield('content')

            <!-- for views using livewirecomponent -->
            @isset($slot)
                {{$slot}}
            @endisset
        </div>
    </div>

    



   <!-- ======= Footer ======= -->
   <footer id="footer" class="footer">

    <div class="container">
    <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-info">
        <a href="/" class="logo d-flex align-items-center">
            <span>Saya's Craft</span>
        </a>
        <p>Handmade crafts from Ecuador. Create your own bracelet or shop our variety of textile crafts that we have for you</p>
        <div class="social-links d-flex mt-4">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <!-- <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a> -->
        </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
            <!-- <li><a href="/">Home</a></li> -->
            <li><a href="#">About us</a></li>
            <li><a href="#">FAQs</a></li>
            <!-- <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li> -->
        </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Location</h4>
          <p>
            Los Angeles, LA <br>
            United States <br><br>
          </p>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>
            <strong>Phone:</strong> +1 3104866870<br>
            <strong>Email:</strong> sayasecucraft@gmail.com<br>
        </p>
        </div>

    </div>
    </div>

    <div class="container mt-4">
    <div class="copyright">
        &copy; Copyright <strong><span>BraceletsNY</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/impact-bootstrap-business-website-template/ -->
        Designed by <a href="https://bootstrapmade.com/">Vstudios</a>
    </div>
    </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>

@livewireScripts
<!-- Vendor JS Files -->
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/aos/aos.js"></script>
<script src="/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/assets/js/main.js"></script>

<!-- ecommerce 8 scripts -->
<!-- <script src="/assets/js/jquery-1.12.4.minb8ff.js?ver=1.12.4"></script> -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/chosen.jquery.min.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script src="/assets/js/jquery.sticky.js"></script>
<script src="/assets/js/functions.js"></script>

<!-- LEFT BAR ADMIN SCRIPTS -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/popper.js"></script>
<script src="/assets/js/main-bar.js"></script>

<!-- table admin script -->
<script>
  $(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

</body>
@stack('scripts')

</html>