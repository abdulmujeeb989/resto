
@include('include.footer_link')
<script type="text/javascript">
  var cart_count=0;
  
   
  setTimeout(function() 
  {
    
   /* $(".t-price").text(getTPrice());
   $("span.cart-item").text(cartcount())*/

   $('.cart-item').text(get_cart_qty());
    $('.t-price').text(get_cart_totalamount());
    
  }, 400);
 
</script>