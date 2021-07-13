var cart=getAllItems();

function add_cart_obj(obj)
{
	var isExist=exist_cart_id(obj.recipe_id);
	if(obj.isCustomized=='Yes')
	{
	   if(obj.isRepeat=='true')
	   {
		 if(!$.isEmptyObject(isExist))
		 {
			 
		 }			 
		   
	   }
	   else if(obj.hasOwnProperty('isRepeatelse') && obj.isRepeatelse=='Yes')
	   {
		 update_cart_id(obj);
		 render_cal();
		 return false;		 
	   }
	   if(obj.qty!=0 && obj.price!=0)
	   {
		   insertObject(obj);
		   var data_obj={};
		   var total_rec=(exist_cart_id(obj.recipe_id).length!=0 && !$.isEmptyObject(exist_cart_id(obj.recipe_id)))? exist_cart_id(obj.recipe_id).length : 0;
		   data_obj.recored=total_rec;
		   data_obj.item_qty=get_cart_qty_id(obj.recipe_id);
		   render_cal();
		   return data_obj;
	   }	   
	}
	else
	{
	  if(obj.qty==0){
		  
		  delete_cart_id(obj.recipe_id);
		  render_cal();
		  return false;
	  }	
	  if(!$.isEmptyObject(isExist))
	  {
		update_cart_id(obj);	
		var data_obj={};
		var total_rec=(exist_cart_id(obj.recipe_id).length!=0 && !$.isEmptyObject(exist_cart_id(obj.recipe_id)))? exist_cart_id(obj.recipe_id).length : 0;
		
		data_obj.recored=total_rec;
		data_obj.item_qty=get_cart_qty_id(obj.recipe_id);
		
		render_cal();
		
		var row_price=exist_cart_rowid(isExist[0].row_id);

		var row_prices=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].totla_price : 0;
		var row_qty=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].qty : 0;
		
		data_obj.row_item_price=row_prices;
		data_obj.row_item_qty=row_qty;
	
		return data_obj;
		
	  }
	  else
	  {
		insertObject(obj);	
		var data_obj={};
		var total_rec=(exist_cart_id(obj.recipe_id).length!=0 && !$.isEmptyObject(exist_cart_id(obj.recipe_id)))? exist_cart_id(obj.recipe_id).length : 0;
		data_obj.recored=total_rec;
		data_obj.item_qty=get_cart_qty_id(obj.recipe_id);
		render_cal();

		var row_price=exist_cart_rowid(obj.row_id);
		var row_prices=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].totla_price : 0;
		var row_qty=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].qty : 0;
		
		data_obj.row_item_price=row_prices;
		data_obj.row_item_qty=row_qty;
	
		return data_obj;
	  }	
	}		
    render_cal();
 
	//console.log(update_cart_id(obj))
}
function insertObject(obj)
{
	if(localStorage.foodCart)
    {
     foodCart= JSON.parse(localStorage.getItem('foodCart'));
	 
	}
	else
	{
     foodCart=[];
	 
    }
	
	foodCart.push(obj)
	localStorage.setItem('foodCart', JSON.stringify(foodCart));
	
}

function exist_cart_id(id)
{
	
    var data = getAllItems();
	
	
	if(data!=null)
	{
	  var marvelHeroes =  data.filter(function(hero) 
		{
			return hero.recipe_id == id;
		});
		return marvelHeroes;
	}
	else
	{
		return null;
	}
}
function exist_cart_rowid(row_id)
{
	
    var data = getAllItems();
	if(data!=null)
	{
		
	 var res=data.filter(function(item) 
   	  { 
		 return item["row_id"] ==row_id; 
	  });
	  return res;	
	}
	
}
function getAllItems()  
{    
	var strg=localStorage.getItem("foodCart")
	var data=(strg== null)? null : JSON.parse(strg);
	
	return data;
	
}
function get_cart_totalamount(){
	var total=0;
	var data = getAllItems()
	if(!$.isEmptyObject(data) && data.length!=0){
	  data.filter(function(item) 
	 { 
	   return total=total+item['totla_price'];
	 });	
	}
	
	return total;
}
function get_cart_totalAmount_id(id){
	var total=0;
	var data = getAllItems()
	if(!$.isEmptyObject(data) && data.length!=0){
	    data.filter(function(item) 
		{ 
		   return item['recipe_id']==id
		});
		
		if(data.length!=0){
			$.each(data,function(k,v){
				total=total+v.totla_price;
			});
		}	
	}
	
	return total;
}

