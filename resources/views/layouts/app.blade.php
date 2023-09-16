<?php
	$themeClass = '';
	if (!empty($_COOKIE['theme'])) {
		if ($_COOKIE['theme'] == 'dark') {
			$themeClass = 'dark-theme';
		} else if ($_COOKIE['theme'] == 'light') {
			$themeClass = 'light-theme';
		}  
	}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11318540922"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11318540922');
</script>
		


		
		<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1459777771541183');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1459777771541183&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
		
		<!-- METADATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="" name="description">
		<meta content="" name="author">
		<meta name="keywords" content=""/>
		
        <!-- CSRF TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- TITLE -->
        <title>{{ config('app.name', 'Davinci') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

        @include('layouts.header')

	</head>

	<body class="app sidebar-mini <?php echo $themeClass; ?>">

		<!-- LOADER -->
		{{-- <div id="preloader" >
			<img src="{{URL::asset('img/svgs/preloader.gif')}}" alt="loader">           
		</div> --}}
		<!-- END LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">

				@include('layouts.nav-aside')

				<!-- APP CONTENT -->			
				<div class="app-content main-content">

					<div class="side-app">

						@include('layouts.nav-top')

                        {{-- @include('layouts.flash') --}}

						@yield('page-header')

						@yield('content')						

                    </div>                   
                </div>
                <!-- END APP CONTENT -->

                @include('layouts.footer')                

            </div>		
        </div><!-- END PAGE -->
        
		@include('layouts.footer-backend')        

	</body>
</html>


