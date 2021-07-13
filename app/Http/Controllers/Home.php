<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use GuzzleHttp\Client;
use App\Helpers\CommonMethods;
use Redirect;
use Log;

use Pusher\Pusher;
use App\Http\Controllers\FoodCart;
use Illuminate\Http\Client\Response;
class Home extends Controller
{
	  private $RESTO_API_URL="";	
	  public function __construct()
    {
        $this->RESTO_API_URL=env("RESTO_API_URL");
        
    }
    public function error(){
       $lang_detail=CommonMethods::updateLanguage();

     $data['lang_detail']=$lang_detail;
     $data['msg']='abc';
      return response()->view('error.custome_error', $data, 404);
    }
    public function cmenu()
    {

       $token=Session::get('tokenid'); 
       $headers =array('Authorization: Bearer '.$token);
       $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);
       if($resto['type']=='error'){
          $data['msg']=$resto['message'];
          return response()->view('error.custome_error', $data, 404);
       }
       $hotel_info_arr=$resto['data'];
       $data['hotel_info_arr']=$hotel_info_arr;

       $lang_detail=CommonMethods::updateLanguage();
       $data['lang_detail']=$lang_detail;

      return response()->view('pages.custom_menu',$data);
    }
    public function resto_order()
    {


       $token=Session::get('tokenid'); 
       $headers =array('Authorization: Bearer '.$token);
       $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);
       if($resto['type']=='error'){
          $data['msg']=$resto['message'];
          return response()->view('error.custome_error', $data, 404);
       }
       
       $hotel_info_arr=$resto['data'];
       $data['hotel_info_arr']=$hotel_info_arr;

       $lang_detail=CommonMethods::updateLanguage();
       $data['lang_detail']=$lang_detail;
       

      return response()->view('pages.resto_menu',$data);
    }
    public function resto_location()
    {

        $token=Session::get('tokenid'); 
        $headers =array('Authorization: Bearer '.$token);
        $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);
        if($resto['type']=='error'){
          $data['msg']=$resto['message'];
          return response()->view('error.custome_error', $data, 404);
        }
       
        $hotel_info_arr=$resto['data'];
        $data['hotel_info_arr']=$hotel_info_arr;

        $lang_detail=CommonMethods::updateLanguage();
        $data['lang_detail']=$lang_detail;
        return response()->view('pages.resto_location',$data);
    }
    public function index(Request $request){
        
        $dipndip='3abc00f2-b205-4fd4-a4d4-cb799cabc441';
       


        /*echo '<pre>';   
        print_r($x);
        exit;*/

        $recipe_name=env('APP_ASSETS').'/recipe_names.json';
        $recipe_raw=file_get_contents($recipe_name);
        $recipe_data=@json_decode(file_get_contents($recipe_name),true);

        /*echo '<pre>';
        print_r($recipe_data);
        exit;*/
        $cat_name=env('APP_ASSETS').'/categories.json';
        $cat_raw=file_get_contents($cat_name);
        $cat_data=@json_decode(file_get_contents($cat_name),true);
        
       //Session::flush();
       //Session::put('resto_id', $id);
       //$request->session()->forget('resto_id');
       //echo Session::get('resto_id');

      $headers = \Request::header();
      $headers['client_ip']=array($request->ip());
      $headers['server_ip']=array($_SERVER['SERVER_ADDR']);
     // Log::info($headers);
      

     

     
     
     if(isset($_GET['id']) && $_GET['id']!=''){
         $id=$_GET['id'];   
     }
     else
     {
        $data['msg']='URL is not proper please rescan';
        return response()->view('error.custome_error', $data, 404);
     }    


     
     if(!Session::has('lang') && $id!=$dipndip)
     {
        
        $lang_detail=CommonMethods::updateLanguage(); 
     } 
     else if(!Session::has('lang') && $id==$dipndip)
     {
        
        $lang_detail=CommonMethods::updateLanguage('kr'); 

     }
     else{
        
        $lang_detail=CommonMethods::getLang(); 
     }
      
     $data['lang_detail']=$lang_detail;

     $changeResto='false';
     if($id!=Session::get('resto_id') && Session::has('resto_id')){
        $changeResto='true';
     }   
     $res=CommonMethods::setRestoSession($id);
     $token=Session::get('tokenid');
     
     $headers =array('Authorization: Bearer '.$token);
	 $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);
     if($resto['type']=='error')
     {
        $data['msg']=$resto['message'];
        return response()->view('error.custome_error', $data, 404);
     }
     
		 $menu=CommonMethods::getCurl($this->RESTO_API_URL.'categories',true,$headers,NULL);
         
         /*$menu=Http::withToken($token)->post($this->RESTO_API_URL.'categories');
         $menu=$menu->json();*/
         

     
         //$waiter_data=CommonMethods::getCurl($this->RESTO_API_URL.'resto/waiter',false,$headers,NULL);
         //$recepie=CommonMethods::getCurl($this->RESTO_API_URL.'recipes',true,$headers,NULL);
         //$hotel_data_arr=$recepie['data']; 

		 $cat_data_arr=$menu['data'];

		 $hotel_info_arr=$resto['data'];
  	     $rest_uid=$hotel_info_arr['shared_unique_id'];
		 
		 $data['resto_id']=$id;
		 $data['hotel_info_arr']=$hotel_info_arr;
		 $data['cat_data_arr']=$cat_data_arr;

         $result=CommonMethods::getCartPrice();
         $data['total_cart_count']=CommonMethods::getCartcount();
         $data['total_price']=$result;
         
         $data['ischangeResto']=$changeResto;
		
         $data['recipe_name']=($id==$dipndip)?$recipe_raw:''; 
         $data['cat_name']=($id==$dipndip)?$cat_raw:''; 


         
         App::setLocale($lang_detail);
         $locale = app()->getLocale();
         //echo $locale; exit;
		 return view('index', $data);
    }
    public  function checkoutpage(Request $request){
         $token=Session::get('tokenid');
         $resto_id=Session::get('resto_id');
         $headers =array('Authorization: Bearer '.$token);
         
          if(!Session::has('lang'))
          {
            $lang_detail=CommonMethods::updateLanguage(); 
          } 
          else
          {
            $lang_detail=CommonMethods::getLang(); 
          }

          App::setLocale($lang_detail);
          $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);

          if(!isset($resto['data']) && empty($resto['data']))
          {
            echo '<script>alert("Session is Expired. Please Try Again")</script>';
            return redirect('/?id='.$resto_id);   
          }
          $hotel_info_arr=$resto['data'];
          $data['hotel_info_arr']=$hotel_info_arr;

          $data['lang_detail']=$lang_detail;

          $recipe_name=env('APP_ASSETS').'/recipe_names.json';
          $recipe_raw=file_get_contents($recipe_name);
          

        /* if(empty(FoodCart::getSession()))
         {
            echo '<script>alert("No Recipes in Cart")</script>';
            return redirect('/?id='.$resto_id);   
         }*/
         $data['total_cart_count']=CommonMethods::getCartcount();
         
         $resto_table=CommonMethods::getCurl($this->RESTO_API_URL.'resto/tables',true,$headers,NULL);

         $data['recipe_name']=($resto_id=='3abc00f2-b205-4fd4-a4d4-cb799cabc441')?$recipe_raw:''; 
         $data['token']=$token;
         $data['resto_table']=(!empty($resto_table) && isset($resto_table['data']))? $resto_table['data'] : NULL;

         return view('pages/checkout', $data);
    }
    public static function add_cart()
    {
        ini_set('memory_limit', -1);

        $id=$_POST['id'];
        $name=$_POST['name'];
        $price=(float)$_POST['price'];
        $qty=$_POST['qty'];
        $isEmpty=$_POST['isempty'];
        $token=Session::get('tokenid');
        $desc=$_POST['description'];
     
        $cust_total=(int)CommonMethods::getCustomizationSession($id,true);
        if(isset($_SESSION['recipe_list']) && !empty($_SESSION['recipe_list'][$token]))
        {


                if(array_search($id, array_column($_SESSION['recipe_list'][$token], 'id')) === FALSE && $qty!='0')
                {
                        $_SESSION['recipe_list'][$token][]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price+$cust_total,'qty'=>$qty,'price'=>$price,'tk'=>$token,'description'=>$desc);
                }
                else if(array_search($id, array_column($_SESSION['recipe_list'][$token], 'id')) !== FALSE)
                {


                        foreach ($_SESSION['recipe_list'][$token] as $key => $value)
                        {
                                if($value['id']==$id && $qty!='0')
                                {
                                  $_SESSION['recipe_list'][$token][$key]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price+$cust_total,'qty'=>$qty,'price'=>$price,'tk'=>$token,'description'=>$desc);
                                }
                                else if($value['id']==$id &&  $qty=='0')
                                {
                                  unset($_SESSION['recipe_list'][$token][$key]);
                                  CommonMethods::deleteCustomemenu($id);  
                                }

                        }

                }
        }
        else
        {
                $_SESSION['recipe_list'][$token][]=array('id'=>$id,'name'=>$name,'t_price'=>(int)$qty*(int)$price+$cust_total,'qty'=>$qty,'price'=>$price,'tk'=>$token,'description'=>$desc);
        }
        echo json_encode($_SESSION['recipe_list'][$token]);

    }
    public  function confirm_order(Request $request)
    {
          $meta_data=$request->input('meta');
          $meta_data=json_decode($meta_data,true);
          $total_amt=$request->input('total_amount');
          $sess_data=FoodCart::getData_formate($meta_data,$total_amt);
          /*echo '<pre>';
          print_r($sess_data);
          exit;*/
          $token=Session::get('tokenid');
          $headers =array('Authorization: Bearer '.$token);
          
          
          $result=CommonMethods::getCurl($this->RESTO_API_URL.'post/order',true,$headers,$sess_data);

          if(isset($result['type']) && $result['type']=='success')
          {
            $waiter_data=Http::withToken($token)->get($this->RESTO_API_URL.'resto/waiter');
            $waiter_data=$waiter_data->json();
            $waiter_id_arr=array();

            if(isset($waiter_data['data']) && $waiter_data['type']=='success')
            {
                 $waiter_data=$waiter_data['data'];
                 
                 foreach ($waiter_data as $key=> $value) {
                   $waiter_id_arr[]=$value['id'];
                 }
                 //$waiter_id_arr=json_encode($waiter_id_arr);
            }
            echo json_encode($result);
            exit;
            $arr2=array('order_id'=>$result['data']['order_id'],'id'=>$result['data']['order_id'],'message'=>'New Order Genereated='.$result['data']['order_id'],'waiter_data'=>$waiter_id_arr);
		        $x=$this->sendNotification($arr2);

            
          }
          else
          {
            echo json_encode(array('type'=>'error','msg'=>'Failed'));
          }
            
    }
    public  function order_status_page($id)
    {
       if(!Session::has('lang'))
       {
         $lang_detail=CommonMethods::updateLanguage(); 
       } 
       else
       {
         $lang_detail=CommonMethods::getLang(); 
       }

       App::setLocale($lang_detail); 
      
      $token=Session::get('tokenid');
      $resto_id=Session::get('resto_id');
      
      $resto_data=Http::get(env('RESTO_API_URL').'restuarant/'.$resto_id);
      $resto_data=$resto_data->json();
      
      $resto_token='';
      if(isset($resto_data['data']['access_token']) && $resto_data['data']['access_token']!=''){
        $resto_token=$resto_data['data']['access_token'];
      }
      $waiter_data=Http::withToken($resto_token)->get(env('RESTO_API_URL').'resto/waiter');
      $waiter_data=$waiter_data->json();
      

      $waiter_id_arr=array();

      if(isset($waiter_data['data']) && $waiter_data['type']=='success')
      {
         $waiter_data=$waiter_data['data'];
         foreach ($waiter_data as $key=> $value) 
         {
           $waiter_id_arr[]=$value['id'];
         }
         //$waiter_id_arr=json_encode($waiter_id_arr);
      }



        $arr1=array('order_id'=>$id,'id'=>$id,'message'=>'New Order Genereated='.$id,'waiter_data'=>$waiter_id_arr);

        //$x=$this->sendNotification($arr1);
        if($id && $id!='')
        {
            $result=CommonMethods::getOrderstatus($id);

            /*echo '<pre>';
            print_r($result);
            exit;*/
            $data['order_arr']=$result;
            $lang_detail=CommonMethods::updateLanguage();
            $data['lang_detail']=$lang_detail;
            $data['token']=$token; 

            $headers =array('Authorization: Bearer '.$token);
            $resto=CommonMethods::getCurl(env('RESTO_API_URL').'resto',false,$headers,NULL);
            $hotel_info_arr=(isset($resto['data']) && !empty($resto['data']))? $resto['data']: NULL;
            $data['hotel_info_arr']=$hotel_info_arr; 

            return view('pages/order_status', $data);
        }
        else
        {
          return response()->view('error.custome_error', array('msg'=>'Invalid ID'), 404);
        }
    }
    public  function waiter_login_page(Request $request){
        
      if(isset($_SESSION['waiter_token']))
      {
         /* return redirect('/waiter');
          exit;*/
      }  

      app()->setLocale('en');
      return view('pages/waiter');  
    }
    public function check_waiter_login()
    {
        $uname=$_POST['uname'];
        $pwd=$_POST['pwd'];
        $field=array('username'=>$uname,'password'=>$pwd);
        $res=CommonMethods::getCurl($this->RESTO_API_URL.'login',true,null,$field);
        if(isset($res['data']['access_token']))
        {
            $token=$res['data']['access_token'];
            $_SESSION['waiter_token']=$token;
            $_SESSION['waiter_data']=array('token'=>$token,'pwd'=>$pwd);
            return redirect('/waiter_page');   
        }
        else
        {
          unset($_SESSION['pwd']);
           return redirect()->intended('/waiter')->withErrors([$uname => 'You have entered an invalid username or password']);
        }
    }
    function sendNotification($data){

       $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        
        $pusher->trigger('deraya', 'App\\Events\\Notify', $data);
        
        Log::info(array('user_data' =>$data));
        return $pusher;
    }
    public function waiterPage(Request $request)
    {
        // unset($_SESSION['updated_orders_list']);
        // exit;
        
         $token=(isset($_SESSION['waiter_token'])) ? $_SESSION['waiter_token'] : '';
        if(isset($_SESSION['waiter_token']) && $_SESSION['waiter_token']!='')
        {
            $data=$_SESSION['waiter_data'];
            if($_SESSION['waiter_token']==$data['token']){
               
                $headers =array('Authorization: Bearer '.$token);
                $waiter=CommonMethods::getCurl($this->RESTO_API_URL.'waiter/',true,$headers,null);
                if(!isset($waiter['type']) && $waiter['type']!='success')
                {
                  return redirect('/waiter'); 
                }

                
                $waiter=$waiter['data'];
                $resto_id=$waiter['resto_shared_unique_id'];
                $_SESSION['resto_unique_id']=$resto_id;

                if(!isset($_SESSION['waiter_resto_token']))
                {
                  $data=CommonMethods::getCurl($this->RESTO_API_URL.'restuarant/'.$resto_id,false,null,null);

                  $resto_token=$data['data']['access_token'];
                  $_SESSION['waiter_resto_token']=$resto_token;   
                  $_SESSION['waiter_resto_detail']=$data['data'];       
                  
                }
                $resto_token=$_SESSION['waiter_resto_token'];

                $res=CommonMethods::getWaiterOrders($resto_token);
                //$lang_detail=CommonMethods::updateLanguage();

                

                $lang_detail=array( 'direction' => 'rtl/','lang' =>'E','lang_txt'=>'ar','lang_margin'=>'margin-left:5px; margin-bottom:5px;');
                $data['lang_detail']=$lang_detail;
                $data['resto_list']=$res;
                $data['waiter']=$waiter;
                $data['resto_id']=$resto_id;
                $data['lang_txt']='en';
                $_SESSION['lang'][$token]='en';

                 $headers =array('Authorization: Bearer '.$resto_token);
                $resto=CommonMethods::getCurl($this->RESTO_API_URL.'resto',false,$headers,NULL);
                $hotel_info_arr=$resto['data'];
                $data['hotel_info_arr']=$hotel_info_arr;
                
                return view('pages/waiter_page',$data);
            }
            else
            {
                return redirect('/waiter');   
            }
        }
        else
        {
            return redirect('/waiter');   
        }
    }
    public function orderHtml($value){

      
      $obj=array('id'=>$value['id'],'order_id'=>$value['id'],'customer_name'=>'','waiter_name'=>'','waiter_id'=>'','order_date'=>date('Y-m-d',strtotime($value['order_date'])),
        'status'=>$value['status'],'total_price'=>'total_price');
      $str='<div class="col-md-6">
             <div class="bg-white card addresses-item mb-4 border border-primary shadow">
                <div class="gold-members p-4">
                   <div class="media">
                      <div class="mr-3"><i class="icofont-ui-user icofont-3x"></i></div>
                      <div class="media-body">
                         <h6 class="mb-1 text-secondary">'.$value["customer_name"].'</h6>
                         <p class="text-black">Order No. : '.$value["order"].'</p>
                         <p class="text-black">Table No. :</p>
                         <p class="text-black">Order Date: '.$value["order_date"].'</p>
                         <p class="text-black">Status : '.$value["status"].'</p>
                         <p class="mb-0 text-black font-weight-bold">
                            <a class="text-primary mr-3 view_order" data-obj='.json_encode($obj,true).'>
                               <i class="icofont-page"></i> View</a> 
                               <!-- <a class="text-danger" data-toggle="modal" data-target="#delete-address-modal" href="#">
                                  <i class="icofont-ui-delete"></i> DELETE</a> -->
                               </p>
                      </div>
                   </div>
                </div>
             </div>
          </div>';
          return $str;
    }
    public function orderDesign(Request $req)
    {
         $order_id=$req->post('order_id');
         $resto_token=$_SESSION['waiter_resto_token'];
         $waiter_data=Http::withToken($resto_token)->get(env('RESTO_API_URL').'order/detail?order_id='.$order_id);
         $waiter_data=$waiter_data->json();
         
         if(isset($waiter_data['type']) && $waiter_data['type']=='success')
         {
           $result=$this->orderHtml($waiter_data['data']);
           echo $result;
           exit;
         }
         else
         {
           echo '';
           exit;
         }
    }
    public function custome_menu_comp(Request $request)
    { 
      $recepie_id=$request->input('id');
      $token=Session::get('tokenid');
      $recepie_data=Http::withToken($token)->get(env('RESTO_API_URL').'recipe/by/id?id='.$recepie_id);
      $recepie_data=$recepie_data->json();
      $recepie_data=(isset($recepie_data['data'])) ? $recepie_data['data'] : NULL;

      $response=NULL;
      if(isset($recepie_data['is_customized']) && isset($recepie_data['extra_options']) &&  !empty($recepie_data['extra_options']) && $recepie_data['is_customized']=='Yes')
      {
        //$res=CommonMethods::getCustomemenuDesign($recepie_data);
        $response=$recepie_data['extra_options'];
      }
      echo json_encode($response);
    }
    public function get_customize_session(Request $req)
    {
       $id=$req->input('id');
       $res=FoodCart::getSession_id($id);
       $data=array();
       $tags='';

       if(!empty($res))
       {
          foreach ($res as $key => $value) 
          {
            $firstKey = array_key_first($value);

            $mix_arr=array_merge($value[0]['checkbox'],$value[0]['radio']);
            foreach ($mix_arr as $k => $v) 
            {
              $data[$v['parent_title']][]=$v['title'];
            }
          }
          foreach ($data as $key => $value) 
          {
            $tags.=$key.':'.json_encode($value, JSON_UNESCAPED_UNICODE);
          }
          $tags=str_replace(array('[',']','"'),'',$tags);
       }
       echo $tags;
    }
    public function customization_update(Request $request){
      
      $res=CommonMethods::setcustomizationSession($request);
      print_r($res);
    }
    public function cust_cart_html(Request $request){
      $id=$request->input('id');
      $data=CommonMethods::getCustomHtml($id);

      print_r($data);
    }
    public function test(){
      //Session::forget('food_cart');

      //add
      //$res=FoodCart::setSession();

      //get
      //FoodCart::deleteSession_index(3);
      //$res=FoodCart::getSession_formate();
      echo '<pre>';
      $token=FoodCart::getSession();
      print_r($token);

    }
    public function demo(Request $request){
      $options=$request->input('options');

      $checkbox=(isset($options['chk_opt']) && !empty($options['chk_opt'])) ? array_values($options['chk_opt']) : array();
      $radio =(isset($options['radio_opt']) && !empty($options['radio_opt']))? array_values($options['radio_opt']) : array();
      $chk_title=(isset($options['chk_title_box']) && !empty($options['chk_title_box']))? array_values($options['chk_title_box']) : array(); 
      
      $arr_merge=array_merge($checkbox,$radio);
      $arr=array();
      foreach ($arr_merge as $key => $value) 
      {
         if(isset($value['parent_title'])){
           //$arr[$value['parent_title']][]=str_repeat($value['title'].',',$value['qty']); 
            $arr[$value['parent_title']][]='('.$value['qty'].' X '.$value['title'].')';
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
          $tags.='<b>'.$key.'</b> : '.json_encode($value, JSON_UNESCAPED_UNICODE).',';
        } 
        $tags=str_replace(array('[',']','"'),'',$tags);
        //$tags=str_replace(',,',',',$tags);
      }
      
      return $tags;
    }
    public static function getOptionsTotal($data){
      $total=0;
      if(!empty($data))
      {
         foreach ($data as $key => $value) {
            $total=$total+$value['price'];
         }
      }
      return $total;
    }
}