function get_cart_count_id(id){
   var data = getAllItems().filter(function(item) 
	{ 
	   return item['recipe_id']==id
	});	
	return data.length;
}
function update_cart(obj){
 
}
function update_cart_id(obj)
{
	var vdata=[];
	var data = getAllItems();
	if(data.length!=0 && !$.isEmptyObject(data)){
		$.each(data,function(k,v)
		{
		   if(v.recipe_id==obj.recipe_id && obj.qty!=0){
			   v.qty=obj.qty;
			   var option_total=getOption_price(v.row_id);
			   var core_price=parseFloat(v.recipie_price);
			   var total=(core_price+option_total);
			   v.totla_price =total*v.qty;
			   
			   
		   }
		   else if(v.recipe_id==obj.recipe_id && obj.qty==0){
			   return true;
		   }
		   vdata.push(v);	  
		});
		
		localStorage.setItem('foodCart', JSON.stringify(vdata));  
		return true;
	}
	
     
}
function delete_cart_arr(id){
	var data = getAllItems();
	
	if(!$.isEmptyObject(data))
	{
	  
	  
	  var result = $.grep(data, function(e){ 
	  
		 return e.recipe_id != id; 
	  });
	  return result;
	  
	}
	return null;
}
function getLastReceipeRowid(id){
	var data=getAllItems();
	var row_id='';
	
	if(!$.isEmptyObject(data))
	{
	 $.each(data,function(k,v)
	  {
	    if(id==v.recipe_id)
	    {
		  row_id=v.row_id;
		   
		}
		
	  });	
	  
	}
	return row_id;
}
function update_customize_cart(obj){
	var data=getAllItems();
	var xdata=[];
	var data_obj={};
	if(!$.isEmptyObject(data))
	{
		var record=exist_cart_id(obj.recipe_id);
		
		if(record.length>1 && !$.isEmptyObject(record))
		{
		  var row_id=getLastReceipeRowid(obj.recipe_id);	
		  obj.row_id=row_id;
		  var res=update_customize_cart_repeat(obj);
		  
		  return res;
		}
		
	  $.each(data,function(k,v)
	  {
	    if(obj.recipe_id==v.recipe_id)
	    {
		   v.qty=parseInt(v.qty)+1;
		   var option_total=getOption_price(v.row_id);
		   var core_price=parseFloat(v.recipie_price);
		   var total=(core_price+option_total);
		   v.totla_price =total*v.qty;
		   
		}
		xdata.push(v)
	  });	
	  localStorage.setItem('foodCart', JSON.stringify(xdata));  
	}
	
	
	data_obj.recipe_qty=get_cart_qty_id(obj.recipe_id);
	data_obj.record=exist_cart_id(obj.recipe_id);
	return data_obj;
		
}
function update_customize_cart_repeat(obj){
	var data=getAllItems();
	var xdata=[];
	var data_obj={};
	
	if(!$.isEmptyObject(data))
	{
	  $.each(data,function(k,v)
	  {
	    if(obj.row_id==v.row_id)
	    {
		   v.qty=parseInt(v.qty)+1;
		   var option_total=getOption_price(v.row_id);
		   var core_price=parseFloat(v.recipie_price);
		   var total=(core_price+option_total);
		   v.totla_price =total*v.qty;
		   
		   //console.log(v.qty,option_total,core_price,total*v.qty)
		   
		}
		xdata.push(v)
	  });	
	  localStorage.setItem('foodCart', JSON.stringify(xdata));  
	}
	
	
	data_obj.recipe_qty=get_cart_qty_id(obj.recipe_id);
	data_obj.record=exist_cart_id(obj.recipe_id);
	return data_obj;
		
}
function getOption_price(row_id)
{
  var data=exist_cart_rowid(row_id);
  var total=0;
  if(!$.isEmptyObject(data))
  {
	$.each(data,function(k,v){
	  if(!$.isEmptyObject(v.options))
	  {
		$.each(v.options,function(key,value)
		{
		  if(!$.isEmptyObject(v.options))
		  {
			$.each(value,function(i,val)
			{
				total=parseFloat(total+val.price)
			});  
		  }
			
		});
	  }
	});  
	
  }
  return total;
}
function update_customize_cart_rowid(obj){
	var data=getAllItems();
	var xdata=[];
	var data_obj={};
	
	if(!$.isEmptyObject(data))
	{
	  $.each(data,function(k,v)
	  {
	    if(obj.id==v.recipe_id && v.row_id==obj.row_id && obj.qty!=0)
	    {
		   v.qty=parseInt(obj.qty);
		   var option_total=getOption_price(v.row_id);
		   var core_price=parseFloat(v.recipie_price);
		   var total=(core_price+option_total);
		   v.totla_price =total*v.qty;
		   

		   
		}
		else if(obj.id==v.recipe_id && v.row_id==obj.row_id && obj.qty==0)
		{
		  return true;	
		}
		xdata.push(v)
	  });
	  
	  localStorage.setItem('foodCart', JSON.stringify(xdata));  
	}
	data_obj.recipe_qty=get_cart_qty_id(obj.id);
	data_obj.record=exist_cart_id(obj.id);
	
	var row_price=exist_cart_rowid(obj.row_id);
	var row_prices=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].totla_price : 0;
	var row_qty=(!$.isEmptyObject(row_price) && row_price.length!=0) ? row_price[0].qty : 0;
	
	data_obj.row_item_price=row_prices;
	data_obj.row_item_qty=row_qty;
	return data_obj;
		
}
function get_last_qty(id)
{
	var data=exist_cart_id(id);
	var total=0
	if(!$.isEmptyObject(data))
	{
	  $.each(data,function(k,v)
	  {
		total=v.qty;  
	  });	
	}
	return total;
}
function convert_option_raw(obj){
	
	var text_response='';
	$.ajax({
      url:base_url+'/conv_json',    //the page containing php script
	  async:false,
	  headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   },
      type: "post",    //request type,
      data:{'options':obj},
	  dataType: 'html',
      success:function(data)
	  {
		text_response=data;
      }
  });
	return text_response;
	
	
}
function cart_option_json_id(id){
	
}
function cart_option_json_rowid(row_id){
	
}
function get_cart_qty_id(id){
	var qty=0;
	var data = getAllItems().filter(function(item) 
	{ 
	   return item['recipe_id']==id
	});
	if(data.length!=0){
		$.each(data,function(k,v){
			qty=qty+v.qty;
		});
	}
	return qty;
}
function get_cart_qty(){
	var qty=0;
	var data = getAllItems();
	if(!$.isEmptyObject(data) && data.length!=0){
		$.each(data,function(k,v){
			qty=qty+v.qty;
		});
	}
	return qty;
}
function delete_cart(){
	localStorage.removeItem("foodCart");
}
function delete_cart_id(id)
{
	var data = getAllItems();
	
	if(!$.isEmptyObject(data))
	{
	  
	  
	  var result = $.grep(data, function(e){ 
	  
		 return e.recipe_id != id; 
	  });
	  
	  if(!$.isEmptyObject(result))
	  {
		localStorage.setItem('foodCart', JSON.stringify(result));  
		
	  }
	  else
	  {
		localStorage.removeItem("foodCart");
	  }
	  
	}
	
	
	
}
function delete_cart_rowid(row_id){
	
	  const data = getAllItems();
		
		if(data.length!=0)
		{
		  
		  var removeByAttr = function(arr, attr, value)
		  {
			var i = arr.length;
			while(i--)
			{
				if( arr[i] && arr[i].hasOwnProperty(attr) && (arguments.length > 2 && arr[i][attr] === value ))
				{ 
				  arr.splice(i,1);
				}
			}
			return arr;
		  }
		  
		  var result=removeByAttr(data, 'recipe_id',id);
		  localStorage.setItem('foodCart', JSON.stringify(result));
	}
}
function get_cart_option_amount_rowid(row_id){
	
}

