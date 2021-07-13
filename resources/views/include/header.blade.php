
<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   @php
      $img='';
      if(!empty($hotel_info_arr) && $hotel_info_arr!=NULL){
         $img=(isset($hotel_info_arr['gallery'][0]) && !empty($hotel_info_arr['gallery'][0])) ? $hotel_info_arr['gallery'][0] : $hotel_info_arr['main_image'];
      }
      
   @endphp   

   <meta property="og:image" itemprop="image" content="{{$img}}">
   <meta name="description" content="http://meemapp.net/">
   <meta property="og:type" content="website" />

<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' >
   
   <!-- <meta name="author" content="{{$hotel_info_arr['name']}}"> -->
   
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@php echo (isset($hotel_info_arr['name'])) ? $hotel_info_arr['name']: ''; @endphp</title>
   
   @include('include.header_link')
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <!--
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-193565578-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-193565578-1');
	</script>
	-->
	<!-- Un comment google analytics in prod -->
</head>