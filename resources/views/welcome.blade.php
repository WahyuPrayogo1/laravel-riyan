<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Zhaldi Fahrezi</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assetsFrontend/css/bootstrap.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('assetsFrontend/css/style.css') }}">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{ asset('assetsFrontend/css/responsive.css') }}">
    <!-- fevicon -->
    <link rel="icon" href="" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assetsFrontend/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="{{ asset('assetsFrontend/images/loading.gif') }}" alt="" /></div>
    </div>
    <!-- end loader -->

    <div class="wrapper">

        <div class="sidebar">
            <!-- Sidebar  -->
            <nav id="sidebar">

                <div id="dismiss">
                    <i class="fa fa-arrow-left"></i>
                </div>

                <ul class="list-unstyled components">

                    @if (Route::has('login'))
                        @auth
                            <li>
                                <a href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="text-black">
                                <a class="text-black" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="text-black">
                                    <a class="text-black" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif

                </ul>

            </nav>
        </div>


        <div id="content">


            <!-- section -->
            <section id="home" class="top_section">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- header -->
                        <header>
                            <!-- header inner -->
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 logo_section">
                                        <div class="full">
                                            <div class="center-desk">
                                                <div class="logo"> <a href="#"><img
                                                            src="{{ asset('assetsFrontend/images/logo.png') }}"
                                                            alt="#"></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="right_header_info">
                                            <ul>
                                                <li><img style="margin-right: 15px;"
                                                        src="{{ asset('assetsFrontend/images/phone_icon.png') }}"
                                                        alt="#" /><a href="#">0812-2242-4412</a></li>
                                                <li><img style="margin-right: 15px;"
                                                        src="{{ asset('assetsFrontend/images/mail_icon.png') }}"
                                                        alt="#" /><a href="#">AvalonZhaldi@gmail.com</a>
                                                </li>
                                                <li>
                                                    <button type="button" id="sidebarCollapse">
                                                        <img src="{{ asset('assetsFrontend/images/menu_icon.png') }}"
                                                            alt="#" />
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end header inner -->
                        </header>
                        <section>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="full slider_cont_section">
                                            <h4>Welcome</h4>
                                            <h3>AVALON</h3>
                                            <p>Dapatkan sparepart berkualitas untuk kendaraan Anda dengan harga
                                                terjangkau! Kami menyediakan berbagai macam sparepart untuk semua jenis
                                                kendaraan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end header -->
                    </div>
                </div>
            </section>
            <!-- end section -->

        </div>
    </div>

    <div class="overlay"></div>

    <!-- Javascript files-->
    <script src="{{ asset('assetsFrontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assetsFrontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('assetsFrontend/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Scrollbar Js Files -->
    <script src="{{ asset('assetsFrontend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assetsFrontend/js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

    <script>
        // This example adds a marker to indicate the position of Bondi Beach in Sydney,
        // Australia.
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: {
                    lat: 40.645037,
                    lng: -73.880224
                },
            });

            var image = 'images/location_point.png';
            var beachMarker = new google.maps.Marker({
                position: {
                    lat: 40.645037,
                    lng: -73.880224
                },
                map: map,
                icon: image
            });
        }
    </script>
    <!-- google map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap">
    </script>
    <!-- end google map js -->

</body>

</html>
