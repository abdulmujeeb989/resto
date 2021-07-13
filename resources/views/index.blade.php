<!doctype html>
<html lang="en">
    
  @include('include.header')
<style type="text/css">
  .homepage-ads .item img
  {
    display: block;
    width: 100%;
    height:188px !important;
  }
  .img-div{ 
  max-height: 70px; overflow: hidden }
  @media (max-width: 575.98px) 
  {
    .homepage-search-block {
        padding: 0rem 0 !important; 
    }

  }
</style>
<link href="{!! env('APP_ASSETS') !!}css/custome_model.css"  rel="preload" as="style" onload="this.rel='stylesheet'">
<link rel="stylesheet" type="text/css" href="{!! env('APP_ASSETS') !!}css/custome_menu.css">

    @php
    $rest_uid=$hotel_info_arr['shared_unique_id'];   
    @endphp
     
    <script src="{!! env('APP_ASSETS') !!}js/jquery_session.js"></script>

    <script type="text/javascript">
       var cart_count='{{$total_cart_count}}';
       var cartprice='{{$total_price}}';
       var ischangeResto='{{$ischangeResto}}';
       if(ischangeResto=='true'){
         delete_cart();
       }
    </script>
<body data-spy="scroll" data-target=".scrollSpy-section" data-offset="50">
   
  @include('include.lang_section')
   <nav class="navbar navbar-expand-lg navbar-light bg-light osahan-nav p-3">
      <div class="container resto_title_div">
         <a class="navbar-brand sb-brand" >
            <img class="img-responsive w-15 logo_img" src="{{$hotel_info_arr['main_image']}}" width="52px" height="45px" />
            <center><span class="brand-text">{{$hotel_info_arr['name']}}</span></center>
         </a>
         
         <a href="https://wa.me/{{$hotel_info_arr['whatsapp_number']}}" target="_blank"><img width="52px" height="45px" src="{!! env('APP_ASSETS') !!}img/exported_images/whatsapp.png" class="img-fluid whatsapp-img"></a>
      </div>
   </nav>
   <section class=" homepage-search-block position-relative bg-white ">
      <div class="banner-overlay"></div>
      <div class="container">
         <div class="row d-flex align-items-center">
            <div class="col-md-12">
               <div class="homepage-search-title">
                  <div class="owl-carousel homepage-ads">
                      
                       @if(isset($hotel_info_arr['gallery']) && !empty($hotel_info_arr['gallery']))
                         @foreach($hotel_info_arr['gallery'] as $key => $value)
                       <div class="item text-center">
                          <img src="{{$value}}" width="199" height="160" class="img-fluid">
                       </div>
                        @endforeach
                       @endif
                      
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="section bg-white homepage-add-section">
      <div class="container">
         <div class="row">
            <div class="col-md-12 p-0 mt-3 ">
               <nav id="navbar-example2" class="navbar navbar-light bg-white scrollSpy-section p-0 filters button-group js-radio-button-group filters-button-group">
                 <ul class="scrollSpy-elements scrollmenu" id="category-ul">
                   @php
                      $isActive='';
                      $payload='';
                  @endphp

                   @if(!empty($cat_data_arr))  

                   @php
                      $payload = json_encode($cat_data_arr);
                      $payload = preg_replace("_\\\_", "\\\\\\", $payload);
                      $payload = preg_replace("/\"/", "\\\"", $payload);
                   @endphp
                    <script type="text/javascript">
                         var json_text="{!! $payload !!}";
                         var cat_name=`{!! $cat_name !!}`;
                         if(json_text!=''){
                          var obj=JSON.parse(json_text)
                          load_category(obj); 
                         }
                          
                    </script>
                    
                   @endif
                  
                   
                 </ul>
               </nav>
               <div data-spy="scroll"  data-target="#navbar-example2" data-offset="0" data-method="position"  tabindex="1" class="pt-4 pb-4 spy_div">
                  <script type="text/javascript">
                         var json_text="{!! $payload !!}";
                         var obj=JSON.parse(json_text)
                         var lbl_obj={};

                         var recipe_name=`{!! $recipe_name !!}`;
                         lbl_obj.currency="{{env('CURRENCY')}}";
                         lbl_obj.add_bnt="{{__('label.add')}}";
                         lbl_obj.isCustomize="{{__('label.customizable')}}";
                         load_recipe_list(obj,lbl_obj);
                    </script>
                  
                   
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="view-cart">
      <div class="view-cart-wrap">
         <div class="pl-3">
            <span class="cart-item">0</span>
            <span class="t-price"></span>
         </div>
         <div class="vc-name-image">
           <a href="{{ url('checkout') }}">
            <span class="vc-name">{{__('label.view_cart')}}</span>
            <img src="{!! env('APP_ASSETS') !!}img/exported_images/arrow-img.png" width="14px" height="12px" class="vc-arrow">
           </a> 
         </div>
      </div>
   </section> 

