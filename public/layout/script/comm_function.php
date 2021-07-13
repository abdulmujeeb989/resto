<?php
//include('../constant.php');
include dirname(__DIR__, 1).('/constant.php');
$GLOBALS['currency']=$currency;
$murl=$RESTO_API_URL;

if (session_id() =='') {
      session_start();
 }
 //$murl='https://meemapp.net/dmenu/admin/api/';
 //$mrul='https://dev.taiftec.com/dmenu/admin/api/';
 $resto_id=$_SESSION['restoid'];
$request;
if(isset($_POST['request']) && $_POST['request']!='')
 {
        $request=$_POST['request'];
 }
 else
 {
        return false;
 }
 if($request!='' && $request=='update_order'){
        $result=updateOrdersItems();
        echo json_encode($result);
        exit;
 }
 if($request!='' && $request=='order_newlist'){
  echo json_encode(latestOrder());
  exit;
 }
 if($request!='' && $request=='addItemsOrder'){
  $result=addItems_order();
  echo json_encode($result);
  exit;
 }
 if($request!='' && $request=='latestlist'){
  echo LatestList();
  exit;
 }
 if($request!='' && $request=='cart_html'){
        echo showCartList();
        exit;
 }
 if($request!='' && $request=='waiter_logout'){
  echo logout();
  exit;
 }
 if($request!='' && $request=='wait_login'){
        $uname=$_POST['uname'];
        $pwd=$_POST['pwd'];
  $field=array('username'=>$uname,'password'=>$pwd);
        $url=$GLOBALS['murl'].'login';
        
        $res=getCurl($url,true,null,$field);

        $res=json_decode($res,true);

        if(isset($res['data']['access_token'])){
    $_SESSION['wtk']=$res['data']['access_token'];
    $token=$res['data']['access_token'];
                $_SESSION['waiter_token']=$res['data']['access_token'];
                header("Location: ".SITEURL.'waiter_page');
        }
        else{
                unset($_SESSION['waiter_token']);
                echo "<script>window.history.go(-1);</script>";
        }

 }

 if($request!='' && $request=='changeLang'){
        $x=changeLang();
        echo json_encode($x);
 }
 if($request!='' && $request=='confirm_order'){
        $x=confirm_order();
        echo json_encode($x);
 }
 if($request!='' && $request=='getOrderdetails'){
        $x=orderDetails();
        echo json_encode($x);
 }
 if($request!='' && $request=='confirm_order_update'){
  $x=orderUpdate();
  echo json_encode($x);
 }
 if($request!='' && $request=='add_cart')
 {
        $id=$_POST['id'];
        $name=$_POST['name'];
        $price=(float)$_POST['price'];
        $qty=$_POST['qty'];
        $isEmpty=$_POST['isempty'];
  $token=$_SESSION['tokenid'];

        $resto_id=$GLOBALS['resto_id'];
        if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$resto_id]))
        {


                if(array_search($id, array_column($_SESSION['recipe_list'][$resto_id], 'id')) === FALSE && $qty!='0')
                {
                        $_SESSION['recipe_list'][$resto_id][]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price,'qty'=>$qty,'price'=>$price,'tk'=>$token);
                }
                else if(array_search($id, array_column($_SESSION['recipe_list'][$resto_id], 'id')) !== FALSE)
                {


                        foreach ($_SESSION['recipe_list'][$resto_id] as $key => $value)
                        {
                                if($value['id']==$id && $qty!='0')
                                {
                                  $_SESSION['recipe_list'][$resto_id][$key]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price,'qty'=>$qty,'price'=>$price,'tk'=>$token);
                                }
                                else if($value['id']==$id &&  $qty=='0')
                                {
                                  unset($_SESSION['recipe_list'][$resto_id][$key]);
                                }

                        }

                }
        }
        else
        {
                $_SESSION['recipe_list'][$resto_id][]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price,'qty'=>$qty,'price'=>$price,'tk'=>$token);
        }
        echo json_encode($_SESSION['recipe_list'][$resto_id]);

 }
 if($request!='' && $request=='cartqty')
 {
        $qty=getCartcount();
        echo $qty;
 }
 if($request!='' && $request=='cartprice')
 {
  $price=getCartPrice();
  echo $price;
 }
 function confirm_order(){
        $customer=$_POST['customer'];
        $table=$_POST['table'];
        $resto_id=$GLOBALS['resto_id'];
        if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$resto_id]))
        {
                $data=array();
                foreach ($_SESSION['recipe_list'][$resto_id] as $key => $value)
                {
                        $data['items'][$key]=array('recipe_id'=>$value['id'],'quantity'=>$value['qty']);


                }
                $data['table_number']=$table;
                $data['customer_name']=$customer;
                $data['customer_ip']=$_SERVER['REMOTE_ADDR'];

        }

        $headers =array('Authorization: Bearer '.$_SESSION['tokenid']);
        $url=$GLOBALS['murl'].'post/order';
        $json_data=json_encode(array('data'=>$data));

        $json_data=rtrim($json_data,'null');

        $result=getCurl($url,$isPost=true,$headers,$json_data);
        $result=json_decode($result,true);

        if(isset($result['type']) && $result['type']=='success'){
                unset($_SESSION['recipe_list'][$resto_id]);
                echo json_encode($result);

        }
        else{
                echo json_encode(array('type'=>'error','msg'=>'Failed'));
        }
        exit;
 }
 function orderDetails($mid=NULL){

         $id=($mid!=NULL)? $mid : $_POST['id'];
     $order_id=$_POST['order_id'];
     $customer_name=$_POST['customer_name'];
     $waiter_name=$_POST['waiter_name'];
     $waiter_id=$_POST['waiter_id'];
     $order_date=$_POST['order_date'];
     $status=$_POST['status'];

     $url=$GLOBALS['murl'].'order/detail?order_id='.$id;
     $token='';
     if(isset($_SESSION['waiter_resto_token']) && $_SESSION['waiter_resto_token']!=''){
        $token=$_SESSION['waiter_resto_token'];
     }

     $headers=array('Authorization: Bearer '.$token);
     $result=json_decode(getCurl($url,false,$headers,$json_data),true);
         // $list=json_decode(getCurl($GLOBALS['murl'].'recipes',true,$headers,NULL),true);
         // $list=item_list($list['data']);
         $data=array();
     if(isset($result['type']) && !empty($result) && $result['type']=='success')
     {
        if($mid!=NULL){
                return $result['data'];
        }
        $order_list_view=order_list_view($result['data'],'upd_list',$id);
        $data['order_list']=$order_list_view;
        //$data['list']=$list;
        return $data;
     }


}

 function showCartList()
 {
        $str='';
        $total=0;
        $resto_id=$GLOBALS['resto_id'];
        if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$resto_id]))
        {

       foreach ($_SESSION['recipe_list'][$resto_id] as $k => $val)
       {

         $object=array('id'=>$val["id"],'name'=>$val["name"],'price'=>$val["price"],'tk'=>$val['tk']);
         $object=json_encode($object);
         $total=$total+$val['t_price'];
         $str.="<div class='gold-members p-2 border-bottom'>
           <p class='text-gray mb-0 float-right ml-2'>".$val['t_price']." ".$GLOBALS['currency']."</p>
           <span class='count-number float-right qty_span'>
           <button class='btn btn-outline-secondary  btn-sm left dec update_qty' data-obj='".$object."' data-status='dec'> <i class='icofont-minus'></i> </button>

           <input class='count-number-input qty".$val['id']." prod_qty' type='text' id='qty".$val['id']."' value=".$val['qty']." readonly=''>

           <button class='btn btn-outline-secondary btn-sm right inc update_qty'  data-obj='".$object."' data-status='add'> <i class='icofont-plus'></i> </button>
           </span>
           <div class='media'>
              <div class='mr-2'><i class='icofont-ui-press text-danger food-item'></i></div>
              <div class='media-body'>
                 <p class='mt-1 mb-0 text-black'>".$val['name']."</p></p>
              </div>
           </div>

        </div>";
           }
    }
    if($str!=''){
    $str.="<input type='hidden' class='cart_total_input' value='".$total."' name='cart_total_input' id='cart_total_input'/>";
        }
    //echo json_encode($data);
    return $str;
 }
 function getCartcount()
 {
        $resto_id=$GLOBALS['resto_id'];
        return count($_SESSION['recipe_list'][$resto_id]);

 }
 function getCartPrice()
 {
   $resto_id=$GLOBALS['resto_id'];
   $total_price=0;
   if(isset($_SESSION['recipe_list'][$resto_id]) && !empty($_SESSION['recipe_list'][$resto_id])){
    foreach ($_SESSION['recipe_list'][$resto_id] as $key => $value) {
      $total_price=$total_price+(float)$value['price']*(int)$value['qty'];
    }
   }
   $lang=checkLang();
   $str=($lang=='ar')? number_format($total_price).' '.$GLOBALS['currency'] : number_format($total_price).' '.$GLOBALS['currency'];
   // $str.='<p class="">
   //              <span>'.number_format($total_price).'</span>
   //              <span>'.$GLOBALS['currency'].'</span>
   //            </p>';
   return $str;
 }
 function search($array, $key, $value)
 {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
 }
 function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}
