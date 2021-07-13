
$(document).on('click', '.chk_update_qty', function(){
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
      $('#chk_maindiv_'+obj.id).remove();
      removeBorderline();
  }	
  
  obj.recipe_price=obj.price;
  obj.is_customized=obj.is_customized;
  obj.price=obj.price;
  obj.isRepeat='false';
  
  obj.url='/add_cart';
   
  addCart(obj)
 
  
})
function removeBorderline(){
  var count=$('.cart-items-wrap').length
  if(count==1 && count!=0){
    $('.cart-items-wrap').css('border-bottom','0px solid #dbdbdb');
  }
}