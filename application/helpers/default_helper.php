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
//模拟post
function curl_post($url, $post){
    $options = array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_HEADER =>false,
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => $post,
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


 ?>