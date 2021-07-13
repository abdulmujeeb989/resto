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

class FoodCart extends Controller
{
	private $RESTO_API_URL="";	
	public function __construct()
    {
        $this->RESTO_API_URL=env("RESTO_API_URL");
        
    }
    
    public static function add_cart(Request $request)
    {

          $isCustomized=$request->input('is_customized');
          $recipe_id=$request->input('id');
          $recipie_price=$request->input('recipe_price');
          $total_price=$request->input('price');
          $qty=$request->input('qty');
          $desc=$request->input('description');
          $name=$request->input('name');
          $isRepeatelse=$request->input('isRepeatelse');

          $isRepeat=$request->input('isRepeat');

          $index_id='0_'.$recipe_id;

          $options=array();
          if($isCustomized=='Yes')
          {
            $checkbox=$request->input('chk_opt');
            $radio =$request->input('radio_opt');
            $chk_title=$request->input('chk_title');

            $checkbox=(isset($checkbox) && !empty($checkbox)) ? array_values($checkbox) : array();
            $radio =(isset($radio) && !empty($radio))? array_values($radio) : array();
            $chk_title=(isset($chk_title) && !empty($chk_title))? array_values($chk_title) : array();  

            $options['checkbox']=$checkbox;
            $options['radio']=$radio;
            $options['checkbox_title']=$chk_title;

            $index_id='1_'.$recipe_id;
            $desc=CommonMethods::arrtotext($request->input());

             $arr[$index_id]=array(
                'recipe_id'=>$recipe_id,
                'recipie_price'=>$recipie_price,
                'totla_price'=>$total_price,
                'qty'=>$qty,
                'name'=>$name,
                'desc'=>$desc,
                'isCustomized'=>$isCustomized,
                'cust_core_price'=>$total_price,
                'row_id'=>rand(),
                $options);

                if($isRepeat=='true')
                {
                    $chek=FoodCart::getSession_id($recipe_id);
                    if(!empty($chek))
                    {

                       $result=FoodCart::updateSession_id($request->input(),$recipe_id);
                       $total_price=FoodCart::getTotalamount();
                       $total_qty=FoodCart::getTotalCount();
                       $item_qty=FoodCart::getItemQty_id($recipe_id);

                       $data1['total_amount']=$total_price;
                       $data1['total_qty']=$total_qty;
                       $data1['item_qty']=$item_qty;
                       return CommonMethods::sendResponse($data,'Session Updated Succesfully','sucess');
                    }
                }
                else if(isset($isRepeatelse) && $isRepeatelse=='Yes')
                {

                    $chek=FoodCart::getSession_id($recipe_id);
                    $count=count($chek);
                    if($count!=0 && $count==1 && $qty>0)
                    {
                        $result=FoodCart::updateSession_id($request->input(),$recipe_id);
                        
                        $total_price=FoodCart::getTotalamount();
                        $total_qty=FoodCart::getTotalCount();
                        $item_qty=FoodCart::getItemQty_id($recipe_id);

                        $data1['total_amount']=$total_price;
                        $data1['total_qty']=$total_qty;
                        $data1['item_qty']=$item_qty;

                        return CommonMethods::sendResponse($data1,'Session Updated Succesfully','sucess');
                    }
                }
                if($qty=='0'){
                    $count=FoodCart::countItem_id($recipe_id);
                    if($count<=1)
                    {

                        $res=FoodCart::deleteSession_id($recipe_id);

                        $total_price=FoodCart::getTotalamount();
                        $total_qty=FoodCart::getTotalCount();
                        $item_qty=FoodCart::getItemQty_id($recipe_id);

                        $data1['total_amount']=$total_price;
                        $data1['total_qty']=$total_qty;
                        $data1['item_qty']=$item_qty;
                        return CommonMethods::sendResponse($data1,'Session Updated Succesfully','sucess');
                        
                    }

                }
                if($qty!='0' && $total_price!='0')
                {
                     $chek=FoodCart::getSession_id($recipe_id);
                     $count=count($chek);
                     $res=Session::push('food_cart',$arr);    

                     $total_price=FoodCart::getTotalamount();
                     $total_qty=FoodCart::getTotalCount();
                     $item_qty=FoodCart::getItemQty_id($recipe_id);

                     $data1['total_amount']=$total_price;
                     $data1['total_qty']=$total_qty;
                     $data1['record']=$count;
                     $data1['item_qty']=$item_qty;
                     return CommonMethods::sendResponse($data1,'Add New Session Sucessful','sucess');    
                }
                
          
          }
          else
          {
             $arr[$index_id]=array(
                'recipe_id'=>$recipe_id,
                'recipie_price'=>$recipie_price,
                'totla_price'=>$total_price,
                'qty'=>$qty,
                'name'=>$name,
                'desc'=>$desc,
                'isCustomized'=>$isCustomized,
                'cust_core_price'=>$total_price,
                'row_id'=>rand(),
                $options);

              $chek=FoodCart::getSession_id($recipe_id);
                if(!empty($chek))
                {
                   $result=FoodCart::updateSession_id($request->input(),$recipe_id);

                   $total_price=FoodCart::getTotalamount();
                   $total_qty=FoodCart::getTotalCount();

                   $data1['total_amount']=$total_price;
                   $data1['total_qty']=$total_qty;
                   return CommonMethods::sendResponse($data1,'Session Updated Succesfully','sucess');
                }
                if($qty!='0' && $total_price!='0')
                {
                     $res=Session::push('food_cart',$arr);    
                     
                     $total_price=FoodCart::getTotalamount();
                     $total_qty=FoodCart::getTotalCount();

                     $data['total_amount']=$total_price;
                     $data['total_qty']=$total_qty;
                     return CommonMethods::sendResponse($data,'Add New Session Sucessful','sucess');    
                }
                
          }
          exit;
    }
    public static function getSession()
    {
       $res=Session::get('food_cart');
       return $res;
    }
    public static function getSession_index($index)
    {
       $res=Session::get('food_cart');
       return $res[$index];
    }
    public static function getSession_id($id)
    {
        $res=Session::get('food_cart');
        $res= CommonMethods::searchx($res,'recipe_id',$id);
        return $res;
    }
    public static function getSession_rowid($rowid)
    {
        $res=Session::get('food_cart');
        $res= CommonMethods::searchx($res,'row_id',$rowid);
        return $res;
    }
    public static function getSessionByindexId($id,$index)
    {
        $res=Session::get('food_cart');
        $data=array();
        foreach ($res as $key => $value) 
        {
           if(isset($value[$id]) &&  $key==$index){
             $data=$value;
           }
        }
        return $data;
    }
    public static function updateSession_index($request,$index)
    {
        $result=FoodCart::getSession_index($index);
        if(!empty($result))
        {
            foreach ($result as $key => $value) 
            {
                print_r($value);
            }
        }
    }
    public static function getOptionjson_rowid($row_id)
    {
        $data=FoodCart::getSession_rowid($row_id);
        $total=0;
        $option_total=array();

       foreach ($data as $key => $value) 
       {
           foreach ($value as $k => $v) 
           {
              if(is_array($v) && !empty($v))
              {
                $radio_total=array_map(function($item) 
                { 
                    $arr['id']=$item['sub_item_id'];
                    $arr['parent_id']=$item['extra_id'];
                    $arr['price']=$item['price'];
                    return $arr;
                }, $v['radio']);

                $checkob_total=array_map(function($item) 
                { 
                    $arr['id']=$item['sub_item_id'];
                    $arr['parent_id']=$item['extra_id'];
                    $arr['price']=$item['price'];
                    return $arr;
                }, $v['checkbox']);


                $chk_title_total=array_map(function($item) 
                { 
                    $arr['id']=$item['id'];
                    $arr['parent_id']='';
                    $arr['price']=$item['price'];
                    return $arr;
                }, $v['checkbox_title']);
                
                $option_total=array_merge($radio_total,$checkob_total,$chk_title_total);
                
              }

           }
       }    
       return $option_total;
    }   
    public static function getSession_formate($request){
        $res=Session::get('food_cart');
        $data1=array();
        foreach ($res as $key => $value) 
        {
            foreach ($value as $k => $v) 
            {
              $x=FoodCart::getOptionjson_rowid($v['row_id']);
              $data1['items'][$v['row_id']]=array('recipe_id'=>$v['recipe_id'],'quantity'=>$v['qty'],'extra_options'=>$x);
            }
            
        }
        $data1['table_id']=$request['table'];
        $data1['customer_name']=$request['customer'];
        $data1['customer_ip']=$_SERVER['REMOTE_ADDR'];
        $response=json_encode(array('data'=>$data1));
        return $response;
    }
    public static function getData_formate($data,$total=NULL)
    {
      $data1=array();
        foreach ($data as $key => $v) 
        {
          
          $x=FoodCart::optionJson($v['options']);
          $data1['items'][$v['row_id']]=array('recipe_id'=>$v['recipe_id'],'quantity'=>$v['qty'],'extra_options'=>$x);
            
        }
        $data1['table_id']=1;
        $data1['customer_name']='';
        $data1['customer_ip']=$_SERVER['REMOTE_ADDR'];
        $data1['total_price']=$total;
        $response=json_encode(array('data'=>$data1));
        return $response;
    }
    public static function optionJson($data)
    {
        $radio_total=[];
        $checkob_total=[];
        $chk_title_total=[];
        if(!empty($data['radio_opt']))
        {
          $radio_total=array_map(function($item) 
          { 
              $arr['id']=$item['sub_item_id'];
              $arr['parent_id']=$item['extra_id'];
              $arr['price']=$item['price'];
              $arr['qty']=$item['qty'];
              return $arr;
          }, $data['radio_opt']);
        }
        
        if(!empty($data['chk_opt']))
        {
          $checkob_total=array_map(function($item) 
          { 
              $arr['id']=$item['sub_item_id'];
              $arr['parent_id']=$item['extra_id'];
              $arr['price']=$item['price'];
              $arr['qty']=$item['qty'];
              return $arr;
          }, $data['chk_opt']);  
        }
        
        if(!empty($data['chk_title_box']))
        {
          $chk_title_total=array_map(function($item) 
          { 
              $arr['id']=$item['id'];
              $arr['parent_id']='';
              $arr['price']=$item['price'];
              $arr['qty']=$item['qty'];
              return $arr;
          }, $data['chk_title_box']);
        }


        
        $option_total=array_merge($radio_total,$checkob_total,$chk_title_total);
        return $option_total;
        exit;
       $xdata=array();
       if(!empty($data))
       {
          
          foreach ($data as $key => $value) 
          {
             if(!empty($value))
             {
                foreach ($value as $k => $v) 
                {
                  print_r($v);
                }
             }
          }
       }
    }
    public static function updateSession_id($request,$id)
    {
        //$result=FoodCart::getSession_id($id);
        $result=Session::get('food_cart');
        

        if(!empty($result))
        {
           foreach ($result as $key => $value) 
           {
            
                $firstKey = array_key_first($value);
                $value=$value[$firstKey];

                 if($value['recipe_id']==$request['id'])
                 {
                    if($request['qty']=='0' || $request['qty']==0)
                    {
                        FoodCart::deleteSession_id($id);
                        return false;
                    }
                    if($value['isCustomized']=='Yes' && isset($value['isCustomized'])) // its for customizable items
                    {
                         $index_id='1_'.$id;
                         

                        $checkbox=(isset($request['chk_opt']))? $request['chk_opt'] : (isset($value[0]['checkbox']) && !empty($value[0]['checkbox'])) ? $value[0]['checkbox'] : NULL;
                        $radio =(isset($request['radio_opt']))? $request['radio_opt']:(isset($value[0]['radio']) && !empty($value[0]['radio'])) ? $value[0]['radio'] : NULL;
                        $chk_title=(isset($request['chk_title']))? $request['chk_title']: (isset($value[0]['checkbox_title']) && !empty($value[0]['checkbox_title'])) ? $value[0]['checkbox_title'] : NULL;

                        $mix_data=array();
                        $mix_data['chk_opt']=$checkbox;
                        $mix_data['radio_opt']=$radio;
                        $mix_data['chk_title']=$chk_title;

                        $desc=CommonMethods::arrtotext($mix_data);

                        $checkbox=(isset($checkbox) && !empty($checkbox)) ? array_values($checkbox) : array();
                        $radio =(isset($radio) && !empty($radio))? array_values($radio) : array();
                        $chk_title=(isset($chk_title) && !empty($chk_title))? array_values($chk_title) : array();  

                        $options['checkbox']=$checkbox;
                        $options['radio']=$radio;
                        $options['checkbox_title']=$chk_title;

                        if($request['isRepeat']=='true'){
                            $request['qty']=(int)$value['qty']+1;
                            $request['price']=$value['totla_price'];
                        }
                        else{
                            /*$value['qty']=$request['qty'];
                            $value['totla_price']=$request['price'];*/

                            $option_total=FoodCart::getOptiondata($value['row_id']);
                            $core_price=$value['recipie_price'];
                            $new_qty=$request['qty'];
                            $total=($core_price+$option_total)*$new_qty;
                            $value['totla_price']=$total;
                            $value['qty']=$new_qty;

                        }

                        $arr[$index_id]=array(
                        'recipe_id'=>$request['id'],
                        'recipie_price'=>$request['recipe_price'],
                        'totla_price'=>$value['totla_price'],
                        'qty'=>$request['qty'],
                        'name'=>$request['name'],
                        'desc'=>$desc,
                        'isCustomized'=>$request['is_customized'],
                        'cust_core_price'=>$value['cust_core_price'],
                        'row_id'=>$value['row_id'],
                        $options);

                        $res=Session::put('food_cart.'.$key,$arr);
                    }
                    else if($value['isCustomized']=='No' && isset($value['isCustomized'])) // its for uncustomizable items
                    {
                        $index_id='0_'.$id;
                        $value['qty']=$request['qty'];
                        $value['totla_price']=$request['price']*$request['qty'];
                        $arr[$index_id]=$value;
                        
                        $res=Session::put('food_cart.'.$key,$arr);
                    }
                 }
              
           }
        }
    }
    public static function updateSession_rowid($request)
    {
        //$result=FoodCart::getSession_id($id);
        $result=Session::get('food_cart');
        

        if(!empty($result))
        {
           foreach ($result as $key => $value) 
           {
            
                $firstKey = array_key_first($value);
                $value=$value[$firstKey];
                if($value['row_id']==$request['row_id'])
                {

                    $option_total=FoodCart::getOptiondata($request['row_id']);
                    $core_price=$value['recipie_price'];
                    $new_qty=$request->input('qty');

                    if($new_qty=='0'){
                       $res=FoodCart::deleteSession_rowid($request['row_id']);
                       return CommonMethods::sendResponse(NULL,'Delete Recepie Sucessful','sucess');
                    }

                    $total=($core_price+$option_total)*$new_qty;

                    $value['qty']=$new_qty;
                    $value['totla_price']=$total;
                    $value['option_total']=$total;
                    $res=Session::put('food_cart.'.$key,array('1_'.$value["recipe_id"]=>$value));
                }
              
           }
        }
    }
    public function updateLast(Request $request)
    {
        $result=Session::get('food_cart');
        $isCustomized=$request->input('is_customized');
        $recipe_id=$request->input('recipe_id');

        $index=($isCustomized=='Yes')? '1_'.$recipe_id : '0_'.$recipe_id;
        $data=array();
        if(!empty($result))
        {
           foreach ($result as $key => $value) 
           {
                if(isset($value[$index]))
                {
                    $data[$key][$key]=$value;

                }
           }
           
           if(!empty($data))
           {
             $key = array_key_first(end($data));
             
             $last_arr_index=end($data);
             $res=CommonMethods::searchx(end($last_arr_index),'recipe_id',$recipe_id);

             if(!empty($res[0]))
             {
                 $value=$res[0];
                 
                if($value['recipe_id']==$recipe_id)
                 { 
                    if($value['isCustomized']=='Yes' && isset($value['isCustomized'])) // its for customizable items
                    {
                         $index_id='1_'.$recipe_id;
                  

                        if($request['isRepeat']=='true')
                        {
                            $value['qty']=(int)$value['qty']+1;
                            $value['totla_price']=$value['qty']*$value['cust_core_price'];
                        }
                        $arr[$index_id]=$value;

                        $res=Session::put('food_cart.'.$key,$arr);
                        $res1=FoodCart::getSessionByindexId($index,$key);

                        $total_price=FoodCart::getTotalamount();
                        $total_qty=FoodCart::getTotalCount();
                        $item_qty=FoodCart::getItemQty_id($recipe_id);

                        $data1['item_qty']=$item_qty;
                        $data1['total_amount']=$total_price;
                        $data1['total_qty']=$total_qty;
                        $data1['status']='success';
                        $data1['data']=$res1[$index_id];
                        return json_encode($data1);
                        
                    }
                 } 
             }
           }
           else
           {
             return 'Data Not Found';
           }     
        }
        else
        {
            return 'No Data';
        }
        
    }
    public static function deleteSession_all()
    {
        if(!empty(Session::get('food_cart')))
        {
            Session::forget('food_cart');
        }
    }
    public static function deleteSession_id($id)
    {

        if(!empty(Session::get('food_cart')))
        {
           foreach (Session::get('food_cart') as $key => $value) 
           {
              $res=CommonMethods::searchx($value,'recipe_id',$id);
              if(!empty($res) && $res[0]['recipe_id']==$id)
              {
                 Session::forget('food_cart.'.$key);
              }
           }
        }   
    }
    public static function deleteSession_rowid($row_id)
    {

        if(!empty(Session::get('food_cart')))
        {
           foreach (Session::get('food_cart') as $key => $value) 
           {
              $res=CommonMethods::searchx($value,'row_id',$row_id);
              if(!empty($res) && $res[0]['row_id']==$row_id)
              {
                 Session::forget('food_cart.'.$key);
              }
           }
        }   
    }
    public static function deleteSession_index($index)
    {
       if(!empty(Session::get('food_cart')))
       {
         Session::forget('food_cart.'.$index);
       }   
    }
    public static function getTotalamount_id($id){
        $total=0;
        $result=Session::get('food_cart');
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             $firstKey = array_key_first($val);
             $val=$val[$firstKey];
             if($val['recipe_id']==$id)
             {
               $total+=$total+$val['totla_price'];   
             }
             
           }

        }
        return number_format($total).' '.env('CURRENCY');
    }
    public static function getTotalamount_index($index){
        $total=0;
        $result=Session::get('food_cart.'.$index);
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             $firstKey = array_key_first($val);
             $val=$val[$firstKey];
             $total+=$total+$val['totla_price'];
           }

        }
        return number_format($total).' '.env('CURRENCY');
    }
    public static function getTotalamount(){

        $total=0;
        $result=Session::get('food_cart');
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             $firstKey = array_key_first($val);
             $val=$val[$firstKey];
             $total=$total+$val['totla_price'];
           }

        }
        return number_format($total).' '.env('CURRENCY');
    }
    public static function countItem_id($id){
        $total=0;
        $result=Session::get('food_cart');
        
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             foreach ($val as $key => $value) 
             {
                if($value['recipe_id']==$id){
                    $total++;
                }
             }
             
           }

        }
        return $total;
    }
    public static function getTotalCount()
    {
        $total=0;
        $result=Session::get('food_cart');
        $data=array();
        
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             
             foreach ($val as $key => $value) 
             {
                
                $total=$total+$value['qty'];
               if(!in_array($key, $data, true)){
                    array_push($data, $key);
                    //$total++;
                }
             }
             
           }

        }
        return $total;
    }
    public static function getOptiondata($row_id)
    {
       $data=FoodCart::getSession_rowid($row_id);
       $total=0;
       $option_total=array();

       foreach ($data as $key => $value) 
       {
           foreach ($value as $k => $v) 
           {
              if(is_array($v) && !empty($v))
              {
                $radio_total=array_sum(array_map(function($item) { 
                    return $item['price']; 
                }, $v['radio']));
                $checkob_total=array_sum(array_map(function($item) { 
                    return $item['price']; 
                }, $v['checkbox']));
                $chk_title_total=array_sum(array_map(function($item) { 
                    return $item['price']; 
                }, $v['checkbox_title']));
                $total=$total+$radio_total+$checkob_total+$chk_title_total;
                
                
              }

           }
       }
       return $total;
    }
    public static function getLastData_id($id)
    {
        $result=Session::get('food_cart');
        $data=array();
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             foreach ($val as $key => $value) 
             {
                if($value['recipe_id']==$id){
                    $data=$value;
                }
             }
             
           }

        }
        return $data;
    }
    public static function getItemQty_id($id){
       $total=0;
       $result=Session::get('food_cart');
        $data=array();
        if(isset($result) && !empty($result))
        {
           foreach ($result as $k => $val) 
           {
             foreach ($val as $key => $value) 
             {
                if($value['recipe_id']==$id){
                    $total=$total+$value['qty'];
                }
             }
             
           }

        }
        return $total;
    }
    public static function getItemTotal_rowid($row_id)
    {
        $res=Session::get('food_cart');
        $res= CommonMethods::searchx($res,'row_id',$row_id);
        $total=(isset($res[0]) && isset($res[0]['totla_price'])) ? $res[0]['totla_price'] : 0;
        
        return $total;
    }
    public function update_cart_items(Request $request){
        $response=FoodCart::updateSession_rowid($request);
        $total_item=FoodCart::countItem_id($request->input('id'));
        
        $last_qty=0;
       /* if($total_item>1 && $total_item!=0)
        {
          
        }*/

        $last_qty=FoodCart::getItemQty_id($request->input('id'));  

         $total_price=FoodCart::getTotalamount();
         $total_qty=FoodCart::getTotalCount();
         $item_qty=FoodCart::getItemQty_id($request->input('id'));
         $row_item_qty=FoodCart::getSession_rowid($request->input('row_id'));
         $row_item_total=FoodCart::getItemTotal_rowid($request->input('row_id'));

         $data1['total_amount']=$total_price;
         $data1['total_qty']=$total_qty;
         $data1['last_qty']=$last_qty;
         $data1['item_qty']=$item_qty;
         $data1['row_item_qty']=(isset($row_item_qty[0]) && isset($row_item_qty[0]['qty'])) ? $row_item_qty[0]['qty'] : NULL;
         $data1['row_item_price']=$row_item_total;
        
         return CommonMethods::sendResponse($data1,'Recepie Update Sucessful','sucess');
        
    }
}
