<!doctype html>
<html lang="en">
@include('include.header_link')
@php 
 $total_price=0; 
 $status=false;
 $token=Session::get('tokenid');
@endphp

<style type="text/css">
  html{
    background-color: white;
  }
  .amt-cal-total{
    font-size: 1.9rem !important;
  }
</style>
<script type="text/javascript">
   var base_url="{{url('/')}}";
</script>
<body data-spy="scroll" data-target="#navbar-example2" data-offset="10">
   

    <section class="bg-white confirm-order-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          
          </div>
          <div class="col-md-12 text-center pt-10 pb-5" >
            <div class="" style="background-color: #eff3f8; padding: 25px; border-radius: 15px; margin-top: 25vh;">
               <img src="{!! env('APP_ASSETS') !!}img/exported_images/error.png" class="img-fluid success-img w-50">
                <p class="placed-text">{{$msg}}</p>  
            </div>
            
          </div>
        </div>
      </div>
    </section>
@include('include.footer_link')
</body>
</html>