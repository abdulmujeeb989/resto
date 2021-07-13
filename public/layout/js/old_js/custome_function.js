var cartprice=0;
var cart = [];
$(document).on('click', '.view_order', function()
{
	$('#confirm_btn').data('');
	$('#reject_btn').data('');
	
	var obj_string=$(this).data('obj');
	var resJsonstr = JSON.stringify($(this).data('obj'));
	var obj = JSON.parse(resJsonstr);
  
	$('#order_id').val('').val(obj.id);
  	$('#confirm_btn').attr('data-obj',JSON.stringify(obj_string));
	$('#reject_btn').attr('data-obj',JSON.stringify(obj_string));
  	$('#tprice').addClass('tprice'+obj.id);
    obj.request='getOrderdetails';
    //$('#add-address-modal').modal()
  
     $('.order_list_view').html('');
     //$('.list_itm').html('')
	 
	  $.ajax({
		   type: "POST",
		   headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   },
		   url:base_url+'/getOrderdetails',
		   data:obj, // serializes the form's elements.
		   dataType:'json',
		   success: function(data)
		   {
			   if(data.length != 0)
			   {
				   if(data.order_list)
				   {
				     $('.order_list_view').html(data.order_list);
				     $('#tprice').text(data.total_price);
			       }
				   $('.list_itm').html(getList());
				   var item=$.grep(cart, function(e){ return e.order_id == obj.id; });
				   if(item.length!=0)
				   {
					  $.each(item,function(k,v)
					  {
					    $('#qty_input'+v.id).val(v.Qty); 
					  });
				    }
					 
					$('#add-address-modal').modal();
				}
			  }
		 });
  
	//$('#add-address-modal').modal()
})
$(document).on('click','.add_order',function(){
	var order_id=$('#order_id').val();
	var item=$.grep(cart, function(e){ return e.order_id == order_id; });
	if (item.length === 0) {
			alert('Please Add New Items')
	}
	
	var obj={};
	obj.url=base_url+'/addItemsOrder';
	obj.request='addItemsOrder';
	obj.list=item;
	obj.order_id=order_id;

	addItems(obj);
});
$(document).on('click',".options", function()
{
	var action=$(this).data('action');
	var wait=	$(this).data('wait');
	var resJsonstr = JSON.stringify($(this).data('obj'));
	var data_obj = JSON.parse(resJsonstr);
	if(action=='reject')
	{
		if($('#reason_box').is(":visible"))
		{
			if($('#reaseon_input').val()=='')
			{
				alert('Enter Reject Reaseon');
				return false;
			}  
		}
		else
		{
			$('#reason_box').show(1000);  
			return false;  
		}
		
	
	}
  
  
  data_obj.url=base_url+'/add_orders';
	/*
	var upd_data=[];
	$('.qty_input').each(function(k,v){
		var obj=$(this).data('obj');

		upd_data.push({
		  'id':obj.id,
		  'qty':$(this).val(),
		  'order_id':obj.order_id
		})
	})*/
	data_obj.wait=wait;
	if(action=='confirm'){
	  data_obj.status='Send_to_Kitchen';
	  data_obj.request='confirm_order_update';		
     updateOrder_status(data_obj);
     
	}
	if(action=='reject'){
	  data_obj.status='Rejected';
	  data_obj.request='confirm_order_update';		
     updateOrder_status(data_obj);
     
	}

})
//old add cart function
/*$(document).on('click','.add_btn', function(){
  $(this).hide();
  var qty_cont=$(this).siblings('.qty_span');
	//$(this).next('.btn-group').toggleClass("d-iFlex");
  qty_cont.find('.prod_qty').val(1);
  qty_cont.show();
  
  var obj_string=$(this).data('obj');
  var resJsonstr = JSON.stringify($(this).data('obj'));
  var obj = JSON.parse(resJsonstr);
  obj.qty=1;
  obj.isempty='false';
  obj.url='/add_cart';

  addCart(obj);
  if($.isFunction(getCartDesign)) 
  {
    getCartDesign();		
  }
	 
  setTimeout(function() 
  {
    $(".t-price").text(getTPrice());
	$("span.cart-item").text(cartcount());
  }, 400);
  
})*/
$(document).on('click','.add_btn', function(){
  $(this).hide();
  var qty_cont=$(this).siblings('.qty_span');
	//$(this).next('.btn-group').toggleClass("d-iFlex");
  qty_cont.find('.prod_qty').val(1);
  qty_cont.show();
  
  var obj_string=$(this).data('obj');
  var resJsonstr = JSON.stringify($(this).data('obj'));
  var obj = JSON.parse(resJsonstr);
  obj.qty=1;
  obj.isempty='false';
  
  
  obj.recipe_price=obj.price;
  obj.price=obj.price;
  obj.is_customized=obj.is_customized;
  obj.isRepeat='false';
  obj.url='/add_cart';
  
  

  addCart(obj);
  if($.isFunction(getCartDesign)) 
  {
    getCartDesign();		
  }
	 
  setTimeout(function() 
  {
    $(".t-price").text(getTPrice());
	$("span.cart-item").text(cartcount());
  }, 400);
  
})
$(document).on('click', '.confirm_order', function()
{

	var btn = document.getElementsByClassName('confirm_order');
    btn.disabled = true;
	var tbl=$('#table_no').val();
	//var table=$('#table_no').val()
	if(tbl=='' || tbl=='0')
	{
	  btn.disabled = false;
	  return false;
	}
	$.ajax({
	   type: "POST",
	   url:base_url+'/confirm_order',
	   headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
	   data:{'customer':'','table':tbl}, // serializes the form's elements.
	   dataType:'json',
	   success: function(data)
	   {
			if(data.type=='success')
			{
				data=data.data;
				window.location.href='order_status/'+data.order_id;
			}	
			else(data.type=='error')
			{
				//$('#err_msg').text(data.msg);
				//$('#err_div').show(500);
			}
	   }
	 });
	 //btn.disabled = false;
	//window.location.href='';
});