function changeLang(){
        if(isset($_SESSION['lang']))
        {

                if($_SESSION['lang']=='ar')
                {
                        $_SESSION['lang']='eng';
                        return $_SESSION['lang'];
                }
                if($_SESSION['lang']=='eng')
                {
                        $_SESSION['lang']='ar';
                        return $_SESSION['lang'];
                }
                else{
                        $_SESSION['lang']='eng';
                }
                exit;
        }
        else
        {
                $_SESSION['lang']='eng';
                return $_SESSION['lang'];
                exit;
        }

}
function getCurl($url,$isPost=FALSE,$auth_data=NULL,$data=NULL){
$trnid = date('YmdHis').'-getCurl(): ';$dtmf = "Y-m-d H:i:s";$logstr = $trnid."URL : ".$url.', StartAt: '.date($dtmf).', EndAt: ';


        $curl = curl_init();

        if($isPost!=FALSE){
                curl_setopt($curl, CURLOPT_POST, 1);
        }
        if($auth_data!=NULL && !empty($auth_data)){

                curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_data);
        }
        if($data!=NULL && !empty($data)){
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_MAXREDIRS,10);
        curl_setopt($curl, CURLOPT_TIMEOUT,0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);


        $result = curl_exec($curl);
        if(!$result){
                echo 'Request Error:' . curl_error($curl);
        }
        curl_close($curl);
        $logstr = $logstr .date($dtmf);error_log($logstr);
        return $result;

}
function getCurl1($url,$auth=NULL,$ispost=GET){
        $curl = curl_init();
$trnid = date('YmdHis').'-getCurl(): ';$dtmf = "Y-m-d H:i:s";$logstr = $trnid."URL : ".$url.', StartAt: '.date($dtmf).', EndAt: ';

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $ispost,
          CURLOPT_HTTPHEADER => array($auth),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        $logstr = $logstr .date($dtmf);error_log($logstr);
        return $response;

}
function curl3($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

}

