$(document).on('click','.list_area_p',function(){
    var id=$(this).data('id');
    $('.close_anchor'+id).show();
    var qty=$('.qty_txt'+id);
	var val=parseInt(qty.attr('data-qty'))+1
	qty.attr('data-qty',val);
    qty.text('X'+val);
    qty.show();
});

$(document).on('click','.close_icon',function(){
    var id=$(this).data('id');
    $('.qty_txt'+id).attr('data-qty','0').text('0').hide();
    $('.close_anchor'+id).css('display','none');
});
$(document).on('click','.qty_btn',function(){
	var req_type=$(this).data('status');
	var id=$(this).data('id');
	
	var qty=$('#qty_inp_box'+id);
	var qty_val=(req_type=='add')? parseInt(qty.val())+1 :(parseInt(qty.val())<0 || parseInt(qty.val())==0) ? 0 :parseInt(qty.val())-1;
	
	$('#qty_inp_box'+id).val(qty_val);
	//$('#qty'+id).val(qty_val);
	if(qty_val==0){
		$( ".chk_option" ).prop( "checked", false );
		$( ".radio_option" ).prop( "checked", false );
		updateCustomeMenuCart();
		
		$('#qty_span'+id).hide();
		$('#add_btn'+id).show();
	}
	
	var status=$(this).data('status');
  
  var obj_string=$(this).data('obj')
  var resJsonstr = JSON.stringify($(this).data('obj'));
  var obj = JSON.parse(resJsonstr)
  
  obj.qty=(isNaN(qty.val()))? 0 :qty.val();
  obj.isempty=(qty_val==0 || qty_val=='0') ? 'true':'false';
  obj.isRepeat='false';
  obj.url='/add_cart';
  
  //addCart(obj)
  customTotal();
	
});
$(document).on('change','.chk_option',function()
{
  customTotal();
  
  
  var head_id=$(this).data('extra-id');
	if($(this).is(":not(:checked)"))
	{
      var id=$(this).data('id');	
	  resetTotal(head_id,id);	
	  $(this).closest('.m_list_div').removeClass('pop_row_bcolor');
	}
	else
	{
	  $(this).closest('.m_list_div').addClass('pop_row_bcolor');	
	}
  //getHeaderTotal(head_id);
});
$(document).on('change','.radio_option',function()
{
  customTotal();
  var head_id=$(this).data('extra-id');
    if($(this).is(":not(:checked)"))
	{ 
	  var id=$(this).data('id');	
	  resetTotal(head_id,id);
	}
	$(this).closest('.m_list_div').addClass('pop_row_bcolor');
	
	$('.radio_option').each(function()
	{   
		if (!$(this).is(":checked")){
			$(this).closest('.m_list_div').removeClass('pop_row_bcolor');
		}
	});
  //getHeaderTotal(head_id);
});
$(document).on('click','.chk_title_option',function()
{
   customTotal();
});
$(document).on('click','.save_custome_order',function()
{
	var i=0;
   $('.choose_item_qt').each(function(){
	   var id=$(this).data('id');
	   var valid=$('#head_option_req_'+id);
	   if(valid.data('isrequired')=='Yes')
	   {
		 var total_req=valid.val();
		 var fields = $(".valid_item_"+id).serializeArray(); 
		 if(fields.length<total_req)
		 {
		   i++;	 
		   $('#head_err_tag_'+id).text('You can choose any '+total_req+' option').show();
		 }
		 else
		 {
			i-1; 	
			$('#head_err_tag_'+id).hide(); 
		 }
	   }
   });	
   if(i==0){
	updateCustomeMenuCart();	
   }
   
});
function getHeaderTotal(head_id){
	var chk_total_price=0;	
	var radio_total_price=0;
	var total_head_amount=0;
	$('.chk_option:checked').each(function()
	{
		var parent_id=$(this).data('extra-id');	
		if(parent_id==head_id)
		{
		  var values =parseFloat($(this).val());
		  values=(isNaN(values)) ? 0: values;
		  chk_total_price +=values;	
		}
		 
	});	
	$('.radio_option:checked').each(function()
	{   
		var parent_id=$(this).data('extra-id');
		if(parent_id==head_id){
			
		  var values =parseFloat($(this).val());
		  values=(isNaN(values)) ? 0: values;
		  radio_total_price += values;		
		}
	});
	$('#head_price'+head_id).each(function()
	{  
		 var values =parseFloat($(this).val());
		 values=(isNaN(values)) ? 0: values;
		 total_head_amount +=values;
	});
	
	$('#head_price_tag'+head_id).text(total_head_amount+radio_total_price+chk_total_price+window.currency)
}
function resetTotal(head_id,id){
	var chk_total_price=0;	
	var radio_total_price=0;
	var total_head_amount=0;
	$('.chk_option:checked').each(function()
	{	
		var parent_id=$(this).data('extra-id');	
		var mid=$(this).data('id');	
		
		if(parent_id==head_id && mid==id)
		{
		  var values =parseFloat($(this).val());
		  values=(isNaN(values)) ? 0: values;
		  chk_total_price +=values;	
		}
		 
	});	
	$('.radio_option:checked').each(function()
	{   
		var parent_id=$(this).data('extra-id');
		var mid=$(this).data('id');	
		
		if(parent_id==head_id){
			
		  var values =parseFloat($(this).val());
		  values=(isNaN(values)) ? 0: values;
		  radio_total_price += values;		
		}
	});
	$('#head_price'+head_id).each(function()
	{  
		 var values =parseFloat($(this).val());
		 values=(isNaN(values)) ? 0: values;
		 total_head_amount +=values;
	});
	
	$('#head_price_tag'+head_id).text(total_head_amount+radio_total_price+chk_total_price+window.currency)
}
function customTotal()
{
  var chk_total_price=0;	
  var radio_total_price=0;
  var chk_title_total=0;
  var total_head_amount=0;
  var result=0;
  
  $('.head_price').each(function()
  {  
	 var values =parseFloat($(this).val());
	 values=(isNaN(values)) ? 0: values;
     total_head_amount +=values;
  });
  
  $('.chk_option:checked').each(function()
  {  
	 var values =parseFloat($(this).val());
	 //$(this).parent('.m_list_div').addClass('pop_row_bcolor');
	 
	 values=(isNaN(values)) ? 0: values;
     chk_total_price +=values;
	 var parent_id=$(this).data('extra-id');
	 getHeaderTotal(parent_id);
  });	
  $('.radio_option:checked').each(function()
  {        
     var values =parseFloat($(this).val());
	 var id=$(this).data('id'); 
	 
	 
	 values=(isNaN(values)) ? 0: values;
     radio_total_price += values;
	 var parent_id=$(this).data('extra-id');
	 getHeaderTotal(parent_id);
  });
  $('.chk_title_option:checked').each(function()
  {        
     var values =parseFloat($(this).val());
	 values=(isNaN(values)) ? 0: values;
     chk_title_total +=values;
  });
  var recepie_price=$('#recepie_no').attr('data-price');
  
  //
  recepie_price=parseFloat(recepie_price);	
  recepie_price=(recepie_price!=0)?recepie_price : total_head_amount;
  
  var qty=parseInt($('.qty_inp_box').val());
  
  result=(recepie_price*qty)+(chk_total_price*qty)+(radio_total_price*qty)+(chk_title_total*qty);
  result1=(recepie_price*qty)+(chk_total_price*qty)+(radio_total_price*qty)+(chk_title_total*qty);
  
  $('.c-t-price').text(result+window.currency)
  return result1;
}
function updateCustomeMenuCart(){
	
   var recepie_id=$('#recepie_no').val();
   var recepie_price=$('#recepie_no').attr('data-price');
   var qty=parseInt($('.qty_inp_box').val());
   var isrepeat=$('#recepie_no').attr('data-isrepeat');
   
   var chk_opt = $(".chk_option:checkbox:checked").map(function(){
      return {'sub_item_id':$(this).data('id'),'extra_id':$(this).data('extra-id'),'title':$(this).data('title'),'parent_title':$(this).data('parent-title'),'price':$(this).data('price')};
    }).get();
	
	var radio_opt= $(".radio_option:radio:checked").map(function(){
      return {'sub_item_id':$(this).data('id'),'extra_id':$(this).data('extra-id'),'title':$(this).data('title'),'parent_title':$(this).data('parent-title'),'price':$(this).data('price')};
    }).get();
	
	 var chk_title_box = $(".chk_title_option:checkbox:checked").map(function(){
      return {'id':$(this).data('id'),'title':$(this).data('title'),'price':$(this).data('price')};
    }).get();
	
	var obj={};
	/*obj.recipe_id=recepie_id;
	obj.recipe_price=recepie_price;
	obj.qty=qty;
	obj.chk_opt=chk_opt;
	obj.radio_opt=radio_opt;
	obj.chk_title=chk_title_box;
	obj.total_amount=customTotal();
	obj.url=base_url+'/updatecustomization';*/
	
	obj.id=recepie_id;
	obj.recipe_price=recepie_price;
	
	obj.qty=qty;
	obj.chk_opt=chk_opt;
	obj.radio_opt=radio_opt;
	obj.chk_title=chk_title_box;
	
	obj.price=customTotal();
	//obj.description=$('#p_cusine').text();
	obj.description='';
	obj.name=$('#s_title').text();
	
	
	
	obj.url=base_url+'/updatecustomization';
	
	obj.is_customized='Yes';
	obj.isRepeat=isrepeat;
	
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
		  if(result.data.record>0){
			 $('#cust_remove_btn'+recepie_id).removeClass('update_qty').addClass('show_cart'); 
		  }
		//alert(result.message)
		$(".t-price").text(getTPrice());
		$("span.cart-item").text(cartcount());
		$('#qty'+obj.id).val(obj.qty);	
        $('#add_btn'+obj.id).hide();
		$('#qty_span'+obj.id).show();
		$('#myModal').modal('toggle');
		
      }
  });
}
$(document).on('click','.check_customize',function(){
  var resJsonstr = JSON.stringify($(this).data('obj'));
  var obj = JSON.parse(resJsonstr)
  $('#add_new').attr('data-obj',resJsonstr);
  $('.update_custome_item').attr('data-obj',resJsonstr);
  
  $.ajax({
      url:base_url+'/getCustomize_sessionss',    //the page containing php script
	  async:true,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "post",    //request type,
      data:obj,
	  dataType: 'html',
      success:function(data)
	  {
		$('.resto_name').text(obj.name);  
		$('.option_name').text(data);  
		$('#exampleModalCenter').modal('show')
      }
  });
});
function create_option_design(obj){
  var str='';
  if(Object.keys(obj).length != 0)
  {
	$.each(obj,function(k,v)
	{
	  var isEmpty=(v.hasOwnProperty("items") && v.items.length!=0)	
	  var head_checkbox='';
	  if(isEmpty)
	  {
		  head_checkbox=`<h5 class="mb-4 mt-3 choose_item_qt" data-id="`+v.id+`" id="head_price_tag`+v.id+`" >`+v.price+window.currency+`</h5>
		  <input type="hidden" value="`+v.price+`" id="head_price`+v.id+`" class="head_price">
		  <input type="hidden" value="`+v.mandatory_amount+`" data-isrequired="`+v.is_mandatory+`" id="head_option_req_`+v.id+`" class="head_price">
		  `;
	  }
	  else
	  {
		head_checkbox=`<div class="d-flex justify-content-between mb-2 ">
				        <input type="hidden" value="`+v.price+`" id="head_price`+v.id+`" class="head_price">
                          <div class="mr-4 mt-2 flex-fill">
                           <small class="price_small mr-3">`+v.price+window.currency+`</small>
                          </div>
                          <div class=" mt-2 flex-fill">
                            <label class="chk_container">
                              <input type="checkbox"  class="chk_title_option" name="chk_title_recepie_name[]" value="`+v.price+`" data-id="`+v.id+`" data-price="`+v.price+`" data-title="`+v.name+`">
                              <span class="checkmark_box checkmark"></span>
                            </label>
                          </div>
                          
                      </div>`;  
	  }
	  str+=`<div class="row m-head-row" style="background-color: #f3f3f3; border-bottom:solid 0px gray;">
               <div class="d-flex justify-content-between bd-highlight col-md-12">

                  <div class="p-1 bd-highlight col-4">
                     <h5 class="mb-4 mt-3 head_text text-left" >
                        <b>`+v.name+`</b> 
                     </h5>
                  </div>
				  <div class="p-1 bd-highlight col-4">
				    <p class="text-danger m-3 text-center" id="head_err_tag_`+v.id+`" style="display:none;">.text-danger</p>
				  </div>
                  <div class="p-1 bd-highlight col-4">
                     `+head_checkbox+`
                  </div>
               </div>
            </div>`;
	   if(isEmpty)
	   {
		 str+=`<div class="row mt-1 m-head-row">`;  
		 var index=0;
		 $.each(v.items,function(key,value)
		 {
			 var price=(value.price==null || value.price=='0') ? 0 : value.price;
			if(value.item_type=='check-box')
			{
			   str+=`<div class="d-flex justify-content-between  mb-0 col-md-12  m_list_div" tabindex="`+index+`">
						<div class="col-8 p-0 mt-2">
						  <p>`+value.name+`</p>
						</div>
						<div class="col p-0 mt-2 form-check form-switch">
						  <label class="chk_container">
						  <input type="checkbox" class="chk_option valid_item_`+v.id+`" name="chk_recepie_name[]" value="`+value.price+`" data-extra-id="`+v.id+`" data-id="`+value.id+`" data-price="`+value.price+`" data-title="`+value.name+`" data-parent-title="`+v.name+`">`
						  if(value.price!='0' && value.price!=null){
							str+=`<small class="price_small">`+value.price+window.currency+`</small>`;  
						  }
						 str+=`<span class="checkmark_box checkmark"></span>
						  </label>
						</div>
					</div>`;	
			}
			else if(value.item_type=='option')
			{
				
				str+=`<div class="d-flex justify-content-between  mb-0 col-md-12  m_list_div" tabindex="`+index+`">
						<div class="col-8 p-0 mt-2">
						  <p>`+value.name+`</p>
						</div>
						<div class="col p-0 mt-2">
						  <label class="chk_container">
								  <input type="radio" class="radio_option valid_item_`+v.id+`" name="radio_recepie_name`+v.id+`[]" value="`+value.price+`" data-extra-id="`+v.id+`" data-id="`+value.id+`" data-price="`+value.price+`" data-title="`+value.name+`" data-parent-title="`+v.name+`">`;
									if(value.price!='0' && value.price!=null)
									{
									  str+=`<small class="price_small">`+value.price+window.currency+`</small>`;  
									}
						  str+=`<span class="checkmark"></span>
						  </label>
						</div>
					</div>`;
			}
		 });
		 str+='</div>';
		   
	   }
	   
	});  
  }
  return str;
}
$(document).on('click','#add_new',function()
{
	var resJsonstr = JSON.stringify($(this).data('obj'));
	var obj = JSON.parse(resJsonstr);
	   $('#exampleModalCenter').modal('toggle');  	
	   $('#p_cusine').text(obj.description);
	   $('#p_price').text(obj.price+' '+currency);
	   $('#s_title').text(obj.name);
	   $('#food_image_tag').attr('src',obj.img)
	   obj.url=base_url+'/getCustomeComponent';
	   var result=getCustomMenucomponent(obj);
	   $('.qty_btn').attr('data-id',obj.id);
	   $('.qty_inp_box').attr('id','qty_inp_box'+obj.id);
	   $('#recepie_no').val(obj.id);
	   $('#recepie_no').attr('data-price',obj.price)
	   $('#recepie_no').attr('data-isrepeat','false')
	   $('.qty_btn').attr('data-obj',resJsonstr);
	   
	   if($('#qty'+obj.id).val()==0){
			//$('#add_btn'+obj.id).click();
	   }
	   //$('#qty_inp_box'+obj.id).val($('#qty'+obj.id).val());
	   
	   customTotal()
	   $('.c-t-price').text(getTPrice());
	   
	   $('#myModal').modal('show')
	
});
$(document).on('click','.show_cart',function(){
	var status=$(this).data('status');
	var obj_string=$(this).data('obj')
	var resJsonstr = JSON.stringify($(this).data('obj'));
	var obj = JSON.parse(resJsonstr);
	
	
	$.ajax({
      url:base_url+'/getCustCart',    //the page containing php script
	  async:true,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "post",    //request type,
      data:obj,
	  dataType: 'html',
      success:function(data)
	  {
		 $('#cart_response').html(data)
		$('#cart_order_template').modal('show');
      }
  });
  
});
$(document).on('click','.update_custome_item',function()
{
	var resJsonstr = JSON.stringify($(this).data('obj'));
	var obj = JSON.parse(resJsonstr);
	var send_obj={};
	
	send_obj.recipe_id=obj.id;
	send_obj.is_customized=obj.is_customized;
	send_obj.isRepeat=obj.isRepeat;
	
	
	$.ajax({
		  url:base_url+'/updatelastcustom',    //the page containing php script
		  async:true,
		  headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  type: "post",    //request type,
		  data:send_obj,
		  dataType: 'json',
		  success:function(data)
		  {
			  if(data.status=='success'){
				  var qty=(isNaN(data.data.qty))? 0 : data.data.qty;
				  
				  $('#qty'+obj.id).val(qty);
				  
				  $(".t-price").text(getTPrice());
				  $("span.cart-item").text(cartcount());
			  }
			$('#exampleModalCenter').modal('toggle');
		  }
	  });
});
$('#myModal').on('hidden.bs.modal', function () {
    $('#response_div').html('')
	$('.qty_inp_box').val(0)
});
function emptyModelClose(){
	var i=0;
	var count = $("#cart_order_template .row").length;
	return count;
}
$(document).on('click','.upd_qty_btn',function()
{
	var status=$(this).data('status');
	var id=$(this).data('id');	
	var row_id=$(this).data('row');	
	 
	var qty=($('#qty_upd_box'+row_id).length>0)? $('#qty_upd_box'+row_id) : $('.qty_inp_box'+row_id);
	var qty_val=(status=='add')? parseInt(qty.val())+1 :(parseInt(qty.val())<0 || parseInt(qty.val())==0) ? 0 :parseInt(qty.val())-1;
	
	qty.val(qty_val)
	
	var obj={};
	obj.qty=(isNaN(qty.val()))? 0 :qty.val();
	
	
	if(qty.val()==0){
		
		if($('#cart_row_'+row_id).length>0)
		{
		  $('#cart_row_'+row_id).remove('');	
		}
		else{
			
			$('.cart_row_'+row_id).remove('');
		}
		
		
	}
	var page=($(this).data('page')) ? $(this).data('page') : false;
	if(status=='dec' && page!=false){
	  var rowcount=emptyModelClose();
	  if(rowcount==0){
		  $('#cart_order_template').modal('toggle');
		  $('#qty'+id).val(0);
		  $('#qty_span'+id).hide();
		  $('#add_btn'+id).show();
	  }
	}
	
	obj.row_id=row_id;
	obj.id=id;
	
	$.ajax({
		  url:base_url+'/update_custome_cart',    //the page containing php script
		  async:true,
		  headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  type: "post",    //request type,
		  data:obj,
		  dataType: 'json',
		  success:function(data)
		  {
			$(".t-price").text(getTPrice());
		    $("span.cart-item").text(cartcount());	
			
			if(data.data.hasOwnProperty("last_qty"))
			{
			  $('#qty'+id).val(data.data['last_qty']); 
			}
			
		  }
	  });
	
});