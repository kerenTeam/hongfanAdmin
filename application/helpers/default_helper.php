<?php 

/**
*    公用函数
*/

//获取用户组名
function group_name($gid){
	$CI = &get_instance();
	$sql = "SELECT group_name FROM hf_user_member_group where gid = '$gid'";
	$query = $CI->db->query($sql);
	$name = $query->row_array();
	return $name['group_name'];

}

//获取用户名
function user_name($user_id){
    $CI = &get_instance();
    $sql = "SELECT username FROM hf_user_member where user_id = '$user_id'";
    $query = $CI->db->query($sql);
    $name = $query->row_array();
    return $name['username'];
}

// //返回商品分类名称
// function goods_cate_name($id){
//     $CI = &get_instance();
//     $where['catid'] = $id;
//     $query = $this->db->where($where)->get('hf_mall_category');
//     $res = $query->row_array();
//     return $res['catname']; 
// }

//返回会员卡名称
function get_card_name($cardid){
    $CI = &get_instance();
    $sql = "SELECT name FROM hf_shop_membership_card_type where id = '$cardid'";
    $query = $CI->db->query($sql);
    $name = $query->row_array();
    return $name['name'];
}

//商家商品搜索
function search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear,$differentiate){
            $CI = &get_instance();
            if(empty($state)){
                $state = '2';
            }else{
                $state = $state;
            }
            $res= '';
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where("goods_state",$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->like("title",$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                  if($state == 2){
                    $state = '0';
                } 

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                  if($state == 2){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                  if($state == 2){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
                
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                  $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                  if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
               
            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }
            return $res;
}

function guid($no_of_codes,$exclude_codes_array='',$code_length = 4) 
{ 
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    $promotion_codes = array();//这个数组用来接收生成的优惠码 
    for($j = 0 ; $j < $no_of_codes; $j++) 
    { 
        $code = ""; 
        for ($i = 0; $i < $code_length; $i++) 
        { 
        $code .= $characters[mt_rand(0, strlen($characters)-1)]; 
        } 
//如果生成的4位随机数不再我们定义的$promotion_codes函数里面 
        if(!in_array($code,$promotion_codes)) 
        { 
            if(is_array($exclude_codes_array))// 
            { 
                if(!in_array($code,$exclude_codes_array))//排除已经使用的优惠码 
                { 
                    $promotion_codes[$j] = $code;//将生成的新优惠码赋值给promotion_codes数组 
                } else { 
                    $j--; 
                } 
            } else { 
                $promotion_codes[$j] = $code;//将优惠码赋值给数组 
            } 
        }else { 
           $j--; 
        } 
    } 
    return $promotion_codes; 
} 


//生成二维码，返回地址与优惠码
function generate_promotion_code($code){
      $CI = &get_instance();
      $CI->load->library('phpCode/qrlib');
      $path = 'upload/code/';
     
       if (!file_exists($path))
        mkdir($path);
      $filename = 'upload/code/'.date('Ymd_His').'.png';

      $errorCorrectionLevel = 'L';
      $matrixPointSize = 8; 
      QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 1);    
    //display generated file
        return $filename;
}


//帮帮团成员搜索
function search_help_user($name,$area,$address,$occupation,$sear){
      $CI = &get_instance();
      $res= '';
      if(!empty($name) && empty($area) && empty($address) && empty($occupation) && empty($sear)){
            $query = $CI->db->where('name',$name)->get('hf_service_help_user');
            $res = $query->result_array();
      }else
      if(empty($name) && !empty($area) && empty($address) && empty($occupation) && empty($sear)){
          $query = $CI->db->where('area',$area)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && !empty($address) && empty($occupation) && empty($sear)){
          $query = $CI->db->where('address',$address)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && empty($address) && !empty($occupation) && empty($sear)){
          $query = $CI->db->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && empty($address) && empty($occupation) && !empty($sear)){
          $query = $CI->db->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(!empty($name) && !empty($area) && empty($address) && empty($occupation) && empty($sear)){
          $query = $CI->db->where('name',$name)->where('area',$area)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(!empty($name) && empty($area) && !empty($address) && empty($occupation) && empty($sear)){
          $query = $CI->db->where('name',$name)->where('address',$address)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(!empty($name) && empty($area) && empty($address) && !empty($occupation) && empty($sear)){
         $query = $CI->db->where('name',$name)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(!empty($name) && empty($area) && empty($address) && empty($occupation) && !empty($sear)){
          $query = $CI->db->where('name',$name)->like('name',$sear,'both')->like('occupation',$sear,'both')->like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(empty($name) && !empty($area) && !empty($address) && empty($occupation) && empty($sear)){
          $query = $CI->db->where('area',$area)->where('address',$address)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(empty($name) && !empty($area) && empty($address) && !empty($occupation) && empty($sear)){
          $query = $CI->db->where('area',$area)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && !empty($area) && empty($address) && empty($occupation) && !empty($sear)){
          $query = $CI->db->where('area',$area)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && !empty($address) && !empty($occupation) && empty($sear)){
          $query = $CI->db->where('address',$address)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && !empty($address) && empty($occupation) && !empty($sear)){
        $query = $CI->db->where('address',$address)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && empty($area) && empty($address) && !empty($occupation) && !empty($sear)){
          $query = $CI->db->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(!empty($name) && !empty($area) && !empty($address) && empty($occupation) && empty($sear)){
         $query = $CI->db->where('name',$name)->where('area',$area)->where('address',$address)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(!empty($name) && !empty($area) && empty($address) && !empty($occupation) && empty($sear)){
         $query = $CI->db->where('name',$name)->where('area',$area)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(!empty($name) && !empty($area) && empty($address) && empty($occupation) && !empty($sear)){
         $query = $CI->db->where('address',$address)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(empty($name) && !empty($area) && !empty($address) && !empty($occupation) && empty($sear)){
          $query = $CI->db->where('area',$area)->where('address',$address)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(empty($name) && !empty($area) && !empty($address) && empty($occupation) && !empty($sear)){
          $query = $CI->db->where('area',$area)->where('address',$address)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(empty($name) && empty($area) && !empty($address) && !empty($occupation) && !empty($sear)){
          $query = $CI->db->where('address',$address)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(!empty($name) && empty($area) && !empty($address) && !empty($occupation) && empty($sear)){
          $query = $CI->db->where('name',$name)->where('address',$address)->where('occupation',$occupation)->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(!empty($name) && empty($area) && empty($address) && !empty($occupation) && !empty($sear)){
          $query = $CI->db->where('name',$name)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && !empty($area) && empty($address) && !empty($occupation) && !empty($sear)){
          $query = $CI->db->where('area',$area)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
      if(empty($name) && !empty($area) && !empty($address) && !empty($occupation) && !empty($sear)){
          $query = $CI->db->where('area',$area)->where('address',$address)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }else
       if(!empty($name) && !empty($area) && !empty($address) && !empty($occupation) && empty($sear)){
            $query = $CI->db->where('name',$name)->where('area',$area)->where('address',$address)->where('occupation',$occupation)->get('hf_service_help_user');
            $res = $query->result_array();
      }else
      if(!empty($name) && !empty($area) && !empty($address) && empty($occupation) && !empty($sear)){
        $query = $CI->db->where('name',$name)->where('area',$area)->where('address',$address)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
         $res = $query->result_array();
      }else
      if(!empty($name) && !empty($area) && empty($address) && !empty($occupation) && !empty($sear)){

        $query = $CI->db->where('name',$name)->where('area',$area)->where('occupation',$occupation)->or_like('name',$sear,'both')->or_like('occupation',$sear,'both')->like('competency',$sear,'both')->get('hf_service_help_user');
         $res = $query->result_array();
      }else
       if(!empty($name) && empty($area) && !empty($address) && !empty($occupation) && !empty($sear)){
        $query = $CI->db->where('name',$name)->where('address',$address)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
         $res = $query->result_array();
      }else
      if(empty($name) && !empty($area) && !empty($address) && !empty($occupation) && !empty($sear)){
        $query = $CI->db->where('area',$area)->where('address',$address)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
         $res = $query->result_array();
      }else
      if(!empty($name) && !empty($area) && !empty($address) && !empty($occupation) && !empty($sear)){
         $query = $CI->db->where('name',$name)->where('area',$area)->where('address',$address)->where('occupation',$occupation)->like('name',$sear,'both')->or_like('occupation',$sear,'both')->or_like('competency',$sear,'both')->get('hf_service_help_user');
          $res = $query->result_array();
      }
      return $res;
}


 ?>