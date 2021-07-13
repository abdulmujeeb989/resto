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
<link rel="stylesheet" type="text/css" href="{!! env('APP_ASSETS') !!}css/custome_menu.css">

<body data-spy="scroll" data-target="#navbar-example2" data-offset="10">
   
  

    <section class="bg-white confirm-order-wrapper">
      <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="">
              <img class="GFG" src="{!! env('APP_ASSETS') !!}product_img/test.webp">
			 </div>
            <div class="col-md-12 p-0 mt-4">
              <h3><b>House Paorty (8 Persons)</b></h3>
              <label class="mb-2 mr-sm-2 mr-2 ctext_colo">AED 149.25</label>
              <label class="mb-2 mr-sm-2 text-scratch">AED 199.00</label><br>
              <label class=""><b>Choose Any 8 Paos, Rolls, Maggi + 4 Sides + 8</b></label>
            </div>
            <div class="row" style="background-color: #f3f3f3;">
            	<div class="d-flex justify-content-between bd-highlight col-md-12">
           		     <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 head_text" >
			             	<b> Choose Your Main </b> 
			             </h5>
		             </div>	
		             <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 choose_item_qt" >
			             	Choose at least 8
			             </h5>
		             </div>
		            
            	</div>

           </div>
           <div class="row mt-1">
           	 <div class="col-md-12 d-flex justify-content-between  mb-0 p-1 m_list_div" tabindex="1">
           	 	<p class="qty_txt1 ml-4" data-qty='0' style="display: none;">0</p>
           	 	<p class="pl-5 list_area_p" data-id="1" >Crispy Manchurian Roll (VEG)</p>
           	 	<p class="pr-2 ">44 {{env('CURRENCY')}}</p>
    			<a class="close_anchor1" style="display: none;">
    			  <img src="{!! env('APP_ASSETS') !!}img/Shape 6@2x.png" data-id="1" class="close_icon"> 	
    			</a>
        	</div>
        	<div class="col-md-12 d-flex justify-content-between  mb-0 p-1 m_list_div" tabindex="2">
           	 	<p class="qty_txt2 ml-4" data-qty='0' style="display: none;">0</p>
           	 	<p class="pl-5 list_area_p" data-id="2" >O' Mutton Kheema Pao (Non Veg.)</p>
           	 	<p class="pr-2 ">500 {{env('CURRENCY')}}</p>
    			<a class="close_anchor2" style="display: none;">
    			  <img src="{!! env('APP_ASSETS') !!}img/Shape 6@2x.png" data-id="2" class="close_icon"> 	
    			</a>
        	</div>
             
           </div>
           <div class="row" style="background-color: #f3f3f3;">
            	<div class="d-flex justify-content-between bd-highlight col-md-12">
           		    
		              	
		             <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 head_text">
			             	<b>Choose Your Side</b> 
			             </h5>
		             </div>	
		             <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 choose_item_qt" >
			             	Choose at least 4
			             </h5>
		             </div>
		            
            	</div>

           </div>
           <div class="row mt-1">
           	 <div class="d-flex justify-content-between  mb-0 col-md-12 p-1 m_list_div" tabindex="3">
            		
            		<div class="col-8 mt-2">
            			<p>Crispy Manchurian Roll (VEG)</p>
            		</div>
            		<div class="col mt-2">
            			<label class="chk_container">
						  <input type="radio" name="recepie_name" value="item_1">
						  <span class="checkmark"></span>
						</label>
            		</div>
            	</div>
            	<div class="d-flex justify-content-between  mb-0 col-md-12  p-1 m_list_div" tabindex="4">
            		
            		<div class="col-8 mt-2">
            			<p>Crispy Manchurian Roll (VEG)</p>
            		</div>
            		<div class="col mt-2">
            			<label class="chk_container">
						  <input type="radio" name="recepie_name" value="item_2">
						  <span class="checkmark"></span>
						</label>
            		</div>
            	</div>
           </div>
	         <div class="row" style="background-color: #f3f3f3;">
	        	<div class="d-flex justify-content-between bd-highlight col-md-12">
	       		    <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 head_text">
			             	<b>Choose Your Drink</b> 
			             </h5>
		             </div>	
		             <div class="p-1 bd-highlight">
		             	<h5 class="mb-4 mt-3 choose_item_qt" >
			             	Choose at least 4
			             </h5>
		             </div>
	        	</div>
			</div>
			<div class="row mt-1">
           	 <div class="d-flex justify-content-between  mb-0 col-md-12 p-1 m_list_div" tabindex="3">
            		
            		<div class="col-8 mt-2">
            			<p>Crispy Manchurian Roll (VEG)</p>
            		</div>
            		<div class="col mt-2">
            			<label class="chk_container">
						  <input type="radio" name="recepie1_name" value="item_1">
						  <span class="checkmark"></span>
						</label>
            		</div>
            	</div>
            	<div class="d-flex justify-content-between  mb-0 col-md-12  p-1 m_list_div" tabindex="4">
            		
            		<div class="col-8 mt-2">
            			<p>Crispy Manchurian Roll (VEG)</p>
            		</div>
            		<div class="col mt-2">
            			<label class="chk_container">
						  <input type="radio" name="recepie1_name" value="item_2">
						  <span class="checkmark"></span>
						</label>
            		</div>
            	</div>
           </div>
          </div>
        </div>
        <div class="row">
        	<div class="col mt-5">
        		<div class="food-item-price-wrap">
                   <div class="btn-group qty_span" id="qty_span" role="group" aria-label="Basic example">
                      <button type="button" class="btn decBtn dec chk_update_qty" data-status="dec" >
                        <i class="icofont-minus"></i>
                      </button>

                      <input class="count-number-input qty prod_qty btn qty-input" id="qty" type="text" value="1" readonly="">

                      <button type="button" class="btn addBtn inc chk_update_qty" data-status="add" data-obj=''>
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
	           <a href="{{ url('checkout') }}">
	            <span class="vc-name">{{__('label.view_cart')}}</span>
	            <img src="{!! env('APP_ASSETS') !!}img/exported_images/arrow-img.png" width="14px" height="12px" class="vc-arrow">
	           </a> 
	         </div>
	      </div>
        </section>
         
         
       
      </div>
    </section>

  @include('include.footer')  
  <script src="{!! env('APP_ASSETS') !!}js/custome_menu.js"></script>
</body>
</html>