function getIPAddress() {
    //whether ip is from the share internet
     if(!emptyempty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    //whether ip is from the proxy
    elseif (!emptyempty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     }
//whether ip is from the remote address
    else{
             $ip = $_SERVER['REMOTE_ADDR'];
     }
     return $ip;
}
function order_list_view($data,$status=NULL,$order_id=NULL){

        $str='';
        foreach ($data['items'] as $value)
        {

        $d_arr=array('id'=>$value['recipe_id'],'qty'=>$value['quantity'],'order_id'=>$data['id']);
        $json_obj=json_encode($d_arr,true);


          if(isset($_SESSION['updated_orders_list'][$order_id]) && !empty($_SESSION['updated_orders_list'][$order_id]))
          {
             foreach ($_SESSION['updated_orders_list'][$order_id] as $k => $val)
             {
                if($value['recipe_id']==$val['item_id'])
                {
                   $value['quantity']=$val['quantity'];
                }
             }

          }
      $str.='<div class="gold-members p-3 border-bottom">
               <span class="count-number float-right">
              <a data-list="'.$status.'" class="btn btn-outline-secondary  btn-sm left dec qty_update" data-obj='.$json_obj.' data-status="dec"> <i class="icofont-minus"></i> </a>
              <input class="count-number-input qty_input" data-obj='.$json_obj.' id="qty_input'.$value['recipe_id'].'" type="text" value="'.$value["quantity"].'" readonly="">
              <a data-list="'.$status.'" class="btn btn-outline-secondary btn-sm right inc qty_update" data-status="add" data-obj='.$json_obj.'> <i class="icofont-plus"></i> </a>
              </span>
              <div class="media">
                 <div class="mr-3"><i class="icofont-ui-press text-danger food-item"></i></div>
                 <div class="media-body">
                    <h6 class="mb-1">'.$value["recipe_name"].'</h6>
                    <p class="text-gray mb-0">'.$value["price"].'</p>
                 </div>
              </div>
           </div>';
        }
        return $str;
}
function item_list($data,$list_from=NULL){
        $str='';

        foreach ($data as $value) {
    $d_arr=array('id'=>$value['id'],'qty'=>0);
    $json_obj=json_encode($d_arr,true);
      $str.='<div class="gold-members p-3 border-bottom">
              <span class="count-number float-right">
              <a data-list="'.$list_from.'"  class="btn btn-outline-secondary  btn-sm left dec qty_update" data-obj='.$json_obj.' data-status="dec"> <i class="icofont-minus"></i> </a>
              <input class="count-number-input" id="qty_input'.$value['id'].'" type="text" value="0" readonly="">
              <a data-list="'.$list_from.'"  class="btn btn-outline-secondary btn-sm right inc qty_update" data-status="add" data-obj='.$json_obj.'> <i class="icofont-plus"></i> </a>
              </span>
              <div class="media">
                 <div class="mr-3"><i class="icofont-ui-press text-danger food-item"></i></div>
                 <div class="media-body">
                    <h6 class="mb-1">'.$value["name"].'</h6>
                    <p class="text-gray mb-0">Price</p>
                 </div>
              </div>
           </div>';
        }
        return $str;
}
function orderUpdate()
{
  $url=$GLOBALS['murl'];
  $req=array('id'=>$_POST['id'],'status'=>$_POST['status'],'waiter_id'=>$_POST['wait']);
  $req=json_encode($req);
  $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);
  $url=$GLOBALS['murl'].'update/status/order';
  $result=array();
  if(isset($_SESSION['updated_orders_list'][$_POST['id']]) && $_SESSION['updated_orders_list'][$_POST['id']]!='')
  {
        $result=updatelist_indb($_POST['id']);

        if($result['type']=='success')
        {
          unset($_SESSION['updated_orders_list'][$_POST['id']]);
          $result=getCurl($url,true,$headers,$req);
     return json_decode($result);
        }

  }
  else{
        $result=getCurl($url,true,$headers,$req);
     return json_decode($result);
  }




}
function updatelist_indb($id){

        $data=array();

        if(isset($_SESSION['updated_orders_list'][$id]) && $_SESSION['updated_orders_list'][$id]!=''){
                foreach ($_SESSION['updated_orders_list'][$id] as $key => $value)
                {
                        $data['items'][]=array('item_id'=>$value['item_id'],'quantity'=>$value['quantity']);
                }
                $data['order_id']=$id;

                $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);

            $url=$GLOBALS['murl'].'update/order';
            $json_data=json_encode(array('data'=>$data));

            $json_data=rtrim($json_data,'null');
            $result=json_decode(getCurl($url,true,$headers,$json_data));
            return (array)$result;
        }
}
function updOrder(){
  $list=$_POST['list'];
  $orderid=$_POST['orderid'];
   $data=array();
   foreach ($list as $key => $value)
   {
     $data['items'][$key]=array('item_id'=>$value['id'],'quantity'=>$value['qty']);
   }
   $data['order_id']=$orderid;

}
function checkLang(){
  if(isset($_SESSION['lang']))
   {
      if($_SESSION['lang']=='eng'){
         $lang_txt='eng';
      }
      if($_SESSION['lang']=='ar'){
         $lang_txt='ar';

      }
   }
   else
   {
      $_SESSION['lang']=='ar';
      $lang_txt='ar';
   }
   return $lang_txt;
}
function logout(){
    unset($_SESSION['waiter_token']);
    header("Location: ".SITEURL.'waiter');
 }
 function addItems_order()
 {
   $list=$_POST['list'];
   $order_id=$_POST['order_id'];
    if(empty($list)){
        return json_encode(array('type'=>'error','message'=>'Empty List'));
        exit;
    }
    foreach ($list as $key => $value)
    {
      $data['items'][$key]=array('item_id'=>$value['id'],'quantity'=>$value['Qty']);
      $data['order_id']=$value['order_id'];
    }
    $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);

    $url=$GLOBALS['murl'].'update/order';
    $json_data=json_encode(array('data'=>$data));

    $json_data=rtrim($json_data,'null');
    $result=getCurl($url,true,$headers,$json_data);

    $result=json_decode($result,true);
    return $result;

 }
 function LatestList()
 {
    $order_id=$_POST['order_id'];

    $token=$_SESSION['waiter_resto_token'];

    $url=$GLOBALS['murl'].'order/detail?order_id='.$order_id;

    $headers ='Authorization: Bearer '.$token;
    $result=getCurl($url,false,array($headers),null);

    $result=json_decode($result,true);
    $list=order_list_view($result['data'],'upd_list');
    return $list;

 }
