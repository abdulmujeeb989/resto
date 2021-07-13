<!doctype html>
<html lang="en">
    
  @include('include.header')
  @php $total_price=0; 
   $lang=CommonMethods::getLang();
    $resto_id=(Session::has('resto_id')) ? Session::get('resto_id') : NULL;
    $hide_restp=array();
    /*$hide_resto[]='27437b67-b8f4-46f0-8d12-1dc48e00a08e';*/ //DEV
    $hide_resto[]='3abc00f2-b205-4fd4-a4d4-cb799cabc441';//production
    

    $isVisible=in_array($resto_id,$hide_resto);

  @endphp
  <script type="text/javascript">
   
   var base_url="{{url('/')}}";
   var cart_count='<?php echo $total_cart_count;?>';

</script>
<script src="{!! env('APP_ASSETS') !!}js/jquery_session.js"></script>
 <style type="text/css">
  body{
    background-color: white !important;
  }
  .select2-container--default{
    border: solid 1px #ffa606;
    border-radius:4px; 
  }
  .select2-container--default .select2-selection--single{
    border: 1px solid transparent !important;
  }
  .food-item-price-wrap button.btn{
    /*background-color: rgba(255, 166, 6,.3) !important;*/
  }
  .amt-cal-item{
    font-size: 1.5rem !important;
  }
  .amt-cal-total{
    font-size: 1.9rem !important;
  }
  .btn-co{
    font-size: 1.50rem !important;
  }
  .t-price{
    color:black;
  }
  .itemAddRemove-btn{

  }
</style>
<body data-spy="scroll" data-target="#navbar-example2" data-offset="10">
   
  

    <section class="bg-white confirm-order-wrapper">
      <div class="container">
        <div class="row test">
          <div class="col-md-12">
            <div class="backArrow-yourCart" onclick="window.history.back()">
               @if($lang=='ar' || $lang=='kr')
              
             <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img" style="transform: rotate(180deg);">
              <span class="yc-text">{{__('label.your_cart')}}</span>

              @elseif($lang=='en')
             <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img">
              <span class="yc-text">{{__('label.your_cart')}}</span>
              
              @endif

              
              
            </div>
          </div>
          <div id="cart_div">
            <script type="text/javascript">
              var obj={}
              obj.currency='{{env('CURRENCY')}}'
              var recipe_name=`{!! $recipe_name !!}`;
              checkout_design(obj);
            </script>
          </div>

         <br>
          @if(!$isVisible)
           <div class="col-md-12 mt-2">
                <select class="form-control " id="table_no">
                   <option value="">{{__('label.select_table')}}</option>
                   
                    @if(!empty($resto_table))
                     @foreach($resto_table as $val)
                      <option value="<?php echo $val['id'];?>">{{$val['name']}}</option>
                     @endforeach  
                    @endif
                   
                </select> 
            </div>
           @endif 
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="amt-cal-wrapper">
              <p class="amt-cal-item">
                <span>{{__('label.discount')}}</span>
                <span>0 {{env('CURRENCY')}}</span>
              </p>
              <p class="amt-cal-item">
                <span>{{__('label.deliver_fee')}}</span>
                <span>0 {{env('CURRENCY')}}</span>
              </p>
            </div>
            <div class="d-flex justify-content-between d-flex align-items-center">
              <p class="amt-cal-total">
                <span><b>{{__('label.total')}}</b></span>
                 <!-- <span><b class="t-price"><?php echo number_format(0);?></b></span>  -->
              </p>
               <b><p class="t-price"></p></b>
            </div>
            
            
          </div>
        </div>
         
        <br>
        <div class="alert alert-danger alert-dismissible fade show col-md-12 text-center" role="alert" id="err_div" style="display: none;">
         <strong id="err_msg"></strong>
         <button type="button" class="close" onclick="$('#err_div').slideUp(500);" >
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
        @if(!$isVisible)
        <div class="row mt-5 pt-5">
          <div class="col-md-12 pl-5 pr-5 mt-5 mb-5">
            <button type="button" class="btn btn-co confirm_order"><b>{{__('label.confirm_order')}}</b></button>
          </div>
        </div>
        @endif
      </div>
    </section>

  @include('include.footer')  
  <script src="{!! env('APP_ASSETS') !!}js/custome_menu.js"></script>

  <script type="text/javascript">
    $('div.cart-items-wrap:last').css('border-bottom',' 0px solid ')
  </script>
</body>
</html>