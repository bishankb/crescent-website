<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="#">
	<meta name="author" content="codepixer">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta charset="UTF-8">
	<title>Crescent Engineering Consultancy</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
	<link href="{{ mix('/css/frontend.css') }}" rel="stylesheet" type="text/css">

    @yield('frontend-style')

</head>

<body>
		  
        @include('frontend.partials.navbar')

		@yield('content')

		@include('frontend.partials.footer')

		<script src="{{ mix('/js/frontend.js') }}"></script>
		
		@yield('frontend-script')

		<script>
            $(document).ready(function(){
                @if(Session::has('message'))
                    var type = "{{ Session::get('alert-type', 'info') }}";
                    switch(type){
                        case 'success':
                            toastr.success("{{ Session::get('message') }}");
                            break;
                            
                        case 'info':
                            toastr.info("{{ Session::get('message') }}");
                            break;

                        case 'warning':
                            toastr.warning("{{ Session::get('message') }}");
                            break;

                        case 'error':
                            toastr.error("{{ Session::get('message') }}");
                            break;
                    }
                @endif
            });
		</script>
	
	</body>
</html>
