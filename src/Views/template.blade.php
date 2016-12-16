<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <!-- CDN of icons -->
        <link rel="stylesheet" href="http://cdn.materialdesignicons.com/1.7.22/css/materialdesignicons.min.css">

		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="{{Laralang::checkAsset('vendor/Aitor24/Laralang/Images/icon.png')}}">


        <title>@yield('title')</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">


        <style media="screen">
        .shadow {
          box-shadow: 0 0 4px 5px rgba(127, 127, 127, .5);
        }
        </style>

        <!-- CDN of moment js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment-with-locales.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment-with-locales.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>

    </head>
    <body>
        <div id="app" style="background-color:#f4f4f4;">
            @if(Route::currentRouteName() != 'laralang::login')
            <center>
            <div class="container" style="padding-top:60px">
            	<div class="row">
            		<div class="col-lg-6 offset-lg-3">
            			<h1>@yield('page_title')</h1>
            		</div>
            		<div class="col-lg-3">
            		<div class="btn-group">
            		  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            		    <i class="mdi mdi-settings"></i> Actions
            		  </button>
            		  <div class="dropdown-menu">
                          <center>
                              <li><a href="{{ Laralang::checkUrl('/') }}">Visit site</a></li>
                              @yield('nav_elements')
                              <div class="dropdown-divider"></div>
                              <li><a href="{{ route('laralang::logout') }}" class='logout'>Logout</a></li>
                          </center>
            		  </div>
            		</div>
            		</div>
            	</div>
            </div>
            </center>
            @endif
            @yield('content')
        </div>

        @yield('templates')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/vue/dist/vue.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.js"></script>
        <!-- CDN of bootstrap-notify js -->

        @yield('js')
        <script type="text/javascript">
            new Vue({
                el: '#app',
            })
        </script>
    </body>
</html>
