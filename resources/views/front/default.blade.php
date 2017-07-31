<?php

?>
<html>
	
	<head>
		<title>
        App Name - @yield('title')
		</title>
		<!-- 共同區meta -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<!-- 獨立區meta -->

		<!-- 共同區js -->
		<script type="text/javascript" src="{{ url('/vendors/jquery/dist/jquery.min.js') }}"></script>
	    <script type="text/javascript" src="{{ url('/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<!-- 獨立區js -->

		<!-- 共同區css -->
        <link rel=stylesheet type="text/css" href="{{ url('/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
		<!-- 獨立區css -->
		<link rel=stylesheet type="text/css" href="{{ url('/css/front/default.css') }}">

	</head>
	
    <body>
    
    <div class="container-fluid">
    <div class="row">
        <div id='header' class='col-md-12 col-sm-12 col-xs-12'>
        	<div id='logo' class='col-md-3 col-sm-3 col-xs-3'>
        		
        	</div>
        </div>	
    </div>
    </div>

    </body>
</html>	