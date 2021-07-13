
   @php 
   $token=Session::get('tokenid');
   //$direction=(isset($_SESSION['lang'][$token]) && $_SESSION['lang'][$token]=='ar')? 'rtl/' : '';
   $direction='rtl/';
   $lang=$lang_detail['lang_txt'];
   if(isset($lang_detail['direction'])):
      $lang=$lang_detail['lang'];
      $lang_txt=$lang_detail['lang_txt'];
      $lang_margin=$lang_detail['lang_margin'];
   endif;
   
   @endphp
   
   @if(isset($_SESSION['lang'][$token]) && $_SESSION['lang'][$token]=='ar')
         <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300&display=swap" rel="stylesheet">

   @endif
   @if(isset($_SESSION['lang'][$token]) && $_SESSION['lang'][$token]=='eng')
      <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300&display=swap" rel="stylesheet">
   @endif
   <script type="text/javascript">
    var base_url="{{url('/')}}"
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
   <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">

   
   <link href="{!! env('APP_ASSETS') !!}css/custome_page.css" rel="preload" as="style" onload="this.rel='stylesheet'" media="all">
   <!-- Owl Carousel -->
   <link rel="preload" as="style" onload="this.rel='stylesheet'" href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/owl-carousel/owl.carousel.css" media="all">
   <link rel="preload" as="style" onload="this.rel='stylesheet'" href="{!! env('APP_ASSETS') !!}{{$direction}}vendor/owl-carousel/owl.theme.css" media="all">
   