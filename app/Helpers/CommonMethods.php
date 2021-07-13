<?php
namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use GuzzleHttp\Client;
use App\Helpers\CommonMethods;
use App\Http\Controllers\FoodCart;
use Illuminate\Support\Collection;

Class CommonMethods {

    private $RESTO_API_URL="";
    public function __construct()
    {
        $this->RESTO_API_URL=env("RESTO_API_URL");
        
    }
    public static function getCurl($url,$isPost=FALSE,$auth_data=NULL,$data=NULL)
    {
      
        $curl = curl_init();

        if($isPost!=FALSE){
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        else
        {
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'GET');
        }
        if($auth_data!=NULL && !empty($auth_data)){

            curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_data);
        }
        if($data!=NULL && !empty($data)){
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS,10);

        curl_setopt($curl, CURLOPT_TIMEOUT,0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        curl_setopt($curl,CURLOPT_ENCODING,'');
        
        $result = curl_exec($curl);

       
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            var_dump($error_msg);
        }
        curl_close($curl);

        $result=json_decode($result,true);    
        return $result;

    }

    public static function setToken($id)
    {
       $token=CommonMethods::getCurl(env("RESTO_API_URL").'restuarant/'.$id,false,NULL,NULL); 
       if(!isset($token['data']['access_token'])){
                
       }
       else
       {
          Session::put('tokenid', $token['data']['access_token']);
          return true;
       }
    }
    public static function setRestoSession($id)
    {
     
        if($id!='')
        {

           if(session()->has('resto_id') && Session::get('resto_id')!=$id)
           { 
             Session::put('resto_id', $id);
             session()->forget('tokenid');
             CommonMethods::setToken($id);
           }
           else
           {
             if(!session()->has('tokenid')){
              CommonMethods::setToken($id);
             }
           }

        }
         
        if(!session()->has('resto_id'))
        {
          Session::put('resto_id', $id);
          CommonMethods::setToken($id);
        }

        
    }
    public static function updateLanguage($lang=NULL)
    {

      $token=Session::get('tokenid');
      if(Session::has('lang') && $lang==NULL)
      {

        if(Session::get('lang')=='en'){

            Session::put('lang','ar');
        }
        else if(Session::get('lang')=='ar'){
            Session::put('lang','en');
        }
        else if($lang!=NULL){
            Session::put('lang',$lang);
        }
      }
      else if(Session::has('lang') && $lang!=NULL)
      {
         if($lang!=NULL){
            Session::put('lang',$lang);   
         }
         else{
            Session::put('lang','ar');
         }
      }
      else if(!Session::has('lang') && $lang!=NULL){
        Session::put('lang',$lang);   
      }
      else{
        Session::put('lang','ar');
      }
      $data=Session::get('lang');
      return $data;
    }
    public static function setLang($lang)
    {
      if(Session::has('lang') && Session::get('lang')!=$lang)
      {
        Session::put('lang','ar');     
      }
      Session::put('lang','ar');  
      $data=Session::get('lang');
      return $data;   
    }
    public static function getLang(){

     if(Session::has('lang'))
     {
        $data=Session::get('lang');
        return $data;     
     }
     else
     {
        $res=CommonMethods::updateLanguage();
        return $res;
     }   
     
    }
    public static function getCart(){
      $items = \Cart::getContent();
      return $items;
    }
    public static function showCartList()
    {
        $str='';
        $total=0;
        $token=Session::get('tokenid');
        if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$token]))
        {

         foreach ($_SESSION['recipe_list'][$token] as $k => $val)
         {

           $object=array('id'=>$val["id"],'name'=>$val["name"],'price'=>$val["price"],'tk'=>$val['tk']);
           $object=json_encode($object);
           $total=$total+$val['t_price'];
           $str.="<div class='gold-members p-2 border-bottom'>
             <p class='text-gray mb-0 float-right ml-2'>".$val['t_price']." ".env('CURRENCY')."</p>
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
      if($str!='')
      {
        $str.="<input type='hidden' class='cart_total_input' value='".$total."' name='cart_total_input' id='cart_total_input'/>";
      }
      //echo json_encode($data);
      return $str;
    }
    public static function getCartPrice()
    {
       $token=Session::get('tokenid');
       $total_price=0;

       if(isset($_SESSION['recipe_list'][$token]) && !empty($_SESSION['recipe_list'][$token]))
       {
         foreach ($_SESSION['recipe_list'][$token] as $key => $value) 
         {
           $cust_total=(int)CommonMethods::getCustomizationSession($value['id'],true);
           $total_price=$total_price+(float)$value['price']*(int)$value['qty']+$cust_total;
         }
       }
       $lang=CommonMethods::checkLang();
       $str=($lang=='ar')? number_format($total_price).' '.env('CURRENCY') : number_format($total_price).' '.env('CURRENCY');
       return $str;
    }
    public static function checkLang()
    {
       $token=(session()->has('tokenid')) ? Session::get('tokenid') : NULL;
      if(isset($_SESSION['lang'][$token]) && $token!=NULL)
       {
          if($_SESSION['lang'][$token]=='en')
          {
             $lang_txt='en';
             
          }
          if($_SESSION['lang'][$token]=='ar')
          {
             $lang_txt='ar';
          }
       }
       else
       {
          $_SESSION['lang'][$token]='ar';
          $lang_txt='ar';
       }
       return $lang_txt;
    }
    public static function getCartcount()
    {
      $token=Session::get('tokenid');
      
      $total_cart_count=0;
       if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$token]))
       {
         $total_cart_count=count($_SESSION['recipe_list'][$token]);
       }
       else
       {
         $total_cart_count=0;
       }
      return $total_cart_count;  
    }
    public static function removeAllitem(){
      $token=Session::get('tokenid');
      $result=\Cart::remove($token);
      return $result;
    }
    public static function changeLang()
    {
      $token=Session::get('tokenid');
      if(isset($_SESSION['lang'][$token]))
      {
         if($_SESSION['lang'][$token]=='ar')
         {
            $_SESSION['lang'][$token]='en';
            return $_SESSION['lang'][$token];
         }
         if($_SESSION['lang'][$token]=='en')
         {
            $_SESSION['lang'][$token]='ar';
            return $_SESSION['lang'][$token];
         }
         else
         {
            $_SESSION['lang'][$token]='en';
         }
         exit;
      }
      else
      {
        $_SESSION['lang'][$token]='en';
        return $_SESSION['lang'][$token];
        exit;
      }

  }
  public static function getOrderstatus($id){
     $order_arr=array();
     $order_no='';
     $order_status='';
     $token=Session::get('tokenid');
     $headers =array('Authorization: Bearer '.$token);
     $order_obj=CommonMethods::getCurl(env("RESTO_API_URL").'order/detail?order_id='.$id,false,$headers,NULL); 
     
     
     if($order_obj['type']=='success'){
        
        $order_arr=$order_obj['data'];
        $order_no=$order_arr['order'];
        $order_status=$order_arr['status'];

        if($order_status=="Placed")
            $order_status =__('label.placed');
        else if($order_status=="Send_to_Kitchen")  
              $order_status =__('label.send_to_kitchen');
        else if($order_status=="Served")
              $order_status =__('label.served');
        else if($order_status=="Rejected")
              $order_status =__('label.rejected');
        else if($order_status=="Cancelled_by_Customer")
              $order_status =__('label.cancelled_by_customer');
        else if($order_status=="Preparing_Order")  
              $order_status =__('label.preparing_order');
        $order_arr['ord_status']=$order_status;
           
     }
     else
     {
       $order_arr=NULL;
     }
     return $order_arr; 
  }
  public static function getWaiterOrders($waiter_resto_token){

     $new_resto_token=$waiter_resto_token;
   
     $headers =array('Authorization: Bearer '.$new_resto_token);

     $order_pending=CommonMethods::getCurl(env("RESTO_API_URL").'orders?type=Placed',false,$headers,NULL); 
     
     $order_served=CommonMethods::getCurl(env("RESTO_API_URL").'orders?type=Send_to_Kitchen',false,$headers,NULL); 

     $order_cancelled=CommonMethods::getCurl(env("RESTO_API_URL").'orders?type=Rejected',false,$headers,NULL);

     $list=CommonMethods::getCurl(env("RESTO_API_URL").'recipes',true,$headers,NULL); 
     
     $hlist=CommonMethods::item_list($list['data'],'new_items');
     
     $count_pending=0;
     $count_pending=count($order_pending['data']);

     $data['pending_list']=(isset($order_pending) && !empty($order_pending['data'])) ? $order_pending : NULL;
     $data['served_list']=(isset($order_served) && !empty($order_served['data']))?$order_served:NULL;
     $data['cancelled_list']=(isset($order_cancelled) && !empty($order_cancelled['data']))?$order_cancelled:NULL;
     $data['menu_list']=($hlist!='') ? $hlist :'';
     $data['pending_list_count']=$count_pending;
     return $data;
  }
  public static function item_list($data,$list_from=NULL)
  {

        $str='';
        foreach ($data as $value) 
        {
          $d_arr=array('id'=>$value['id'],'qty'=>0,'price'=>floatval(str_replace(",","",$value['price'])));
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
                        <h6 class="mb-1">'.$value["price"].' '.env("CURRENCY").'</h6>
                     </div>
                  </div>
               </div>';
        }
        return $str;
  }
  public static function orderDetails($mid=NULL)
  {

     $id=($mid!=NULL)? $mid : $_POST['id'];
     $order_id=$_POST['order_id'];
    /* $customer_name=$_POST['customer_name'];
     $waiter_name=$_POST['waiter_name'];
     $waiter_id=$_POST['waiter_id'];
     $order_date=$_POST['order_date'];
     $status=$_POST['status'];*/

     $token='';
     if(isset($_SESSION['waiter_resto_token']) && $_SESSION['waiter_resto_token']!='')
     {
        $token=$_SESSION['waiter_resto_token'];
     }

     $headers=array('Authorization: Bearer '.$token);
     $param=array('order_id'=>$id);
     $result=CommonMethods::getCurl(env("RESTO_API_URL").'order/detail?order_id='.$id,false,$headers,$param);
     
     $data=array();
     if(isset($result['type']) && !empty($result) && $result['type']=='success')
     {
        if($mid!=NULL)
        {
          return $result['data'];
        }
        $order_list_view=CommonMethods::order_list_view($result['data'],'upd_list',$id);
        $data['order_list']=$order_list_view['html'];
        $data['total_price']=$order_list_view['total'];
        //$data['total_price']=CommonMethods::getUPdateOrderDetail($id);
        
        return $data;
     }
  }
  public static function  getUPdateOrderDetail($order_id=NULL){

     $token='';
     if(isset($_SESSION['waiter_resto_token']) && $_SESSION['waiter_resto_token']!='')
     {
        $token=$_SESSION['waiter_resto_token'];
     }
     $param=array('order_id'=>$order_id);
     $headers=array('Authorization: Bearer '.$token);
     $order_id=($order_id==NULL)? $_POST['order_id'] : $order_id;
     $result=CommonMethods::getCurl(env("RESTO_API_URL").'order/detail?order_id='.$order_id,false,$headers,$param);
     $order_list_view=CommonMethods::order_list_view($result['data'],'upd_list',$order_id);
     $order_total_price=$order_list_view['total'];

     $update_qty=$_SESSION['updated_orders_list'][$order_id];
     $new_total_amount=0;
      if(isset($update_qty) && $update_qty!='')
      {
         foreach ($_SESSION['updated_orders_list'][$order_id] as $key => $value)
         {
           $new_total_amount=$new_total_amount+(float)$value['price']*$value['quantity'];
         }
         
      }
      $final_price=(float)$order_total_price+(float)$new_total_amount;
      return $new_total_amount;

  }
  public static function order_list_view($data,$status=NULL,$order_id=NULL)
  {
      $str='';
      $total_bill=0;
      foreach ($data['items'] as $value)
      {

        $d_arr=array('id'=>$value['recipe_id'],'qty'=>$value['quantity'],'order_id'=>$data['id'],'price'=>$value['price']);
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
        $total_bill=$total_bill+(float)$value['price']*$value['quantity'];
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
                      <ul class="list-inline">
                       <li class="list-inline-item" >'.env('CURRENCY').'</li>
                       <li class="list-inline-item" >'.$value["price"].' </li>
                      </ul>
                      
                      
                   </div>
                </div>
             </div>';
      }
      $data['html']=$str;
      $data['total']=$total_bill;
     return $data;
  }
  public static function updateOrdersItems($item_arr=NULL)
  {

     $order_id=(isset($item_arr) && $item_arr!=NULL)? $item_arr['order_id'] : $_POST['order_id'];
     $qty=(isset($item_arr) && $item_arr!=NULL)? $item_arr['qty'] : $_POST['qty'];
     $item=(isset($item_arr) && $item_arr!=NULL)? $item_arr['id'] : $_POST['id'];
     $price=(isset($item_arr) && $item_arr!=NULL)? $item_arr['price'] : $_POST['price'];
     
     
     if(isset($_SESSION['updated_orders_list'][$order_id]) && $_SESSION['updated_orders_list'][$order_id]!='' && isset($_SESSION['updated_orders_list'][$order_id][$item]) && $_SESSION['updated_orders_list'][$order_id][$item]==$item)
     {

        $_SESSION['updated_orders_list'][$order_id][$item]=array('item_id'=>$item,'quantity'=>$qty,'price'=>$price);
                  
     }
     else
     {
        $_SESSION['updated_orders_list'][$order_id][$item]=array('item_id'=>$item,'quantity'=>$qty,'price'=>$price);
     }
     $total=CommonMethods::getUPdateOrderDetail($order_id);
     return $total;
  }
  public static function addItems_order()
  {

     $list=$_POST['list'];
     $order_id=$_POST['order_id'];
      if(empty($list)){
          return json_encode(array('type'=>'error','message'=>'Empty List'));
          exit;
      }
      $total=0;
      foreach ($list as $key => $value)
      {
        $data['items'][$key]=array('item_id'=>$value['id'],'quantity'=>$value['Qty']);
        $data['order_id']=$value['order_id'];
        $arr=array('order_id'=>$value['order_id'],'qty'=>$value['Qty'],'id'=>$value['id'],'price'=>$value['price']);
        $res=CommonMethods::updateOrdersItems($arr);
        $total=$total+$res;
      }
      $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);
      $json_data=json_encode(array('data'=>$data));

      $json_data=rtrim($json_data,'null');
      $result=CommonMethods::getCurl(env("RESTO_API_URL").'update/order',true,$headers,$json_data);
      
      return $result;
  }
  public static function LatestList()
  {
      $order_id=$_POST['order_id'];

      $token=$_SESSION['waiter_resto_token'];

      $headers =array('Authorization: Bearer '.$token);
      $result=CommonMethods::getCurl(env("RESTO_API_URL").'order/detail?order_id='.$order_id,false,$headers,null);

      $list=CommonMethods::order_list_view($result['data'],'upd_list');
      return $list;

  }
  public static function orderUpdate()
  {
    
    $req=array('id'=>$_POST['id'],'status'=>$_POST['status'],'waiter_id'=>$_POST['wait']);
    $req=json_encode($req);
    $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);
    $result=array();
    if(isset($_SESSION['updated_orders_list'][$_POST['id']]) && $_SESSION['updated_orders_list'][$_POST['id']]!='')
    {
       $result=CommonMethods::updatelist_indb($_POST['id']);
       if($result['type']=='success')
       {
          unset($_SESSION['updated_orders_list'][$_POST['id']]);
          $result=CommonMethods::getCurl(env("RESTO_API_URL").'update/status/order',true,$headers,$req);
          return $result;
        }

    }
    else
    {
       
       $result=CommonMethods::getCurl(env("RESTO_API_URL").'update/status/order',true,$headers,$req);
       return $result;
    }
  }
  public static function updatelist_indb($id){

      $data=array();

      if(isset($_SESSION['updated_orders_list'][$id]) && $_SESSION['updated_orders_list'][$id]!='')
      {
         foreach ($_SESSION['updated_orders_list'][$id] as $key => $value)
         {
           $data['items'][]=array('item_id'=>$value['item_id'],'quantity'=>$value['quantity']);
         }
         $data['order_id']=$id;
         $headers =array('Authorization: Bearer '.$_SESSION['waiter_resto_token']);

         $json_data=json_encode(array('data'=>$data));
         $json_data=rtrim($json_data,'null');
         $result=CommonMethods::getCurl(env("RESTO_API_URL").'update/order',true,$headers,$json_data);
         return (array)$result;
      }
  }
  public static function latestOrder()
  {
     
     $new_resto_token=$_SESSION['waiter_resto_token'];
     $headers =array('Authorization: Bearer '.$new_resto_token);
     
     $ig_ids=json_decode($_POST['order_ids']);

     $order_pending=CommonMethods::getCurl(env("RESTO_API_URL").'orders?type=Placed',false,$headers,NULL);
     $order_pending=$order_pending;
     $order_pending=(array)$order_pending;

     $html=CommonMethods::orderlist_html($order_pending['data'],$ig_ids);
     return $html;
  }
  public static function orderlist_html($data,$ig_ids)
  {
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
  public static function logout()
  {
      unset($_SESSION['waiter_token']);
      return true;
  }
  public static function setcustomizationSession($request)
  {
      $checkbox=$request->input('chk_opt');
      $radio =$request->input('radio_opt');
      $chk_title=$request->input('chk_title');

      $checkbox=(isset($checkbox) && !empty($checkbox)) ? array_values($checkbox) : array();
      $radio =(isset($radio) && !empty($radio))? array_values($radio) : array();
      $chk_title=(isset($chk_title) && !empty($chk_title))? array_values($chk_title) : array();

      $recipe_id=$request->input('recipe_id');
      $recipie_price=$request->input('total_amount');
      $qty=$request->input('qty');

      $index=rand();

      $arr[$index]=array('recipe_id'=>$recipe_id,'recipie_price'=>$recipie_price,'qty'=>$qty,'checkbox'=>$checkbox,'radio'=>$radio,'checkbox_title'=>$chk_title);
      $result=CommonMethods::getCustomizationSession($recipe_id); 

      if(is_array($result) && !empty($result)){
        $result=CommonMethods::updateCustomizationSession($request); 
        return CommonMethods::sendResponse(NULL,'Updated Extra Option Sucessful','sucess');
      }
      
      $res=Session::push('customize_menu',$arr);
      return CommonMethods::sendResponse(NULL,'Added Extra Option Sucessful','sucess');
  }
  public static function updateCustomizationSession($request){
    /*if(iscustomizabel)
    {
      if(isRepeat)
      {

      }
      else
      {

      }
    }
    else
    {

    }*/
      $x=Session::get('customize_menu');
      $checkbox=$request->input('chk_opt');
      $radio =$request->input('radio_opt');
      $chk_title=$request->input('chk_title');

      $checkbox=(isset($checkbox) && !empty($checkbox)) ? array_values($checkbox) : array();
      $radio =(isset($radio) && !empty($radio))? array_values($radio) : array();
      $chk_title=(isset($chk_title) && !empty($chk_title))? array_values($chk_title) : array();

      $recipe_id=$request->input('recipe_id');
      $recipie_price=$request->input('total_amount');
      $qty=$request->input('qty');

      $total_amount=$request->input('total_amount');
      try 
      {
        if($request!=NULL)
        { 
          $str=array();
           $result=CommonMethods::getCustomizationSession(); 
           foreach ($result as $key => $value) 
           {
              if(isset($value[$recipe_id]))
              {
                
                Session::forget('customize_menu.'.$key);
              }
           }
           if($qty!='0')
           {
             $arr[$recipe_id]=array('recipe_id'=>$recipe_id,'recipie_price'=>$recipie_price,'qty'=>$qty,'checkbox'=>$checkbox,'radio'=>$radio,'checkbox_title'=>$chk_title);
             Session::put('customize_menu',$arr); 
           }
        }
        else
        {
          return false;
        }
      }
      catch (Exception $e) 
      {
        return $e->getMessage();
      }
  }
  public static function getCustomizationSession($recepie_id=NULL,$isTotal=false,$isSubitem=false)
  {
    $x=(Session::has('customize_menu'))?Session::get('customize_menu'):NULL;
    try 
    {
      if($recepie_id!=NULL && $x!=NULL)
      { 
          $total=0;
          $data=array();
          $subitems=array();
          
          $st=CommonMethods::searchx($x,'recipe_id', $recepie_id);
          
          foreach ($st as $key => $value) 
          {
            
              $value=$value;
              $new_val=$value;
              $data[$key]=$new_val;

              $total=$total+$data[$key]['recipie_price'];
              $subitems['checkbox']=$value['checkbox'];
              $subitems['checkbox_title']=$value['checkbox_title'];
              $subitems['radio']=$value['radio'];
            
          }
          
          if($isSubitem)
          {
            $arr=array();
            $arr1=array();
            $arr0=array();
            $arr2=array();
            if(isset($subitems['checkbox']) && !empty($subitems['checkbox']))
            {
               foreach ($subitems['checkbox'] as $key=> $value) 
               {
                 $arr0[][$value['extra_id']]=array('sub_item_id'=>$value['sub_item_id']);
               }    
            }
            if(isset($subitems['checkbox_title']) && !empty($subitems['checkbox_title']))
            {
               foreach ($subitems['checkbox_title'] as $key=> $value) 
               {
                 $arr1[]=array('id'=>$value['id']);
               }    
            }
            if(isset($subitems['radio']) && !empty($subitems['radio']))
            {
               foreach ($subitems['radio'] as $key=> $value) 
               {
                 $arr2[][$value['extra_id']]=array('sub_item_id'=>$value['sub_item_id']);
               }     
            }

            $xx=array_merge($arr0,$arr2);
            if($isSubitem=='title_chk'){
              return $arr1;
            }
            if($isSubitem=='all'){
              $xx=array_merge($xx,$arr1);
              return $xx;
            }
            
            $mm=array();
            if(!empty($xx)){
              for ($i=0; $i <count($xx) ; $i++) 
              { 
                foreach ($xx[$i] as $key => $value) 
                {
                  $mm[$key][]=$value;
                }
              }  
            }
            
            return $mm;
          }
          if($isTotal){
            return $total;
          }
          return $data;
      }
      else{
        return $x;
      }
    }
    catch (Exception $e) 
    {
      return $e->getMessage();
    }
    
      
  }
  public static function deleteCustomemenu($recepie_id)
  {
     $result=CommonMethods::getCustomizationSession(); 
     if(!empty($result))
     {
       foreach ($result as $key => $value) 
       {
          if(isset($value[$recepie_id]))
          {
            
            Session::forget('customize_menu.'.$key);
          }
       } 
     }
     

  }
  public static function getCustomemenuDesign($data){
    $res_arr=array();
    $optional_html='';
    $btn_html='';
    $str='';
    $sub_item_total=0;
    $head_total=0;

    foreach ($data['extra_options'] as $value) 
    {
      $isEmpty=(!empty($value['items']) && is_array($value['items'])) ? true : false;
      $head_checkbox='';
      $head_total=$head_total+$value['price'];
      if($isEmpty){
        //$head_checkbox='<h5 class="mb-4 mt-3 choose_item_qt" id="head_price_tag'.$value["id"].'" >'.$value["price"].' '.env("CURRENCY").'</h5>';
        $head_checkbox='<h5 class="mb-4 mt-3 choose_item_qt" id="head_price_tag'.$value["id"].'" > '.$value["price"].env("CURRENCY").'</h5>';
      }
      else{
        $res=CommonMethods::getCustomizationSession($data['id'],false,'title_chk');
        //$res=array_column($res,'id');
        //$chk_ischecked=(!empty(CommonMethods::searchx($res,'id',$value['id'])))? 'checked' : '';
        $price=($value["price"]==NULL || $value["price"]=='0')? 0 : $value["price"];
        $chk_ischecked='';
        $head_checkbox='<div class="d-flex justify-content-between mb-2 ">
                          <div class="mr-5 mt-2 flex-fill">
                           <small class="price_small">'.$value["price"].' '.env("CURRENCY").'</small>
                          </div>
                          <div class=" mt-2 flex-fill">
                            <label class="chk_container">
                              <input type="checkbox"  class="chk_title_option" '.$chk_ischecked.' name="chk_title_recepie_name[]" value="'.$value["price"].'" data-id="'.$value["id"].'" data-price="'.$price.'" data-title="'.$value["name"].'">
                              <span class="checkmark_box checkmark"></span>
                            </label>
                          </div>
                          
                      </div>';
      }
      $str.='<div class="row" style="background-color: #f3f3f3; border-bottom:solid 1px gray;">
               <div class="d-flex justify-content-between bd-highlight col-md-12">

                  <div class="p-1 bd-highlight">
                     <h5 class="mb-4 mt-3 head_text" >
                        <b>'.$value["name"].'</b> 
                     </h5>
                  </div>
                  <div class="p-1 bd-highlight">
                     '.$head_checkbox.'
                  </div>
               </div>
            </div>';
        if($isEmpty)
        {
          $str.='<div class="row mt-1">';
          $index=0;
          foreach ($value['items'] as $v) 
          {
            $sub_item_total=$sub_item_total+$v["price"];
            if($v['item_type']=='check-box')
            {
              $cprice=($v["price"]==NULL || $v["price"]=='0')? 0 : $v["price"];
              $ischecked='';
              /*$str.='<div class="col-md-12 d-flex justify-content-between  mb-0 p-1 m_list_div" tabindex="'.$index.'">
                        <p class="qty_txt'.$index.' ml-4" data-qty="0" style="display: none;">0</p>
                        <p class="pl-4 list_area_p" data-id="'.$index.'" >'.$v["name"].'</p>
                        <p class="pr-2 ">'.$v['price'].' '.env("CURRENCY").'</p>
                        <a class="close_anchor'.$index.'" style="display: none;">
                        <img src="'.env("APP_ASSETS").'img/Shape 6@2x.png" data-id="1" class="close_icon">  
                        </a>
                     </div>';*/
                     $res=CommonMethods::getCustomizationSession($data['id']);
                     $ischecked=(!empty($res) && isset($res['checkbox']) && !empty(CommonMethods::searchx($res['checkbox'],'sub_item_id',$v['id']))) ? 'checked' : '';
                      $str.='<div class="d-flex justify-content-between  mb-0 col-md-12 p-1 m_list_div" tabindex="'.$index.'">
                                <div class="col-8 mt-2">
                                  <p>'.$v["name"].'</p>
                                </div>
                                <div class="col mt-2 form-check form-switch">
                                  <label class="chk_container">
                                  <input type="checkbox" '.$ischecked.' class="chk_option" name="chk_recepie_name[]" value="'.$v["price"].'" data-extra-id="'.$value["id"].'" data-id="'.$v["id"].'" data-price="'.$cprice.'" data-title="'.$v["name"].'" data-parent-title="'.$value["name"].'">
                                    <small class="price_small">'.$v["price"].' '.env("CURRENCY").'</small>
                                    <span class="checkmark_box checkmark"></span>
                                  </label>
                                </div>
                            </div>';
            }
            elseif($v['item_type']=='option')
            {
              $ischecked='';
              $oprice=($v["price"]==NULL || $v["price"]=='0')? 0 : $v["price"];
              $res=CommonMethods::getCustomizationSession($data['id']);
              $ischecked=(!empty($res) && isset($res['radio']) && !empty(CommonMethods::searchx($res['radio'],'sub_item_id',$v['id']))) ? 'checked' : '';
              $str.='<div class="d-flex justify-content-between  mb-0 col-md-12 p-1 m_list_div" tabindex="'.$index.'">
                        <div class="col-8 mt-2">
                          <p>'.$v["name"].'</p>
                        </div>
                        <div class="col mt-2">
                          <label class="chk_container">
                                  <input type="radio" '.$ischecked.' class="radio_option" name="radio_recepie_name'.$value["id"].'[]" value="'.$v["price"].'" data-extra-id="'.$value["id"].'" data-id="'.$v["id"].'" data-price="'.$oprice.'" data-title="'.$v["name"].'" data-parent-title="'.$value["name"].'">
                                    <small class="price_small">'.$v["price"].' '.env("CURRENCY").'</small>
                            <span class="checkmark"></span>
                          </label>
                        </div>
                    </div>';
            }
            $index++;
          }
          $str.='
            
          </div>';
        }
    }
    return $str;
  }
  public static function searchx($array, $key, $value) 
    {
      $results = array();
        
      // if it is array
      if (is_array($array)) {
            
          // if array has required key and value
          // matched store result 
          if (isset($array[$key]) && $array[$key] == $value) {
              $results[] = $array;
          }
            
          // Iterate for each element in array
          foreach ($array as $subarray) {
                
              // recur through each element and append result 
              $results = array_merge($results, 
            CommonMethods::searchx($subarray, $key, $value));
          }
      }
    
      return $results;
    }
    public static function sendResponse($result, $message,$type)
    {
        $response = [
            'type' => $type,
            'data'    => $result,
            'message' => $message,
        ];


       // return response()->json($response);
        return json_encode($response);
    }
    public static function arr_to_string($key,$arr){
        $key.':'.json_encode($arr);
        return $key;
    }
    public static function arrtotext($data){

      $checkbox=(isset($data['chk_opt']) && !empty($data['chk_opt'])) ? array_values($data['chk_opt']) : array();
      $radio =(isset($data['radio_opt']) && !empty($data['radio_opt']))? array_values($data['radio_opt']) : array();
      $chk_title=(isset($data['chk_title']) && !empty($data['chk_title']))? array_values($data['chk_title']) : array();

      $arr_merge=array_merge($checkbox,$radio);
      $arr=array();
      foreach ($arr_merge as $key => $value) 
      {
         if(isset($value['parent_title'])){
           $arr[$value['parent_title']][]=$value['title']; 
         }
         else
         {
          //$arr[$value['parent_title']][]=$value['title']; 
         }
         
      }
      $tags='';
      if(!empty($arr))
      {
        foreach ($arr as $key => $value) 
        {
          $tags.=$key.':'.json_encode($value, JSON_UNESCAPED_UNICODE);
        } 
        $tags=str_replace(array('[',']','"'),'',$tags);
      }
      
      return $tags;
    }
    public static function getCustomHtml($recipe_id)
    {
      $data=FoodCart::getSession_id($recipe_id);
      $str='';
      foreach ($data as $key => $value) {
        $cdata[]=$value;
        
        $ord_txt=CommonMethods::getOrderText($value);
        
        $str.='<div class="row" id="cart_row_'.$value["row_id"].'">
                 <div class="col-8 product_content text-left">
                    <h4>'.$value["name"].'</h4>
                    <p>'.$ord_txt.'</p>
                 </div>
                 <div class="col-4">
                    <div class="food-item-price-wrap">
                       <div class="btn-group qty_span" id="qty_span" role="group" aria-label="Basic example">
                          <button type="button" class="btn decBtn dec upd_qty_btn" data-row="'.$value["row_id"].'" data-status="dec" data-id="'.$value["recipe_id"].'" data-obj="">
                            <i class="icofont-minus"></i>
                          </button>
                            <input class="count-number-input btn qty-input qty_inp_box " id="qty_upd_box'.$value["row_id"].'" type="text" value="'.$value["qty"].'" readonly="">
                            <button type="button" class="btn addBtn inc upd_qty_btn " data-row="'.$value["row_id"].'" data-status="add" data-id="'.$value["recipe_id"].'" data-obj="">
                            <i class="icofont-plus"></i>
                          </button>
                       </div>
                    </div>
                 </div>
               </div>';

      }
      return $str;
    }
    public static function getOrderText($data)
    {
      $mix_arr=array();
      $xdata=array();
      $tags='';
      foreach ($data as $key => $value) 
      {
        if(is_array($value) && !empty($value))
        {
          $mix_arr=array_merge($value['checkbox'],$value['radio']);
          foreach ($mix_arr as $k => $v) 
          {
            $xdata[$v['parent_title']][]=$v['title'];
          }
          foreach ($xdata as $key => $value) 
          {
            $tags.=$key.':'.json_encode($value, JSON_UNESCAPED_UNICODE);
          }
          $tags=str_replace(array('[',']','"'),'',$tags);
        }
      }
      return $tags;
    }
    
    public static function getOptionTotal($arr,$rec_price=NULL)
    {

      $total=0;
      
      foreach ($arr as $key => $value) {

        if(is_array($value)){
          foreach ($value as $k => $v) {
            $total=$total+(float)$v['price'];
          }
        }
      }
      return $total;
    }
    public static function getVisIpAddr() {
      
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    public static function getIpDetails(){
        $ip=CommonMethods::getVisIpAddr();

        $x= $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip),true);
        $lat=(isset($x['geoplugin_latitude']))?$x['geoplugin_latitude'] : '';
        $long=(isset($x['geoplugin_longitude']))?$x['geoplugin_longitude']:'';
        return  $x;
    }  
}
