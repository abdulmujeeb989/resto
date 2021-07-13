  @include('include.waiter_header')
  @php
    $list='';
    
    $count_pending=0;
    if(isset($resto_list)):
      $list=$resto_list['menu_list'];
      $count_pending=$resto_list['pending_list_count'];
      $order_pending=$resto_list['pending_list'];
      $order_served=$resto_list['served_list'];
      $order_cancelled=$resto_list['cancelled_list'];
     
    endif;
  @endphp
   <script type="text/javascript">
     function getList()
     {
       return `<?php echo $list;?>`;
     }
     var base_url="{{url('/')}}";
     var rid='<?php echo $resto_id;?>';
   </script>   
<style type="text/css">
	.count-number-input{
		height: 18.4px;
	}
	.list_itm{
		max-height: 48vh;
    	overflow: scroll !important;
	}
	.modal-body {
		margin-bottom:-40px; 
	}
	.btn-outline-secondary:hover {
	    color: #fff;
	    background-color:transparent;
	    border-color: #6c757d;
	}
  .badge_noti {
        font-size: 0.7em;
        display: block;
        position: absolute;
        top: 1.25em;
        right: 0.70em;
        width: 2em;
        height: 2em;
        line-height: 2em;
        border-radius: 50%;
        color: #fff;
        background: red;
        text-align: center;
}
</style>

      <section class="section pt-4 pb-4 osahan-account-page">
         <div class="container">
            <div class="row">
               <div class="col-md-3">

                  <div class="osahan-account-page-left shadow-sm bg-white h-100">
                    

                     <ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4" id="myTab" role="tablist">
                       
                        <li class="nav-item">
                           <a class="nav-link active" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="false"><i class="icofont-location-pin"></i> Pending Orders</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="addresses-tab1" data-toggle="tab" href="#addresses1" role="tab" aria-controls="addresses1" aria-selected="false"><i class="icofont-location-pin"></i> Send to Kitchen</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="addresses-tab2" data-toggle="tab" href="#addresses2" role="tab" aria-controls="addresses2" aria-selected="false"><i class="icofont-location-pin"></i> Cancelled Orders</a>
                        </li>
                        <li class="nav-item">
                          <a href='#' class="nav-link logout_waiter" id="addresses-tab2" data-toggle="tab" role="tab" aria-controls="addresses2" aria-selected="false"><i class="icofont-logout"></i>Logout</a>
                        </li>
                        <li class="nav-item">
                          <a href='#' class="nav-link" id="addresses-tab2" data-toggle="tab" role="tab" aria-controls="addresses2" aria-selected="false">
                            <i class="icofont-restaurant"></i>Total Pending Orders <span  class="badge badge-dark"><?php echo $count_pending;?></span>
                          </a>
                        </li>
                     </ul>

                     <div class="navbar-collapse collapse show" id="navbarNavDropdown">
                        <ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4 ml-auto" id="myTab" role="tablist">
                        
                            <li class="nav-item dropdown dropdown-notifications">
                                <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-count="0" class="icofont-restaurant notification-icon" ></i><span id="pending_count" class="badge_noti notif-count">0</span>
                                    New Orders
                                </a>

                                <div class="dropdown-container dropdown-menu-right shadow-sm border-0">
                                    <div class="dropdown-toolbar">
                                        <div class="dropdown-toolbar-actions">
                                            <a href="#"></a>

                                        </div>
                                    </div>
                                    <ul class="dropdown-menu notification_ul">
                                    </ul>
                                    
                                </a>
                                </div>
                                
                            </li>
                            
                        </ul>
                     </div>
                    

                     

                  </div>
               </div>
               <div class="col-md-9">
                  <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                     <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                           <h4 class="font-weight-bold mt-0 mb-4">Pending Orders</h4>
                           <div class="row" id="latest_list"></div>
                           <div class="row" id="pend_order_div_row">
                        <?php
                          
                           $order_ids=array();

                           if(isset($order_pending['data']) && !empty($order_pending['data'])):
                                $resto_data=$order_pending['data'];
                              foreach ($resto_data as $key => $value) :
                              	$order_ids['pending'][]=$value['id'];
                                
                            ?>
                                <div class="col-md-6">
                                   <div class="bg-white card addresses-item mb-4 border border-primary shadow">
                                      <div class="gold-members p-4">
                                         <div class="media">
                                            <div class="mr-3"><i class="icofont-ui-user icofont-3x"></i></div>
                                            <div class="media-body">
                                               <h6 class="mb-1 text-secondary"><?php echo $value['customer_name'];?></h6>
                                               <p class="text-black">Order No. : <?php echo $value['order_id'];?></p>
                                               <p class="text-black">Table No. : <?php echo $value['table_no'];?></p>
                                               <p class="text-black">Order Date: <?php echo $value['order_date'];?></p>
                                               <p class="text-black">Status : <?php echo $value['status'];?></p>
                                               <p class="mb-0 text-black font-weight-bold">
                                                  <a class="text-primary mr-3 view_order" data-obj='<?php echo json_encode($value,true);?>'>
                                                     <i class="icofont-page"></i> View</a> 
                                                     <!-- <a class="text-danger" data-toggle="modal" data-target="#delete-address-modal" href="#">
                                                        <i class="icofont-ui-delete"></i> DELETE</a> -->
                                                     </p>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                              <?php
                                 endforeach;
                                endif;
                                
                              ?>
                              <input type="hidden" value="<?php echo json_encode($order_ids['pending'],true);?>" name="pending_ids" id="pending_ids" >
                           </div>
                        </div>

                        <div class="tab-pane fade " id="addresses1" role="tabpanel" aria-labelledby="addresses-tab1">
                           <h4 class="font-weight-bold mt-0 mb-4">Served Orders</h4>
                           <div class="row">
                        <?php
                           
                           if(isset($order_served['data']) && !empty($order_served['data'])):
                                $resto_data=$order_served['data'];
                              foreach ($resto_data as $key => $value) :
                              	$order_ids['served'][]=$value['id'];
                            ?>
                              <div class="col-md-6">
                                 <div class="bg-white card addresses-item mb-4 border border-primary shadow">
                                    <div class="gold-members p-4">
                                       <div class="media">
                                          <div class="mr-3"><i class="icofont-ui-user icofont-3x"></i></div>
                                          <div class="media-body">
                                             <h6 class="mb-1 text-secondary"><?php echo $value['customer_name'];?></h6>
                                             <!-- <p class="text-black"><?php echo $value['waiter_name'];?></p> -->
                                             <p class="text-black">Order No. : <?php echo $value['order_id'];?></p>
                                             <p class="text-black">Order Date: <?php echo $value['order_date'];?></p>
                                             <p class="text-black">Status : <?php echo $value['status'];?></p>
                                             <p class="mb-0 text-black font-weight-bold">
                                                <!-- <a class="text-primary mr-3 view_order" data-obj='<?php echo json_encode($value,true);?>'>
                                                   <i class="icofont-ui-edit"></i> EDIT</a>  -->
                                                   <!-- <a class="text-danger" data-toggle="modal" data-target="#delete-address-modal" href="#">
                                                      <i class="icofont-ui-delete"></i> DELETE</a> -->
                                                   </p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php
                                 endforeach;
                                endif;
							  ?>
                           </div>
                        </div>

                        <div class="tab-pane fade " id="addresses2" role="tabpanel" aria-labelledby="addresses-tab1">
                           <h4 class="font-weight-bold mt-0 mb-4">Reject Orders</h4>
                           <div class="row">
                        <?php
                          
                           
                           if(isset($order_cancelled['data']) && !empty($order_cancelled['data'])):
                                $resto_data=$order_cancelled['data'];
                              foreach ($resto_data as $key => $value) :
                                $order_ids['cancelled'][]=$value['id'];
                            ?>
                              <div class="col-md-6">
                                 <div class="bg-white card addresses-item mb-4 border border-primary shadow">
                                    <div class="gold-members p-4">
                                       <div class="media">
                                          <div class="mr-3"><i class="icofont-ui-user icofont-3x"></i></div>
                                          <div class="media-body">
                                             <h6 class="mb-1 text-secondary"><?php echo $value['customer_name'];?></h6>
                                             <!-- <p class="text-black"><?php echo $value['waiter_name'];?></p> -->
                                             <p class="text-black">Order No. : <?php echo $value['order_id'];?></p>
                                             <p class="text-black">Order Date: <?php echo $value['order_date'];?></p>
                                             <p class="text-black">Status : <?php echo $value['status'];?></p>
                                             <p class="mb-0 text-black font-weight-bold">
                                                <!-- <a class="text-primary mr-3 view_order" data-obj='<?php echo json_encode($value,true);?>'>
                                                   <i class="icofont-ui-edit"></i> EDIT</a>  -->
                                                   <!-- <a class="text-danger" data-toggle="modal" data-target="#delete-address-modal" href="#">
                                                      <i class="icofont-ui-delete"></i> DELETE</a> -->
                                                   </p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php
                                 endforeach;
                                endif;
                              ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Modal -->
      <div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="add-address">Order Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form id="order_frm">
                  	<input type="hidden" name="order_id" id="order_id" value="">
                     <div class="form-row">
                        <div class=" w-100">
                    	<ul class="nav" id="pills-tab" role="tablist">
		                     <li class="nav-item">
		                        <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill" href="#pills-order-online" role="tab" aria-controls="pills-order-online" aria-selected="false">Order List</a>
		                     </li>
		                     <li class="nav-item">
		                        <a class="nav-link " id="pills-restaurant-info-tab" data-toggle="pill" href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info" aria-selected="true">Menu List</a>
		                     </li>
		                    
		                  </ul>
		                  <div class="tab-content" id="pills-tabContent">
          							<div class="tab-pane fade show active " id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                           <!-- <h4 id="tprice" class=""></h4> -->
          							   <div id="#menu" class="bg-white rounded shadow-sm p-4 mb-4 explore-outlets order_list_view ">
                             
                           </div>
          							  <div class="form-group mb-0 col-md-12">
                                     
                                 <div class="row mb-1" style="display:none;" id="reason_box">
                                      <div class="col-md-12">
                                        <textarea id="reaseon_input"  class="form-control" placeholder="Enter Reasone"></textarea>
                                      </div>
                                  </div>
                                 <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                                    <!-- <label class="btn btn-info options" data-action="edit">
                                    <input type="radio" name="options" id="option2" value="edit" autocomplete="off"> Edit
                                    </label> -->

                                    <label class=" order_btn_confirm btn btn-success options" id="confirm_btn" data-wait="<?php echo $waiter['id'];?>" data-obj='' data-action="confirm">
                                      <input type="radio" name="options" id="option1" value="confirm" autocomplete="off" > Confirm Order
                                    </label>
                                    
                                    <label class=" order_btn_reject btn btn-danger options active" id="reject_btn" data-wait="<?php echo $waiter['id'];?>" data-obj='' data-action="reject">
                                      <input type="radio" name="options" id="option3" value="reject" autocomplete="off" >Reject
                                    </label>
                                 </div>
                            </div>
          							 </div>  
							  
            							<div class="tab-pane fade  overflow-auto" id="pills-restaurant-info" role="tabpanel" aria-labelledby="pills-gallery-tab">
            								<div class="list_itm">
            									
            								</div>
            							  	<div class="btn-group btn-group-toggle d-flex justify-content-center mt-5" data-toggle="buttons">
            							  		<button class="btn btn-success add_order">Add to Order List</button>
            							  	</div>
            							</div>
						            </div>
                      </div>

                        
                     </div>
                  </form>

               </div>
               <div class="modal-footer border-0">
                  <button type="button" class="btn d-flex w-100 text-center justify-content-center btn-outline-primary" data-dismiss="modal">Close
                  <!-- </button><button type="button" class="btn d-flex w-50 text-center justify-content-center btn-primary">SUBMIT</button> -->
               </div>
            </div>
         </div>
      </div>
      <audio autoplay loop muted playsinline id="myAudio" src="{!! env('APP_ASSETS') !!}media/notification.mp3" type="audio/mpeg"></audio>
      @include('include.waiter_footer')  
      
      <script type="text/javascript">

        $('.osahan-menu-fotter').hide();
         
         //$("#myAudio")[0].play();
         //var igorder_id='<?php echo json_encode($order_ids
         ["pending"],true);?>'; 
         setInterval(function()
         { 
           var igorder_id=$('#pending_ids').val();
            //getorder_List(igorder_id)
         }, 5000);

         var notificationsWrapper   = $('.dropdown-notifications');
          var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
          var notificationsCountElem = notificationsToggle.find('i[data-count]');
          var notificationsCount     = parseInt(notificationsCountElem.data('count'));
          var notifications          = notificationsWrapper.find('ul.dropdown-menu');

          if (notificationsCount <= 0) {
              //notificationsWrapper.hide();
              $('.dropdown-container').hide();
          }

         var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
            cluster: '{{env("PUSHER_APP_CLUSTER")}}',
            encrypted: true
        });
         var channel = pusher.subscribe('deraya');
         channel.bind('App\\Events\\Notify', function(data) 
         {  

            $('.dropdown-container').show();
            var wid="<?php echo $waiter['id'];?>";
            var array = $.map(data.waiter_data, function(value, index) {
                return [value];
            });

            var result=$.grep( array, function( n, i ) {
              return n == wid;
            });
            
            if(result && result.length!=0){
              var ord_html=getOrderhtml(data.order_id);
              var existingNotifications = notifications.html();
              var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
              var resJsonstr = JSON.stringify(data);
              var newNotificationHtml = `
                <li class="nav-item">
                    <a class="dropdown-item view_order" data-obj='`+resJsonstr+`'>`+data.message+`</a>
                </li>
              `;
              notifications.html(newNotificationHtml + existingNotifications);

              notificationsCount += 1;
              notificationsCountElem.attr('data-count', notificationsCount);
              notificationsWrapper.find('.notif-count').text(notificationsCount);
              notificationsWrapper.show();
            }
            
            
         });
         function getOrderhtml(order_id){
            $.ajax({
                url: "{{url('getOrderhtml')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
                type: "post",
                data: {'order_id':order_id} ,
                success: function (data) 
                {
                  $('#pend_order_div_row').prepend(data)
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                   console.log(textStatus, errorThrown);
                }
            });

         }
      </script>
   </body>
   </body>
</html>