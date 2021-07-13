<!doctype html>
<html lang="en">
    
  @include('include.header')
  @php $total_price=0; 
   $lang='ar';
    $resto_id=(Session::has('resto_id')) ? Session::get('resto_id') : NULL;
    $hide_restp=array();
    /*$hide_resto[]='27437b67-b8f4-46f0-8d12-1dc48e00a08e';*/ //DEV
    $hide_resto[]='7437b67-b8f4-46f0-8d12-1dc48e00a08e';//production
    

    $isVisible=in_array($resto_id,$hide_resto);

  @endphp
  <script type="text/javascript">
   
   var base_url="{{url('/')}}";
   var cart_count='0';

</script>
<link rel="stylesheet" type="text/css" href="{!! env('APP_ASSETS') !!}css/resto_menu.css">
<link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/demo/side-drawer-modal-bootstrap/bootstrap-side-modals.css?v3">
<body data-spy="scroll" data-target="#navbar-example2" data-offset="10">
   
  

    <section class="bg-white confirm-order-wrapper">
      <div class="container">
        <!-- <div class="row test">
          <div class="col-md-12">
            <div class="backArrow-yourCart" onclick="window.history.back()">
               @if($lang=='ar')
              
             <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img" style="transform: rotate(180deg);">
              <span class="yc-text">{{__('label.your_cart')}}</span>

              @elseif($lang=='en')
             <img src="{!! env('APP_ASSETS') !!}img/exported_images/orangeArrow.png" class="img-fluid orangeArrow-img">
              <span class="yc-text">{{__('label.your_cart')}}</span>
              
              @endif

              
              
            </div>
          </div>
        </div> -->

        <div class="row mt-5">
          <div class="col-md-12">
            <div class="">
              <img class="GFG" src="{!! env('APP_ASSETS') !!}product_img/test.webp">
			      </div>
            <div class="col-md-12 p-0 mt-4">
              <h3><b>House Paorty (8 Persons)</b></h3>
              <p class="resto_add_p">asdasdsadasdasdassdasdasdadassssssssssssssssssssssssssssssssssssssssssss</p>
            </div>
            <div class="col-md-12 p-0 mt-4">
              <ul class="list-unstyled detail_ul">
                 <li>
                   <a class="btn icon-btn pill_a">
                    <i class="icofont-clock-time icofont_icon"></i>
                    <b>40 - 50 min</b>
                    </a>
                 </li>
                 <li>
                   <a class="btn icon-btn pill_a">
                    <i class="icofont-basket icofont_icon"></i>
                     <b>AED 20.00 minimum basket</b>
                    </a>
                 </li>
                 <li>
                   <div class="d-flex justify-content-start mb-3">
                    <i class="icofont-check-circled icofont_icon pr-2"></i>
                      <div>
                        <h5><b>Loyalty Program</b></h5>
                       <p class="text-secondary">available</p>
                      </div>
                      
                   </div> 
                 </li>
              </ul>
            </div>
            <div class="row" style="background-color:#fffaee;">
              <div class="d-flex justify-content-between bd-highlight col-md-12 mt-3">
                   <div class="p-1 bd-highlight">
                     <a class="btn icon-btn pill_a">
                      
                      <h5>
                        <i class="icofont-location-pin icofont_icon"></i>
                        <b>Delivering to</b>
                      </h5>
                    </a>
                    <div class="d-flex justify-content-end">
                      <p>Select Location</p>
                   <i class="icofont-rounded-down icofont_icon" onclick="opendilevery_popup()"></i>
                  </div>
                 </div> 
                 <div class="p-1 bd-highlight">
                    <article>
                        <div class='btn-group btn-group-border'>
                            <button class="button button4 active">Dilevery</button>
                            <button class="button button4">Pickup</button>
                        </div>
                    </article>
                 </div>
                
              </div>

           </div>
          </div>
        </div>
        <section class="section bg-white homepage-add-section">
   <div class="container">
      <div class="row">
         <div class="col-md-12 p-0 mt-3 ">
            <nav id="navbar-example2" class="navbar navbar-light bg-white scrollSpy-section p-0 filters button-group js-radio-button-group filters-button-group">
               <ul class="scrollSpy-elements scrollmenu">
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn  active " href="#category-40">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-krybat-main_image-1614108547.png" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-krybat-main_image-1614108547.png">
                        </div>
                        <b><span class="scrollSpy-text">كريبات</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn " href="#category-41">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-mshrobat-sakhn-main_image-1614108820.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-mshrobat-sakhn-main_image-1614108820.jpg">
                        </div>
                        <b><span class="scrollSpy-text">مشروبات ساخنة</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn " href="#category-42">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-mshrobat-bard-main_image-1614109517.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-mshrobat-bard-main_image-1614109517.jpg">
                        </div>
                        <b><span class="scrollSpy-text">مشروبات باردة</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn " href="#category-43">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-alsltat-main_image-1614112670.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-alsltat-main_image-1614112670.jpg">
                        </div>
                        <b><span class="scrollSpy-text">السلطات</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn " href="#category-44">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-almtbkh-alshrky-main_image-1614236490.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-almtbkh-alshrky-main_image-1614236490.jpg">
                        </div>
                        <b><span class="scrollSpy-text">المطبخ الشرقي</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn " href="#category-46">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-ksm-alfkhar-main_image-1614238398.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-ksm-alfkhar-main_image-1614238398.jpg">
                        </div>
                        <b><span class="scrollSpy-text">قسم الفخار</span></b>
                     </a>
                  </li>
                  <li class="nav-item p-2">
                     <a class="nav-link filter_btn active1" href="#category-47">
                        <div class="img-div">
                           <img class="scrollSpy-img lazyloaded" width="100" height="auto" data-srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-almtbkh-albhry-main_image-1614239492.jpg" srcset="https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/thumbnails/category-almtbkh-albhry-main_image-1614239492.jpg">
                        </div>
                        <b><span class="scrollSpy-text">المطبخ البحري</span></b>
                     </a>
                  </li>
               </ul>
            </nav>
            <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" data-method="position"  tabindex="1" class="pt-4 pb-4 spy_div">
               <div class="row" style="background-color: #f3f3f3;">
                  <h5 class="mb-4 mt-3 col-md-12" id="category-40">
                     <b>كريبات</b> <!-- <small class="h6 text-black-50">6 ITEMS</small> -->
                  </h5>
               </div>
               <div id="categorys-40">
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/foakh-main_image-1614068986.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>فواكه</b></p>
                              <p class="food-category custome_category">كريب بالفواكه ووفقا لتقرير حكومي أمريكي، نشرت موسكو "مزاعم مضللة أو لا أساس لها" بشأن الفائز النهائي، جو بايدن.
                                 لكنه قال إن أي حكومة أجنبية لم تخترق النتائج النهائية. ونفت روسيا مرارا مزاعم التدخل في الانتخابات.
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">8,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kalksy-main_image-1614107339.jpg)" class="recepie_img_div">                                
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>كالكسي</b></p>
                              <p class="food-category custome_category">كالكسي كريب</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">8,000&nbsp;</p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/mks-main_image-1614108149.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>مكس</b></p>
                              <p class="food-category custome_category">كريب مشكل</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">8,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/byar-alsham-main_image-1614497931.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>بيارة الشام</b></p>
                              <p class="food-category custome_category">كريب بيارة الشام المميز</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">10,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/tbk-foakh-main_image-1614498077.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>طبق فواكه</b></p>
                              <p class="food-category custome_category">طبق كريب بالفواكه</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">10,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/tbk-foakh-vip-main_image-1614498162.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>طبق فواكه VIP</b></p>
                              <p class="food-category custome_category">طبق كريب فواكه خاص</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">25,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row" style="background-color: #f3f3f3;">
                  <h5 class="mb-4 mt-3 col-md-12" id="category-41">
                     <b>مشروبات ساخنة</b> <!-- <small class="h6 text-black-50">13 ITEMS</small> -->
                  </h5>
               </div>
               <div id="categorys-41">
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/asbryso-main_image-1614069676.jpeg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>اسبريسو</b></p>
                              <p class="food-category custome_category">قهوة اسبريسو</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">4,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/asbryso-mykato-main_image-1614070266.png)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>اسبريسو ميكاتو</b></p>
                              <p class="food-category custome_category">قهوة اسبريسو ميكاتو</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">4,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kho-amryky-main_image-1614106841.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>قهوة أمريكي</b></p>
                              <p class="food-category custome_category">اهلا .... يا هلة</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kho-aarby-main_image-1614070634.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>قهوة عربية</b></p>
                              <p class="food-category custome_category">قهوة عربية</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">3,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kho-trky-main_image-1614070852.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>قهوة تركية</b></p>
                              <p class="food-category custome_category">قهوة تركية</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">3,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kho-frnsy-main_image-1614111414.jpeg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>قهوة فرنسي</b></p>
                              <p class="food-category custome_category">قهوة فرنسية</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">4,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kho-gklyty-main_image-1614111983.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>قهوة جكليتية</b></p>
                              <p class="food-category custome_category">قهوة جكليتية</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">4,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kbgyno-main_image-1614112318.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>كبجينو</b></p>
                              <p class="food-category custome_category">كبجينو فاخر</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/nskafyh-main_image-1614112499.png)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>نسكافيه</b></p>
                              <p class="food-category custome_category">نسكافيه</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/hot-goklyt-main_image-1614498500.jpg)" class="recepie_img_div"></div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>هوت جوكليت</b></p>
                              <p class="food-category custome_category">هوت جوكليت</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/kofy-latyh-main_image-1614498734.jpg)" class="recepie_img_div">
                           </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>كوفي لاتيه</b></p>
                              <p class="food-category custome_category">كوفي لاتيه</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/moka-main_image-1614498895.jpg)" class="recepie_img_div"> </div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>موكا</b></p>
                              <p class="food-category custome_category">موكا</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">5,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="food-items-wrap row mt-2">
                     <div class="col-8 d-flex justify-content-between plc-0">
                        <div class="d-flex justify-content-end">
                           <div style="background-image: url(https://dev.taiftec.com/dmenu/admin/public/uploads/main_image/asbryso-dbl-main_image-1614499073.jpg)" class="recepie_img_div"></div>
                           <div class="food-item-name-category">
                              <p class="food-name"><b>اسبريسو دبل</b></p>
                              <p class="food-category custome_category">اسبريسو دبل</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-4 ccol-4 plc-0">
                        <div class="food-item-price-wrap">
                           <div class="d-flex justify-content-center">
                              <p class="food-price">6,000&nbsp;                                  </p>
                              <p class="food-price"> د. ع </p>
                              <p></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
        <!-- <section class="mt-4 mb-5">
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
        </section> -->
     </div>
    </section>

    <div class="modal fade bottom" id="exampleFrameModal2" tabindex="-1" aria-labelledby="exampleFrameModal2" data-gtm-vis-first-on-screen-2340190_1302="60350" data-gtm-vis-total-visible-time-2340190_1302="100" data-gtm-vis-has-fired-2340190_1302="1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-frame modal-bottom">
          <div class="modal-content">
            <div class="modal-body py-1">
              <div class="drawer__container">
               <!----> 
               <div data-v-2f862855="" class="basket-mode__view-drawer">
                  <div data-v-2f862855="">
                     <h4 class="font-black text-lg leading-normal m-2 mx-4">
                        Delivering to
                     </h4>
                     <a href="#" class="flex items-center transition-all duration-500 ease-in-out focus:bg-black-100 outline-none hover:bg-black-100 hover:text-black-900 hover:no-underline p-4">
                        <div class="flex items-center w-full">
                           <div class="pr-2">
                              <i class="icofont-location-pin icofont_icon"></i>
                           </div>
                           <div class="d-flex justify-content-between">
                              <!----> <small class="text-secondary">Select location</small>
                              <span class="text-color-orange">Change</span>
                           </div>
                        </div>
                        
                     </a>
                     <!---->
                  </div>
                  <hr class="border border-black-100 mt-2 mb-2">
                  <div class="bg-white pt-3 pb-2 mb-3">
                     <h4 class="font-black text-lg leading-normal mb-2 mx-4">
                        Delivery time
                     </h4>
                     <a href="#" data-test="select-time-button" class="flex items-center transition-all duration-500 ease-in-out focus:bg-black-100 outline-none hover:bg-black-100 hover:text-black-900 hover:no-underline p-4">
                        <div class="flex items-center w-full">
                           <div class="pr-2">
                              <i class="icofont-clock-time icofont_icon"></i>
                           </div>
                           <div data-test="selected-timing" class="w-full d-flex justify-content-between">
                            <small class="font-bold text-dark">ASAP</small>
                              <span class="text-color-orange">
                               Change
                              </span>
                           </div>
                           
                        </div>
                     </a>
                     <!---->
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
      
        $(".btn-group > .btn").click(function(){
            $(".btn-group > .btn").removeClass("active");
            $(this).addClass("active");
        });
    });
    function opendilevery_popup(){
      $("#exampleFrameModal2").modal()
    }
  </script>
</body>
</html>