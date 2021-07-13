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
<link rel="stylesheet" type="text/css" href="{!! env('APP_ASSETS') !!}css/resto_location.css">
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
              <div class="d-flex justify-content-start mb-3">
                <i class="icofont-check-circled icofont_icon pr-2"></i>
                  <div>
                    <h5><b>Loyalty Program</b></h5>
                   <p class="text-secondary">available</p>
                  </div>
                  
               </div> 
            </div>
            <div class="row" style="background-color:#fffaee;">
               <div class="col-md-12 p-1 bd-highlight ml-3">
                    <div class="btn-group btn-group-toggle w-100 button_div_tag" data-toggle="buttons">
                      <label class="btn btn-secondary btn-lg loc_btn  btn-left">
                        <a >Pickup</a>
                      </label>
                      <label class="btn btn-secondary btn-lg active loc_btn btn-right">
                        <a >Delivery</a>
                      </label>
                    </div>
               </div>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-md-12  bd-highlight mt-5">
             <form class="explore-outlets-search mb-0">
               <div class="input-group">
                  <input type="text" placeholder="Search for dishes..." class="form-control rounded-pill search_input">
                  <div class="input-group-append">
                     <button type="button" class="btn btn-link">
                     <i class="icofont-search"></i>
                     </button>
                  </div>
               </div>
            </form>
           </div> 
        </div>
        <div class="row">
          <div class="col-md-12">
             <ul id="accordion" class="accordion">
              <li>
                <div class="link ">
                  Dubai <i class="icofont-simple-down"></i>
                </div>
                <ul class="submenu p-0">
                  <li>
                    <div class="d-flex bd-highlight mb-3">
                      <div class="mr-auto p-2 bd-highlight">locatin 1</div>
                      <div class="p-2 bd-highlight">
                        <a>
                          <i class="icofont-simple-left"></i>
                        </a>
                      </div>
                    </div>

                  </li>
                  <li>
                    <div class="d-flex bd-highlight mb-3">
                      <div class="mr-auto p-2 bd-highlight">locatin 1</div>
                      <div class="p-2 bd-highlight">
                        <a>
                          <i class="icofont-simple-left"></i>
                        </a>
                      </div>
                    </div>

                  </li>
                  <li>
                    <div class="d-flex bd-highlight mb-3">
                      <div class="mr-auto p-2 bd-highlight">locatin 1</div>
                      <div class="p-2 bd-highlight">
                        <a>
                          <i class="icofont-simple-left"></i>
                        </a>
                      </div>
                    </div>

                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col mt-5">
            <div class="food-item-price-wrap">
                   <div class="btn-group qty_span" id="qty_span" role="group" aria-label="Basic example">
                      <button type="button" class="btn decBtn " data-status="dec" >
                        <i class="icofont-minus"></i>
                      </button>

                      <input class="count-number-input qty prod_qty btn qty-input" id="qty" type="text" value="1" readonly="">

                      <button type="button" class="btn addBtn" data-status="add" data-obj=''>
                        <i class="icofont-plus"></i>
                      </button>
                   </div>
                   
               </div>
          </div>
        </div>
        <section class="mt-4 mb-5">
          <div class="view-cart-wrap">
           <div class="pl-3">
              <span class="cart-item">0</span>
              <span class="t-price"></span>
           </div>
           <div class="vc-name-image">
             <a>
              <span class="vc-name">{{__('label.view_cart')}}</span>
              <img src="{!! env('APP_ASSETS') !!}img/exported_images/arrow-img.png" width="14px" height="12px" class="vc-arrow">
             </a> 
           </div>
        </div>
        </section>
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
    $(function() {
      var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.link');
        // Evento
        links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
      }

      Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
          $this = $(this),
          $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
          $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
      } 

      var accordion = new Accordion($('#accordion'), false);
    });
    $(document).ready(function() 
    {
      
        $(".btn-group-toggle > .btn").click(function(){
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