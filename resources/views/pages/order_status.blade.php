<!doctype html>
<html lang="en">
@include('include.header')
@php 
 $total_price=0; 
 $status=false;
 $total=0;

   $token=Session::get('tokenid');
   $lang=CommonMethods::getLang();
   $direction=($lang=='ar' || $lang=='kr')? 'rtl/' : '';
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
            <div class="backArrow-yourCart" onclick="window.history.back()">
              @if($lang=='ar' || $lang=='kr')
                <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img">
                <span class="yc-text inv_bakc_txt">{{__('label.order_status')}}</span>
              
              @elseif($lang=='en')
              <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img">
              <span class="yc-text">{{__('label.order_status')}}</span>
               @endif
            </div>
          </div>
          <div class="col-md-12 text-center pt-10 pb-5" >
            <div class="" style="background-color: #eff3f8; padding: 25px; border-radius: 15px;">
               <img src="{!! env('APP_ASSETS') !!}img/exported_images/success.png" class="img-fluid success-img">
                <p class="placed-text"><?php echo $order_arr['ord_status'];?></p>  
            </div>
            
          </div>
        </div>

        @if(isset($order_arr['items']) && !empty($order_arr))
          @foreach($order_arr['items'] as  $value)
            @php
               $opt_total=0;
               $recipe_total=0;
               if(!empty($value['extra_options']))
               {
                 $opt_total=\App\Http\Controllers\Home::getOptionsTotal($value['extra_options']);
               }
               $recipe_total=$value['price']*$value['quantity']+$opt_total;
               $total=$total+$recipe_total;
               $res=\App\Helpers\CommonMethods::getOptionTotal($value);
               $res=$res+$value['price']*$value['quantity'];
            @endphp
          
                <div class="row mb-5">
                  <div class="col-md-12">
                    <div class="amt-cal-wrapper">
                      
                      <p class="amt-cal-item">
                        <span>{{__('label.price')}}</span>
                        <span>{{number_format($res)}}<span>{{env('CURRENCY')}}</span></span>
                        
                      </p>
                      <p class="amt-cal-item">
                        <span>{{__('label.quantity')}}</span>
                        <span>{{$value['quantity']}}</span>
                      </p>
                      <p class="amt-cal-item">
                        <span>{{__('label.item_name')}}</span>
                        <span>{{$value['recipe_name']}}</span>
                      </p>
                    </div>
                    
                  </div>
                </div>
          @endforeach
        @endif
       <p class="amt-cal-total">
              <span><b>{{__('label.grand_total')}}</b></span>
              <span><b>{{number_format($order_arr['order_total_price'])}}</b><span><b>{{env('CURRENCY')}}</b></span></span>

            </p>
      </div>
    </section>
@include('include.footer_link')
</body>
</html>