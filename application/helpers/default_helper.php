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

//获取用户别名
function nick_name($userid){
        $CI = &get_instance();
        $sql = "SELECT nickname FROM hf_user_member where user_id = '$userid'";
        $query = $CI->db->query($sql);
        $name = $query->row_array();
        return $name['nickname'];
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

//返回ip
function get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}
//根据ip返回所在地址
function GetIpLookup($ip = ''){  
    if(empty($ip)){  
        $ip = GetIp();  
    }  
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
    if(empty($res)){ return false; }  
    $jsonMatches = array();  
    preg_match('#\{.+?\}#', $res, $jsonMatches);  
    if(!isset($jsonMatches[0])){ return false; }  
    $json = json_decode($jsonMatches[0], true);  
    if(isset($json['ret']) && $json['ret'] == 1){  
        $json['ip'] = $ip;  
        unset($json['ret']);  
    }else{  
        return false;  
    }  
    return $json['city'];  
}  

//递归数组，返回权限无限级分类树1
function subtree($arr,$a = '',$id=0,$lev=1) {
    $subs = array(); // 子孙数组
    foreach($arr as $k=>$v) {
        if(!empty($a)){
            if(in_array($v['modular_id'],$a)){
                 $v['true'] = '1';
            }else{
                $v['true'] = '0';
            }   
        }         
        if($v['m_id'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs,subtree($arr,$a,$v['modular_id'],$lev+1));
        }
    }
    return $subs;
}

//爱购分类
function igoCate($data,$parentid=''){
    $CI = &get_instance();
    foreach ($data as $key => $value) {
        if(!empty($value['cate_name'])){
            if($parentid ==''){
                $a = '0';
            }else{
                $a = $parentid;
            }
            $cate = array(
                'catname'=>$value['cate_name'],
                'catid'=>$value['cate_id'],
                'type'=>'2',
                'parentid'=>$a,
            );
           $ret =  $CI->db->insert('hf_mall_category',$cate);
            if(!empty($value['sub_cate'])){
               igoCate($value['sub_cate'],$value['cate_id']);
            }
        }
    }
    if($ret){
        return 1;
    }else{
        return 0;
    }
}


//递归数组，返回爱购分类 无限级分类树1
function igo_cate_list($arr,$id=0,$lev=1) {
    $subs = array(); // 子孙数组
    foreach($arr as $k=>$v) {
      
        if($v['parentid'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs,igo_cate_list($arr,$v['catid'],$lev+1));
        }
    }
    return $subs;
}

 ?>