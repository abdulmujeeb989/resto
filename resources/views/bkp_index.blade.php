<!doctype html>
<html lang="en">
    
  @include('include.header')
<style type="text/css">
  .homepage-ads .item img
  {
    display: block;
    width: 100%;
    height: 26vh !important;
  }
  @media (max-width: 575.98px) 
  {
    .homepage-search-block {
        padding: 0rem 0 !important; 
    }
  }
</style>
<link href="{!! env('APP_ASSETS') !!}css/custome_model.css" rel="stylesheet">


    @php
    $rest_uid=$hotel_info_arr['shared_unique_id'];   
    @endphp
     

    <script type="text/javascript">
       var cart_count='{{$total_cart_count}}';
       var cartprice='{{$total_price}}';
    </script>
<body data-spy="scroll" data-target=".scrollSpy-section" data-offset="50">
   
  @include('include.lang_section')
   <nav class="navbar navbar-expand-lg navbar-light bg-light osahan-nav p-3">
      <div class="container resto_title_div">
         <a class="navbar-brand sb-brand" >
            <img class="img-responsive w-15 logo_img" src="{{$hotel_info_arr['main_image']}}" style="height:7vh;"/>
            <center><span class="brand-text">{{$hotel_info_arr['name']}}</span></center>
         </a>
         <a href="https://api.whatsapp.com/send?phone={{$hotel_info_arr['whatsapp_number']}}" target="_blank"><img src="{!! env('APP_ASSETS') !!}img/exported_images/whatsapp.png" class="img-fluid whatsapp-img"></a>
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
                 <ul class="scrollSpy-elements scrollmenu">
                  <?php
                      $isActive='';
                      $i=0;
                      if(!empty($cat_data_arr)):
                        foreach ($cat_data_arr as $key => $value):

                          $cls_name=str_replace(' ', '_', $value['name']);
                          
                          $isActive=($key==count($cat_data_arr))?'active':'';
                          $i++;
                          $img_path=$value['main_image'];
                          $img_path=($img_path!='') ? $img_path : '';
                    ?>
                   <li class="nav-item p-2">
                     <a class="nav-link filter_btn <?php if($key==0){ ?> active <?php } ?>" href="#category-<?php echo $value['id'] ?>">
                        <img src="<?php echo $img_path;?>" class="scrollSpy-img">
                        <b><span class="scrollSpy-text"><?php echo $value['name'];?></span></b>
                     </a>
                   </li>
                    <?php
                      endforeach;
                      endif;
                    ?>
                   
                 </ul>
               </nav>
               <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" data-method="position"  tabindex="1" class="pt-4 pb-4 spy_div">
                   <?php
                      if(!empty($cat_data_arr)):
                        //$hotel_data_arr= msort($hotel_data_arr, array('cate_id'));
                        foreach($cat_data_arr as $category): 

                   ?>

                   <div class="row" style="background-color: #f3f3f3;">
                     <h5 class="mb-4 mt-3 col-md-12" id="category-<?php echo $category['id'] ?>"><b><?php echo $category['name'] ?></b> <!-- <small class="h6 text-black-50"><?php echo count($category['recipes']) ?> ITEMS</small> --></h5>
                   </div>

                    <div id="categorys-<?php echo $category['id'] ?>">

                      <?php
                       
                        foreach ($category['recipes'] as $key => $value) :
                         $data=$value;   

                          $qty=1;
                          
                          $isSession=false;
                          $show_qty_div='none';
                          $hide_add_btn='inline-block';

                          $token=Session::get('tokenid');
                          
                          if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$token]))
                          {

                             foreach ($_SESSION['recipe_list'][$token] as $k => $val) 
                             {
                                if($data['id']==$val['id'])
                                {
                                   $qty=$val['qty'];
                                   
                                   $isSession=true;
                                   $show_qty_div='inline-block';
                                   $hide_add_btn='none';
                                }
                             }

                          }
                          $cat=$value['description'];
                         
                          $obj=json_encode(array("id"=>$data['id'],"name"=>$data['name'],"price"=>(float) str_replace(',', '',$data['price']),"tk"=>$rest_uid,'img'=>$data['main_image'],'description'=>$cat));
                          
                          $description_text = strlen($data['description']) > 70 ? substr($data['description'],0,50)."..." : $data['description']; 

                          $str = $data['description'];
                            if( strlen( $data['description']) > 50) {
                                $str = explode( "\n", wordwrap( $data['description'],70));
                                //$description_text = $str[0] . '...';
                            }

                            
                      ?>

                       <div class="food-items-wrap">
                           <img src="<?php echo $data['main_image'];?>" class="food-img food_img_list" data-obj='<?php echo $obj;?>'>
                           <div class="food-item-name-category">
                              <p class="food-name"><b><?php echo $data['name'];?></b></p>
                              <p class="food-category custome_category"><?php echo $description_text;?></p>
                           </div>
                           <div class="food-item-price-wrap">
                               <button type="button" class="btn btn-sm btn-add add_btn" id="add_btn<?php echo $data['id'];?>" data-obj='<?php echo $obj;?>' style="display: <?php echo $hide_add_btn; ?>;">{{__('label.add')}}</button>

                               <div class="btn-group qty_span" id="qty_span<?php echo $data['id'];?>" role="group" aria-label="Basic example" style="display: <?php echo $show_qty_div; ?>;">
                                  <button type="button" class="btn itemAddRemove-btn dec update_qty" data-status="dec" data-obj='<?php echo $obj;?>'>
                                    <i class="icofont-minus"></i>
                                  </button>

                                  <input class="count-number-input qty<?php echo $data['id'];?> prod_qty btn itemCounts-btn" id="qty<?php echo $data['id'];?>" type="text" value="<?php echo $qty; ?>" readonly="">

                                  <button type="button" class="btn itemAddRemove-btn inc update_qty" data-status="add" data-obj='<?php echo $obj;?>'>
                                    <i class="icofont-plus"></i>
                                  </button>
                               </div>
                               <div class="d-flex justify-content-center">

                                 <p class="food-price"><?php echo $data['price'].'&nbsp;';?>
                                  <p class="food-price">{{env('CURRENCY')}}</p>
                                 </p>
                                  
                                 
                               </div>
                               
                           </div>
                          
                        </div>

                      <?php
                        endforeach;
                      ?>
                   </div>
                   <?php
                        endforeach;
                      endif;
                   ?>
                   <div class="food-items-wrap mb-5"></div>
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
            <img src="{!! env('APP_ASSETS') !!}img/exported_images/arrow-img.png" class="vc-arrow">
           </a> 
         </div>
      </div>
   </section>


@include('include.footer')
<div class="modal-box">
    <!-- Button trigger modal -->
   
    <div class="modal  fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-body">
         <div class="row">
          <div class="col-md-12 text-center">
            <div class="img_brd_div">
            <img src="" id="food_image_tag" class="p-10 ">
          </div>
            
          </div>

          <div class="col-md-12 d-flex justify-content-between">
            <div class="ml-2 col-8">
              <p class="card-text text-left pt-4" >
                 <strong id="s_title"></strong>
              </p>
                   <p class="text-gray mb-2 text-left food-category" id="p_cusine"></p>
            </div>
                   <div class="mr-3 col-5">
                     <h4 id="p_price">55</h4>
                   </div> 
                  
                </div>
                
          </div>
        </div>
            </div>
        </div>
    </div>
    
</div>
</div> 
</body>

</html>

   