function updateOrdersItems(){

        $order_id=$_POST['order_id'];

        $qty=$_POST['qty'];
        $item=$_POST['id'];
        if(isset($_SESSION['updated_orders_list'][$order_id]) && $_SESSION['updated_orders_list'][$order_id]!='' && $_SESSION['updated_orders_list'][$order_id][$item]==$item)
        {
                $_SESSION['updated_orders_list'][$order_id][$item]=array('item_id'=>$item,'quantity'=>$qty);
                if($qty=='0'){
                        //unsert($_SESSION['updated_orders_list'][$order_id][$item]);
                }
                else{

                }

                /*if(in_array($item,$_SESSION['updated_orders_list'][$order_id])){
                        $_SESSION['updated_orders_list'][$order_id][$item]=array('item_id'=>$item,'quantity'=>$qty);
                }*/
        }
        else
        {
                $_SESSION['updated_orders_list'][$order_id][$item]=array('item_id'=>$item,'quantity'=>$qty);
        }
        return $_SESSION['updated_orders_list'][$order_id];
}
 function latestOrder()
 {
   $url=$GLOBALS['murl'];
   $new_resto_token=$_SESSION['waiter_resto_token'];
   $header='Authorization: Bearer '.$new_resto_token;
   $ig_ids=json_decode($_POST['order_ids']);

   $order_pending=getCurl($url.'orders?type=Placed',false,array($header),null);
   $order_pending=json_decode($order_pending);
   $order_pending=(array)$order_pending;

   $html=orderlist_html($order_pending['data'],$ig_ids);
   return $html;
 }
 function orderlist_html($data,$ig_ids){
  $data=json_decode(json_encode($data), true);

   $str='';
   $ids=array();
   $i=0;
   foreach ($data as $key => $value) {
         $ids[]=$value['id'];
          $i++;
     if(in_array($value['id'], $ig_ids))
     {
       continue;
     }
     $str.='<div class="col-md-6">
             <div class="bg-white card addresses-item mb-4 border border-primary shadow">
                <div class="gold-members p-4">
                   <div class="media">
                      <div class="mr-3"><i class="icofont-ui-user icofont-3x"></i></div>
                      <div class="media-body">
                         <h6 class="mb-1 text-secondary">'.$value["customer_name"].'</h6>
                         <p class="text-black">Order No. : '.$value["order_id"].'</p>
                         <p class="text-black">Table No. : '.$value["table_no"].'</p>
                         <p class="text-black">Order Date: '.$value["order_date"].'</p>
                         <p class="text-black">Status : '.$value["status"].'</p>
                         <p class="mb-0 text-black font-weight-bold">
                            <a class="text-primary mr-3 view_order" data-obj="'.json_encode($value,true).'">
                               <i class="icofont-page"></i> View</a>
                         </p>
                      </div>
                   </div>
                </div>
             </div>
          </div>';

   }
   $data['html']=$str;
   $data['ids']=json_encode($ids);
   $data['total']=$i;
   return $data;
 }
?>