function load_category(obj){
   
   var y=0;
   
	 y=(cat_name=='')? 0 : JSON.parse(cat_name);
	
  if(obj.length!=0)
  { 

    var isActive='';
    var str=''; 
	//console.log(obj)
	$.each(obj,function(k,v)
	{
	  isActive=(k==obj.length)?'active':'';	
	  
	  var img_path=v.thumbnail;
	  img_path=(img_path!='') ? img_path : '';
	  		var name=v.name

	      
				if(y!=0){
					var res1=$.map( y, function( val, i ) 
					{
						//i==id , val==name
							
						 if(i==v.id && lang=='kr'){
							 name=val;
							 
						 	 return val;
						 }
				  	 
				  });	
				}
				
			
	  str+=`<li class="nav-item p-2">
			   <a class="nav-link filter_btn `+isActive+`" href="#category-`+v.id+`">
				<div class="img-div">
				  <img  class="scrollSpy-img lazyload"  width="100" height="auto"  data-srcset="`+img_path+`">
				</div>
				  <b><span class="scrollSpy-text">`+name+`</span></b>
			   </a>
			 </li>`;	
	});
	
	$('#category-ul').html(str)
	
	
	
  }
}
function load_recipe_list(cat_obj,lbl)
{
	
	var x=(recipe_name=='') ? 0 : JSON.parse(recipe_name);
  var cat=(cat_name=='') ? 0 : JSON.parse(cat_name);
	str='';
	if(cat_obj.length!=0)
	{
		var isrtl=(lang=='ar' || lang=='kr')? 'plc-0' : '';
	  $.each(cat_obj,function(k,v)
	  {
	  	var cat_name=v.name;

	  	if(cat!=0){
					res1=$.map( cat, function( val, i ) 
					{
						
						//i==id , val==name
						 if(i==v.id && lang=='kr'){
						 	 cat_name= val;

						 }
				  	 
				  });	
				}

		str+=`<div class="row" style="background-color: #f3f3f3;">
				<h5 class="mb-4 mt-3 col-md-12" id="category-`+v.id+`"><b>`+cat_name+`</b> </h5>
		   </div>`;  
		str+=`<div id="categorys-`+v.id+`">`;   
		if(v.recipes.length!=0)
		{
		   $.each(v.recipes,function(key,value)
		   {
			  var qty=0;
              var isSession=false;
			  var show_qty_div='none';
			  var hide_add_btn='inline-block';

			  var cat=value.description;
                         
			  
			
			  var description_text =value.description; 
			  var recipe_data=0;	
			  //var cust_edit_class=($recipe_data!=0 && $recipe_data>1) ? 'show_cart' : 'update_qty'; 
			  var cust_edit_class='update_qty';
				var isCartsession=exist_cart_id(value.id);
				
				if(!$.isEmptyObject(isCartsession))
				{
				    qty=get_cart_qty_id(value.id) 
				    isSession=true;
				    show_qty_div='inline-block';
				    hide_add_btn='none';
					if(value.is_customized=='Yes'){
						cust_edit_class=(typeof isCartsession === 'object' && isCartsession !== null && isCartsession.length>1)? 'show_cart' :cust_edit_class;
					}   
					
					 
				   
				   
				   
				}
				
				var name=value.name;

				if(x!=0){
					res=$.map( x, function( val, i ) 
					{
						
						//i==id , val==name
						 if(i==value.id && lang=='kr'){

						 	description_text=val.desc
						 	 name= val.title;
							 
						 }
				  	 
				  });	
				}
				
			  var vobj={"id":value.id,"name":name,"price":value.price.replace(",", ""),"tk":'','img':value.main_image,'description':description_text,'is_customized':value.is_customized,'isRepeat':'false'};
			  str+=`<div class="food-items-wrap row mt-2">
					  <div class="col-8 d-flex justify-content-between `+isrtl+`">
						<div class="d-flex justify-content-end">
						   <div>
							 <img  class="food-img food_img_list lazyload" data-iscustomize="{{$data['is_customized']}}" width="85px" height="85px" data-srcset="`+value.thumbnail+`" data-obj='`+JSON.stringify(vobj)+`'>
						   </div>
						   <div class="food-item-name-category">
							  <p class="food-name"><b>`+name+`</b></p>
							  <p class="food-category custome_category">`+description_text+`</p>
						   </div>
						</div>
					  </div>
					  <div class="col-4 `+isrtl+`">
						<div class="food-item-price-wrap">`;
						  if(value.is_customized=='Yes')
						  {
							str+=`<button type="button" class="btn btn-sm btn-add  food_img_list1" id="add_btn`+value.id+`" data-obj='`+JSON.stringify(vobj)+`' style="display:`+hide_add_btn+`;">`+lbl.add_bnt+`</button>

							   <div class="btn-group qty_span" id="qty_span`+value.id+`" role="group" aria-label="Basic example" style="display:`+show_qty_div+`;">`

								 
								 
								  vobj.isRepeat='false';
								  str+=`<button type="button" class="btn itemAddRemove-btn dec `+cust_edit_class+`"  data-status="dec" data-obj='`+JSON.stringify(vobj)+`' id="cust_remove_btn`+value.id+`">
									<i class="icofont-minus"></i>
								  </button>

								  <input class="count-number-input qty`+value.id+` prod_qty btn itemCounts-btn" id="qty`+value.id+`" type="text" value="`+qty+`" readonly="">`;
								  
								  
								  vobj.isRepeat='true';
								  str+=`<button type="button" class="btn itemAddRemove-btn inc check_customize" data-status="add" data-obj='`+JSON.stringify(vobj)+`'>
									<i class="icofont-plus"></i>
								  </button>
							   </div>`;   
						  }
						  else
						  {
							str+=`<button type="button" class="btn btn-sm btn-add add_btn" id="add_btn`+value.id+`" data-obj='`+JSON.stringify(vobj)+`' style="display:`+hide_add_btn+`;">`+lbl.add_bnt+`</button>

							   <div class="btn-group qty_span" id="qty_span`+value.id+`" role="group" aria-label="Basic example" style="display:`+show_qty_div+`;">
								  <button type="button" class="btn itemAddRemove-btn dec update_qty" data-status="dec" data-obj='`+JSON.stringify(vobj)+`'>
									<i class="icofont-minus"></i>
								  </button>

								  <input class="count-number-input qty`+value.id+` prod_qty btn itemCounts-btn" id="qty`+value.id+`" type="text" value="`+qty+`" readonly="">

								  <button type="button" class="btn itemAddRemove-btn inc update_qty" data-status="add" data-obj='`+JSON.stringify(vobj)+`'>
									<i class="icofont-plus"></i>
								  </button>
							   </div>`;  
						  }	
						  if(value.price!=0){
							str+=`<div class="d-flex justify-content-center">
								<p class="food-price">`+value.price+`&nbsp;
								<p class="food-price">`+lbl.currency+`</p>
							   </p>
							 </div>`;	  	  
						  }
						  
						
						   
						   
							 
								if(value.is_customized=='Yes'){
								 str+=`<div class="d-flex justify-content-center">
								  <p class="p_orange font-weight-bold">`+lbl.isCustomize+`</p>
								 </div>`;
								}
						   
					  str+=`</div></div></div>`;
		   });	
		}
	  });	
	  str+='<div class="food-items-wrap mb-5"></div>';
	  $('.spy_div').html(str)
	}
}
function get_cart_item_html(id){
  var data=exist_cart_id(id);	
  var str='';
  if(data.length!=0 && !$.isEmptyObject(data)){
	  $.each(data,function(k,v)
	  {
		str+=`<div class="row" id="cart_row_`+v.row_id+`">
                 <div class="col-8 product_content text-left">
                    <h4>`+v.name+`</h4>
                    <p>`+v.desc+`</p>
                 </div>
                 <div class="col-4">
                    <div class="food-item-price-wrap">
                       <div class="btn-group qty_span" id="qty_span" role="group" aria-label="Basic example">
                          <button type="button" class="btn decBtn dec upd_qty_btn" data-row="`+v.row_id+`" data-status="dec" data-id="`+v.recipe_id+`" data-obj="">
                            <i class="icofont-minus"></i>
                          </button>
                            <input class="count-number-input btn qty-input qty_inp_box " id="qty_upd_box`+v.row_id+`" type="text" value="`+v.qty+`" readonly="">
                            <button type="button" class="btn addBtn inc upd_qty_btn " data-row="`+v.row_id+`" data-status="add" data-id="`+v.recipe_id+`" data-obj="">
                            <i class="icofont-plus"></i>
                          </button>
                       </div>
                    </div>
                 </div>
               </div>`;  
	  });
  }
  return str;
}
function checkout_design(objs)
{

	var x=(recipe_name=='') ? 0 : JSON.parse(recipe_name);
  var str='';	
  var data = getAllItems()
  if(!$.isEmptyObject(data) && data.length!=0)
  {
	var i=0;  
	var total=0;
	$.each(data,function(k,v)
	{
		 
		var isCustomize=v.isCustomized;
		var total=total+parseFloat(v.totla_price);

		var price=(isCustomize=='Yes') ? v.totla_price : v.recipie_price;
		var obj={'id':v.recipe_id,'name':v.name,'price':v.price,'tk':'','description':v.desc,'is_customized':v.isCustomized};
		

		var borde_class=(data.length==1 && i==0) ? 'border-bottom:0px solid #dbdbdb' : '';
		 i++;
		 var customize_class=(v.isCustomized=='Yes') ? 'upd_qty_btn' : 'update_qty';

		 if(x!=0){
				res=$.map( x, function( val, i ) 
				{
					//i==id , val==name
					 if(i==v.recipe_id){
					 	description_text=val.desc
					 	 v.name=val.title;

					 	 v.desc=val.desc;
					 }
			  	 
			  });	
			}
		 
	  str+=`<div class= chk_maindiv cart_row_`+v.row_id+`"  id="chk_maindiv_`+v.recipe_id+`">
            <div class="cart-items-wrap  w-100" style="`+borde_class+`">
               <div class="container">
				  <div class="row w-100">
				    <div class="col-sm col-8 flex-sm-shrink-0 d-flex ">
				      <div class="cart-item-name-category">
		                  <div class="col-sm">
		                      <p class="cart-name">`+v.name+`</p>
			                  <p class="cart-category">`+v.desc+`</p>
			                  <p class="cart-price price_row_`+v.row_id+`"><b>`+v.totla_price+' '+objs.currency+`</small></b></p>
						  </div>
		               </div>
				    </div>
				    
				    <div class="col-sm col-4 flex-shrink-1">
				       <div class="food-item-price-wrap">
		               	 <div class="col-sm">
		                   <div class="btn-group qty_span" id="qty_span`+v.recipe_id+`" role="group" aria-label="Basic example">
		                      <button type="button" class="btn itemAddRemove-btn dec `+customize_class+`" data-page="checkout" data-row="`+v.row_id+`" data-id="`+v.recipe_id+`" data-status="dec" data-obj='`+JSON.stringify(obj)+`'>
		                        <i class="icofont-minus"></i>
		                      </button>

		                      <input class="count-number-input qty`+v.recipe_id+` prod_qty btn itemCounts-btn qty_inp_box`+v.row_id+`" id="qty`+v.recipe_id+`" type="text" value="`+v.qty+`" readonly="">

		                      <button type="button" class="btn itemAddRemove-btn inc `+customize_class+`" data-page="checkout" data-row="`+v.row_id+`" data-id="`+v.recipe_id+`" data-status="add" data-obj='`+JSON.stringify(obj)+`'>
		                        <i class="icofont-plus"></i>
		                      </button>
		                   </div>
		                 </dv>  
		               </div>
				    </div>
				  </div>
				</div>
            </div>
          </div>`;	
	});
  }	
  
  $('#cart_div').html(str)
}
function render_cal(){
	
	$('.cart-item').text(get_cart_qty());
    $('.t-price').text(get_cart_totalamount());
}