<div class="modal-box">
   <!-- Button trigger modal -->
   <div class="modal  fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
         <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <div class="modal-body">
                <input type="hidden" id="recepie_no" data-price="" data-isrepeat="" value="" name="">
                  <section class="bg-white confirm-order-wrapper">
                     <div class="container">
                        <div class="row mt-0">
                           <div class="col-md-12 p-0" id="main_column_body">
                              <div class="">
                                 <img class="GFG" src="" id="food_image_tag">
                              </div>
                              <div class="col-md-12 p-0 mt-4">
                                 <h3><b id="s_title"></b></h3>
                                 <label class="mb-2 mr-sm-2 mr-2 ctext_colo" id="p_price"></label>
                                 <!-- <label class="mb-2 mr-sm-2 text-scratch">AED 199.00</label><br> -->
                                 <label class=""><b id="p_cusine"></b></label>
                              </div>
                              <div id="response_div" class="cust-model-overflow">
                                
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col mt-3">
                              <div class="food-item-price-wrap">
                                 <div class="btn-group qty_span" id="qty_span" role="group" aria-label="Basic example">
                                    <button type="button" class="btn decBtn dec  qty_btn"  data-status="dec" data-id="" data-obj="">
                                      <i class="icofont-minus"></i>
                                    </button>
                                      <input class="count-number-input btn qty-input qty_inp_box " id="qty_inp_box" type="text" value="0" readonly="">
                                      <button type="button" id="addBtn" class="btn addBtn inc  qty_btn "   data-status="add" data-id="" data-obj="">
                                      <i class="icofont-plus"></i>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <section class="mt-3 mb-3 ord_btn_sec">
                           <div class="view-cart-wrap">
                              <div class="pl-3">
                                 <!-- <span class="cart-item">0</span> -->
                                 <span class="c-t-price t-price"></span>
                              </div>
                              <div class="vc-name-image">
                                 <a class="save_custome_order">
                                 <span class="vc-name">{{__('label.addtoorder')}}</span>
                                 <img src="{!! env('APP_ASSETS') !!}img/exported_images/arrow-img.png" width="14px" height="12px" class="vc-arrow">
                                 </a> 
                              </div>
                           </div>
                        </section>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-box">
    <!-- Button trigger modal -->
   
    <div class="modal  fade" id="recipe_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-body">
         <div class="row">
          <div class="col-md-12 text-center">
            <div class="img_brd_div">
            <img src=""  class="GFG" id="food_image_tag1" class="p-10 ">
          </div>
            
          </div>

          <div class="col-md-12 d-flex justify-content-between">
            <div class="ml-2 col-8">
              <p class="card-text text-left pt-4" >
                 <strong id="s_title1"></strong>
              </p>
                   <p class="text-gray mb-2 text-left food-category" id="p_cusine1"></p>
            </div>
                   <div class="mr-3 col-5">
                     <h4 id="p_price1" class="mt-5">55</h4>
                   </div> 
                  
                </div>
                
          </div>
        </div>
            </div>
        </div>
    </div>
    
</div>
</div> 

<div class="modal-box">
   <!-- Button trigger modal -->
   <div class="modal  fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
         <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <div class="model_head">
                 <h3 class="modal-title text-center">{{__('label.last_use_costomization')}}</h3>
               </div>
               <div class="modal-body">
                  <div class="resto_name"></div>
                  <div class="option_name">
                    
                  </div>
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" id="add_new" data-obj='' class="btn btn-secondary d-block view-cart-wrap text-center w-50 cust-h-model-btn">{{__('label.add_new')}}</button>
                  <button type="button" data-obj='' class="btn btn-primary view-cart-wrap text-center d-block  w-50 cust-h-model-btn update_custome_item">{{__('label.repeat_last')}}</button>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-box">
   <!-- Button trigger modal -->
   <div class="modal  fade" id="cart_order_template" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
         <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <div class="model_head">
                 <h3 class="modal-title text-center">{{__('label.remove_your_items')}}</h3>
               </div>
               <div class="modal-body">
                   <div id="cart_response">
                     
                   </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('include.footer')
<script src="{!! env('APP_ASSETS') !!}js/custome_menu.js"></script>
<script type="text/javascript">
  $(document).ready(function() 
  {
        
      /* Centering the modal vertically */
      /*function alignModal() {
          var modalDialog = $(this).find(".modal-dialog");
          modalDialog.css("margin-top", Math.max(0, 
          ($(window).height() - modalDialog.height()) / 2));
      }
      $(".modal").on("shown.bs.modal", alignModal);*/

      /* Resizing the modal according the screen size */
     /*$(window).on("resize", function() {
          $(".modal:visible").each(alignModal);
      });*/
  });
</script>
</body>

</html>

   