$(document).on('click', '.log_btn', function(){
	var user_name=$('#inputEmail').val()
	var upwd=$('#inputPassword').val()
	$('#w_log_frm').submit()
});
$(document).on('click', '.lang_btn', function(){
	
	$.ajax({
	   type: "GET",
	   async:true,
	   url:base_url+'/changeLang',
	   dataType:'json',
	   success: function(data)
	   {
		 
	   }
	 });
	window.location.reload(true);
})
$(document).on('click', '.logout_waiter', function(){
	
	$.ajax({
	   type: "POST",
	   async:true,
	   headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
	   url:base_url+'/logout',
	   dataType:'json',
	   success: function(data)
	   {
		  location.reload(true);	 
	   }
	 });
})
function changeLang(){
	
}
$(document).on('click', '.qty_update', function(){
	

	 var status=$(this).data('status');
	 var list_from=$(this).data('list');
     var obj_string=$(this).data('obj');
	 var resJsonstr = JSON.stringify($(this).data('obj'));
	 var obj = JSON.parse(resJsonstr);
	 
	 var orderid=$('#order_id').val();
	 
	 var qty=$('#qty_input'+obj.id);
	 var qty_val=(status=='add')? parseInt(qty.val())+1 :(parseInt(qty.val())<0 || parseInt(qty.val())==0) ? 0 :parseInt(qty.val())-1;
	 //alert(qty.val()+'='+obj.id)
	 $('#qty_input'+obj.id).val(qty_val);
	 obj.qty=qty.val();
	 obj.orderid=orderid;
	 obj.list_from=list_from;
	 if(list_from=='upd_list')
	 {
	    obj.url=base_url+'/update_order';
	 	obj.request='update_order';
		
		updateToCart(obj);
	 }
	 else if(list_from='new_items')
	 {
 		
		addToCart(obj);
	 }
	  
})
$(document).on('click', '.update_qty', function(){
  var status=$(this).data('status');
  
  var obj_string=$(this).data('obj')
  var resJsonstr = JSON.stringify($(this).data('obj'));
  var obj = JSON.parse(resJsonstr)
  
  
  var qty=$('.qty'+obj.id)
  var qty_val=(status=='add')? parseInt(qty.val())+1 :(parseInt(qty.val())<0 || parseInt(qty.val())==0) ? 0 :parseInt(qty.val())-1;
  
  qty.val(qty_val)
  
  obj.qty=(isNaN(qty.val()))? 0 :qty.val();
	
  obj.isempty=(qty_val==0 || qty_val=='0') ? 'true':'false';
  
  if(qty_val==0){
	  $('#qty_span'+obj.id).hide();
	  $('#add_btn'+obj.id).show();
  }	
  obj.isRepeatelse=(status=='dec')? 'Yes' : 'No';
  obj.recipe_price=obj.price;
  obj.price=obj.price;
  obj.is_customized=obj.is_customized;
  obj.url='/add_cart';
  
  addCart(obj)
  if ($.isFunction(getCartDesign)) {
	   getCartDesign()		
	}
	//window.location.href=''
	setTimeout(function() {
		$(".t-price").text(getTPrice());
		$("span.cart-item").text(cartcount());
	}, 400);
  
})

