@php
$lang=CommonMethods::getLang();
$direction=($lang=='ar' || $lang=='kr')? 'rtl/' : '';
@endphp
<script type="text/javascript">
     var currency="{{env('CURRENCY')}}";
     
</script>
<!-- jQuery -->
<!-- <script src="{!! env('APP_ASSETS') !!}js/jquery.min.js"></script>

<script src="{!! env('APP_ASSETS') !!}{{$direction}}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 -->



<script src="{!! env('APP_ASSETS') !!}{{$direction}}vendor/select2/js/select2.min.js" defer></script>
<!-- Owl Carousel -->
<script src="{!! env('APP_ASSETS') !!}{{$direction}}vendor/owl-carousel/owl.carousel.js" defer></script>
<!-- Custom scripts for all pages-->
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script src="{!! env('APP_ASSETS') !!}js/loader.js" defer></script>
<script src="{!! env('APP_ASSETS') !!}js/lazysizes.min.js" defer></script>
<script src="{!! env('APP_ASSETS') !!}js/custom.js" defer></script>
<script src="{!! env('APP_ASSETS') !!}js/custome_function.js" defer></script>
<script src="{!! env('APP_ASSETS') !!}js/cat_scroll.js" defer></script>
<script src="{!! env('APP_ASSETS') !!}js/checkout.js" defer></script>


<script type="text/javascript">
	document.addEventListener('touchstart', onTouchStart, {capture: true});
</script>