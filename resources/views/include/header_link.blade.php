
   @php 
   $token=Session::get('tokenid');
   $lang=CommonMethods::getLang();
   $direction=($lang=='ar' || $lang=='kr')? 'rtl/' : '';
   $font_path=env('APP_ASSETS').$direction."css/kr-font/";
   @endphp
   
   <link rel="preconnect" href="https://fonts.gstatic.com">
   @if($lang=='ar' || $lang=='kr')
      
      <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300&display=swap" rel="stylesheet">

   @endif
   @if($lang=='en')
      
   <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">
   @endif
   <script type="text/javascript">
    var base_url="{{url('/')}}"
    var lang='{{$lang}}';
   </script>

   

 <!-- Favicon Icon -->
   <link rel="icon" type="image/png" href="{!! env('APP_ASSETS') !!}img/favicon.jpeg">

   @include('include.custome_css')
   <!-- Bootstrap core CSS-->
  <!--  <link href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/bootstrap/css/bootstrap.min.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all"> -->
   <!-- Font Awesome-->
 <!--   <link href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/fontawesome/css/all.min.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all"> -->
   <!-- Font Awesome-->
   <link href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/icofont/icofont.min.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">
   <!-- Select2 CSS-->
   <link href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/select2/css/select2.min.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">
   <!-- Custom styles for this template-->
   <link href="{!! env('APP_ASSETS') !!}{{$direction}}css/osahan.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">

   <link rel="preconnect" href="https://fonts.gstatic.com" media="all">


   
   <link href="{!! env('APP_ASSETS') !!}css/custome_page.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">
   <!-- Owl Carousel -->
   <link rel="preload" as="style" onload="this.rel='stylesheet'" href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/owl-carousel/owl.carousel.css" media="all">
   <link rel="preload" as="style" onload="this.rel='stylesheet'" href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/owl-carousel/owl.theme.css" media="all">
   
   @include('include.custome_js')
@if($lang=='kr' && $recipe_name!='')
<link href="{!! env('APP_ASSETS') !!}{{$direction}}css/kr-font.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">

@endif