function addCart(obj)
{
	$.ajax({
	   type: "POST",
	   url:base_url+obj.url,
	   headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
	   data:obj, // serializes the form's elements.
	   dataType:'json',
	   success: function(data)
	   {
		  //var obj = JSON.parse(data)
		  if(data.data!=null)
		  {
			alert(data)
			var cart_desing=createCart(data);
			$('#cart_div').html(cart_desing)  
		  }
		  
	   }
	 });
	 if ($.isFunction(getCartDesign)) {
	   getCartDesign()		
	 }
	 
  	
}
function updateOrder_status(obj){
  $.ajax({
      url:obj.url,    //the page containing php script
      type: "post", 
      headers: {
	   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },   //request type,
      data:obj,
      dataType: 'json',
      success:function(data)
      {
				 
			   console.log(data)
				 if(data.type=='success')
      	 {
					data=data.data
      		alert(data.message)
		      window.location.href="";
      	 }
      	 else
      	 {
      		alert(data.message);
      	 }
		  
      }
  });
}
function addItems(obj)
{
	$.ajax({
      url:obj.url,    //the page containing php script
	  async:true,
	  headers: {
	   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
      type: "post",    //request type,
      data:obj,
      dataType: 'json',
      success:function(data)
      {
				  if(data.type=='success')
					{
						removeCartitem(obj.list,obj.order_id) 		
						alert(data.data.message);
						getLatest_List(obj.order_id);	
						//$('.tprice'+obj.order_id).text(result);
					}
					else
					{
						alert('error',data.message);
					}
				
      }
  });
}
function removeCartitem(data,order_id)
{	
	for(var i = 0; i < data.length; i++) 
	{
		
	    if(cart[i].order_id == order_id) {
	    	
	       deleteItem(i);
	        break;
	    }
	}
}
function createCart(data)
{
   var str=``;
   var total_amt=0;
   	$.each(data,function(k,v)
	{	
		  var tprice=(v.t_price==null) ? 0 : v.t_price;
		  total_amt=total_amt+tprice;
		  str+=`<div class="gold-members p-2 border-bottom">
			   <p class="text-gray mb-0 float-right ml-2">`+tprice+' '+window.currency+`</p>
			   <span class="count-number float-right qty_span">
			   <button class="btn btn-outline-secondary  btn-sm left dec update_qty" data-status="dec" data-obj='{"id":"`+v.id+`","name":"`+v.name+`","price":"`+v.price+`"}'> 
			   <i class="icofont-minus"></i> </button>
			   <input class="count-number-input prod_qty" id="qty`+v.id+`" type="text" value="`+v.qty+`" readonly="">
			   <button class="btn btn-outline-secondary btn-sm right inc update_qty" data-status="add" data-obj='{"id":"`+v.id+`","name":"`+v.name+`","price":"`+v.price+`"}'> 
			   <i class="icofont-plus"></i> </button>
			   </span>
			   <div class="media">
				  <div class="mr-2"><i class="icofont-ui-press text-danger food-item"></i></div>
				  <div class="media-body">
					 <p class="mt-1 mb-0 text-black">`+v.name+`</p>
				  </div>
			   </div>
			</div>`;
	})
	$('.totla_amt_lbl').text(total_amt+' '+currency)
	return str;
}
function refreshCart()
{
  var xhttp = new XMLHttpRequest();
	xhttp.open("POST", base_url+'script/comm_function.php', true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("request=getCart");
	document.getElementById("demo").innerHTML = xhttp.responseText;  
}
function showCartDiv(status)
{
	
	if(status=='show')
	{
		$('.container-f-width').removeAttr( 'style' ).css('max-width','66%')
		$('#cart_list_div').show()
		
	}
	else{
		$('#cart_list_div').hide()
		$('.container-f-width').css('min-width','100%')
	}
}
function cartcount()
{
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	 if (this.readyState == 4 && this.status == 200) 
	 {
		window.cartqty= this.responseText
	  }
	};
	xhttp.open("GET",base_url+'/cartqty', false);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("request=cartqty");
	return cartqty;
}
function getCartDesign()
{
   $.ajax({
      url:base_url+'/cart_html',
      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "get",
      dataType: 'html',
      success:function(result){
         
         var html_obj=$(result)
         var isMobile=window.matchMedia("(max-width: 767px)").matches;
         if(result=='')
         {
            showCartDiv('hide')
         }
         else
         {
            if(!isMobile)
            {
              showCartDiv('show')   
            }
            
         }
         var total_amt=html_obj.filter('.cart_total_input').val()
         total_amt=(typeof total_amt === "undefined") ? 0 : total_amt;
		 
         $('#totla_amt_lbl').text(total_amt+' '+currency);
         $('#cart_div').html(result)
      }
  });
   
   //
}
function getTPrice(){
	
	$.ajax({
      url:base_url+'/cartprice',    //the page containing php script
	  async:false,
      type: "GET",    //request type,
      dataType: 'text',
      success:function(result)
      {
      	window.cartprice= result;
      }
  });
	return cartprice;
}
$(document).on('click','.food_img_list',function(){
    
   var isOpen=$(this).data('iscustomize');	
   if(isOpen=='Yes'){
	   //return false;
   }
   var resJsonstr = JSON.stringify($(this).data('obj'));
   var obj = JSON.parse(resJsonstr)
	
   $('#p_cusine1').text(obj.description);
   $('#p_price1').text(obj.price+' '+currency);
   $('#s_title1').text(obj.name);
   $('#food_image_tag1').attr('src',obj.img)
    
   
   $('#recipe_info').modal('show')
   
  
})
$(document).on('click','.food_img_list1',function(){
    
   var resJsonstr = JSON.stringify($(this).data('obj'));
   var obj = JSON.parse(resJsonstr)
	  
   /*$('#myModalLabel').text(obj.name);
   $('#p_cusine').text(obj.description);
   
   
   
   */
   $('#p_cusine').text(obj.description);
   $('#p_price').text(obj.price+' '+currency);
   $('#s_title').text(obj.name);
   $('#food_image_tag').attr('src',obj.img)
   obj.url=base_url+'/getCustomeComponent';
   var result=getCustomMenucomponent(obj);
   $('.qty_btn').attr('data-id',obj.id);
   $('.qty_inp_box').attr('id','qty_inp_box'+obj.id);
   $('#recepie_no').val(obj.id);
   $('#recepie_no').attr('data-price',obj.price);
   $('#recepie_no').attr('data-isrepeat',obj.isRepeat);
   $('.qty_btn').attr('data-obj',resJsonstr);
   
   if($('#qty'+obj.id).val()==0){
		//$('#add_btn'+obj.id).click();
		
   }
   //$('#qty_inp_box'+obj.id).val(1);
   
   customTotal()
   
   $('.c-t-price').text(getTPrice());
   
   $('#myModal').modal('show')
   
  
})
function getCustomMenucomponent(obj){
	$.LoadingOverlay("show");
	var str='';
	$.ajax({
      url:obj.url,    //the page containing php script
	  async:true,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "post",    //request type,
      data:obj,
      dataType: 'json',
      success:function(result)
      {
		if(result!='' && result!=null){
			
		  //$('#main_column_body').removeClass('col-md-12').addClass('col-md-14');	
		  $('#response_div').html(create_option_design(result));
			$('.addBtn').click();
		}  
		
		
		$.LoadingOverlay("hide");
      },
	  error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        //$('#post').html(msg);
		$.LoadingOverlay("hide");
    },
  });
  return str;
}
function updateToCart(obj){
	$.ajax({
      url:obj.url,    //the page containing php script
	  async:true,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "post",    //request type,
      dataType: 'json',
      data:obj,
      success:function(result){

         //$('.tprice'+obj.orderid).text(result);
      }
  });
}
function addToCart(obj) {
		// update Qty if product is already present
		for (var i in cart) 
		{
			if(cart[i].id == obj.id)
			{
				if(obj.qty=='0'){
					deleteItem(i)
				}
				else{
				 cart[i].Qty = obj.qty;  // replace existing Qty	
				}
				
				//showCart();
				saveCart();
				return;
			}
		}

		var item = {'order_id':obj.orderid,id:obj.id,Qty:obj.qty,price:obj.price };
		cart.push(item);
		saveCart();
}
function saveCart() {
		if (window.localStorage)
		{
				localStorage.cart = JSON.stringify(cart);
		}
}
function deleteItem(index){
		cart.splice(index,1); // delete item at index
		saveCart();
}
function getLatest_List(orderid){
 
  $.ajax({
      url:base_url+'/latestlist',    //the page containing php script
	  async:true,
      type: "post",    //request type,
      headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
      dataType: 'json',
      data: {"order_id":orderid},
      success:function(result){
         $('.order_list_view').html(result.html);
         //$('.tprice'+orderid).text(result.total)
      }
  });
}
function getorder_List(orderid){
 $.ajax({
      url:base_url+'/order_newlist',    //the page containing php script
	  async:true,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
      type: "post",    //request type,
      dataType: 'json',
      data: {"order_ids":orderid},
      success:function(result)
	  {
		 var old_total=parseInt($('#pending_count').text());
		 var new_total=parseInt(result.total);
			 
		 if(old_total<new_total)
		 {
		   $('#pending_count').text(result.total);
		   $('#pending_count').addClass('badge-danger'); 
	     }	
		 $('#pending_ids').val(result.ids);	
         $('#latest_list').append(result.html);
				 
      }
  });
}
