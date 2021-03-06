<?php 

/**
*    公用函数
*/
//两个时间之间的日期
function prDates($start,$end){ // 两个日期之间的所有日期  
    $dt_start = strtotime($start);  
    $dt_end = strtotime($end);  
  
    while ($dt_start<=$dt_end){  
        $date[]['Ymdate'] = date('Y-m-d',$dt_start)."\n";  
        $dt_start = strtotime('+1 day',$dt_start);  
    } 
    return $date; 
}  
//返回时间段内数据
function retDateList($where,$de,$id,$table,$create,$time,$endtime){
    $CI = &get_instance();
    $sql = "select count(*) from " . $table." WHERE ".$where.$de.$id.' and '.$create." BETWEEN '".$time."' AND '".$endtime."'";
    $query = $CI->db->query($sql);
    $res = $query->row_array();
    return $res['count(*)'];

}

//
function get_mobile_area($mobile)
{
    $sms = array('province' => '', 'supplier' => '');    //初始化变量
    //根据淘宝的数据库调用返回值
    $url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=" . $mobile . "&t=" . time();

    $res = file_get_contents($url);
    $res = trim(explode('=', $res)[1]);
    $res = iconv('gbk', 'utf-8', $res);
    $res = str_replace("'", '"', $res);
    $res = preg_replace('/(\w+):/is', '"$1":', $res);

    return json_decode($res, true);
}

//返回用户分析数据
// function ToDayselectList($table,$time){
//     $CI = &get_instance();
//     $sql = "SELECT count(*) FROM ".$table." WHERE  TO_DAYS( NOW( ) ) - TO_DAYS( ".$time.") <= 1";
//     $query = $CI->db->query($sql);
//     $res = $query->row_array();
//     return $res['count(*)'];
// }
// function ZhouselectList($table,$time){
//     $CI = &get_instance();
//     $sql = "SELECT count(*) FROM ".$table." WHERE YEARWEEK(date_format(".$time.",'%Y-%m-%d')) = YEARWEEK(now())";
//     $query = $CI->db->query($sql);
//     $res = $query->row_array();
//     return $res['count(*)'];
// }
// function YueselectList($table,$time){
//     $CI = &get_instance();
//     $sql = "SELECT count(*) FROM ".$table." where DATE_FORMAT( ".$time.", '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
//     $query = $CI->db->query($sql);
//     $res = $query->row_array();
//     return $res['count(*)'];
// }

//返回帖子问答
function DayNewselectList($where,$de,$type,$table,$time){
    $CI = &get_instance();
    $sql = "SELECT count(*) FROM ".$table." WHERE ".$where .$de.$type." and to_days(".$time.") = to_days(now());";
    $query = $CI->db->query($sql);
    $res = $query->row_array();
    return $res['count(*)'];
}
function ToDayNewselectList($where,$de,$type,$table,$time){
    $CI = &get_instance();
    $sql = "SELECT count(*) FROM ".$table." WHERE ".$where .$de.$type." and TO_DAYS( NOW( ) ) - TO_DAYS( ".$time.") = 1";
    $query = $CI->db->query($sql);
    $res = $query->row_array();
    return $res['count(*)'];
}
function ZhouNewselectList($where,$de,$type,$table,$time){
    $CI = &get_instance();
    $sql = "SELECT count(*) FROM ".$table." WHERE ".$where .$de.$type." and create_time >= DATE_SUB(CURDATE(),INTERVAL WEEKDAY(CURDATE()) DAY)";
    // SELECT create_time from hf_user_member where gid='5' and create_time >= DATE_SUB(CURDATE(),INTERVAL WEEKDAY(CURDATE()) DAY);  

    $query = $CI->db->query($sql);
    $res = $query->row_array();
    return $res['count(*)'];
}
function YuesNewelectList($where,$de,$type,$table,$time){
    $CI = &get_instance();
    $sql = "SELECT count(*) FROM ".$table." where ".$where .$de.$type." and DATE_FORMAT( ".$time.", '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
    $query = $CI->db->query($sql);
    $res = $query->row_array();
    return $res['count(*)'];
}
//f返回
function get_invitation($id){
    $CI = &get_instance();
    $sql = "SELECT * FROM hf_system_invitation_record where code_id = '$id'";
    $query = $CI->db->query($sql);
    $name = $query->result_array();
    return count($name);
}
//获取配置
//获取配置
function get_option($name = '') {
    $CI = &get_instance();
    $sql = "select value from hf_friends_system where name='$name'";
    $query = $CI->db->query($sql);
    $value = $query->row_array();

    if ($value) {
        return $value['value'];
    }
    return NULL;
}
//获取配置
function get_optionName($name = '') {
    $CI = &get_instance();
    $sql = "select remarks from hf_friends_system where name='$name'";
    $query = $CI->db->query($sql);
    $value = $query->row_array();

    if ($value) {
        return $value['remarks'];
    }
    return NULL;
}


//保留两位小数   不四舍五入
function floor2($n){
  return (float)preg_replace('/^(\d+)(?:(\.\d{1,2})\d+)?$/','$1$2',$n);     
}

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
//获取用户名
function userInfo($user_id){
    $CI = &get_instance();
    $sql = "SELECT user_id,username,phone,create_time FROM hf_user_member where user_id = '$user_id'";
    $query = $CI->db->query($sql);
    $name = $query->row_array();
    return $name;
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

    function insert_db($goods_list=''){
        $CI = &get_instance();
        if(!empty($goods_list)){
            foreach($goods_list as $k=>$val){
                if($val['isdown'] =='1'){
                    $pic = explode(',',$val['pic_url']['pic_url']);
                   
                    $val['thumb'] = str_replace('./','/',$pic[0]);
                    $val['differentiate'] = '3';
                    $val['categoryid'] = $val['category_id'];
                    $val['originalprice'] = $val['original_price']+$val['sellprice']*0.1;
                    $val['price'] = $val['sellprice']+$val['sellprice']*0.1;
                    $val['content'] = $val['remark'];
                    $val['tax_rate'] = $val['tax_rate']/100;
                    unset($val['remark'],$val['pic_url'],$val['sellprice'],$val['category_id'],$val['original_price'],$val['isdown'],$val['shop_status']);
                 
                   $CI->db->insert('hf_mall_goods_igo',$val);
                   sleep(2);
                }
            }
            echo "1";  
        }else{
            echo "1";
        }
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

// function curl_post_token($url, $post){
//     $options = array(
//         CURLOPT_RETURNTRANSFER =>true,
//         CURLOPT_HEADER =>false,
//         CURLOPT_POST =>true,
//         CURLOPT_POSTFIELDS => $post,
//     );
//     $ch = curl_init($url);
//     curl_setopt_array($ch, $options);
//     curl_setopt($ch, CURLOPT_HEADER, 1);
//     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
//     $result = curl_exec($ch);
//     if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
// 	    $header_size	= curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//         $headers		=substr(substr($result, 79, $header_size),0,148);
//         $body		= substr($result, $header_size);
//     }
//     curl_close($ch);
//     return $headers;
// }

//模拟post 登陆app
function curl_post_token($url, $post){
    $options = array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_HEADER =>1,
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => $post,
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
    $result = curl_exec($ch);
    $arr = explode("\r\n", $result);
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
	    $header_size	= curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers		=  trim(substr($arr['6'], 6));
        $body		= substr($result, $header_size);
    }
    curl_close($ch);
    return $headers;
}

function curl_post_express($header,$url, $post){
    $ch = curl_init();
    $res= curl_setopt ($ch, CURLOPT_URL,$url);
  //  return($res);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    $result = curl_exec ($ch);
    curl_close($ch);
    if ($result == NULL) {
    return 0;
    }
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

function deep_in_array($value, $array) {   
    foreach($array as $item) {   

        if(!is_array($item)) {   
            if ($item == $value) {  
                return true;  
            } else {  
                continue;   
            }  
        }   
            
        if(in_array($value, $item)) {  
            return true;      
        } else if(deep_in_array($value, $item)) {  
            return true;      
        }  
    }   
    return false;   
}

//爱购分类
function igoCate($data,$parentid=''){
    $CI = &get_instance();
    foreach ($data as $key => $value) {
        if(!empty($value['cate_name'])){
            $query = $CI->db->where('catid',$value['cate_id'])->get('hf_mall_category_igo');
            $res = $query->row_array();    
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
            if(!empty($res)){
               $ret =  $CI->db->where('catid',$value['cate_id'])->update('hf_mall_category_igo',$cate);
            }else{
               $ret =  $CI->db->insert('hf_mall_category_igo',$cate);
            }
        //    $ret =  $CI->db->insert('hf_mall_category_igo',$cate);
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

//返回发现模块标签名称
function ret_find_tagName($tag_id){
       $CI = &get_instance();
       $where['tag_id'] = $tag_id;
       $query = $CI->db->where($where)->get('hf_friend_news_tags');
       $res = $query->row_array();
       return $res['tagName'];
}




function arrayToXml($arr){ 
    $xml = "<xml>"; 
    foreach ($arr as $key=>$val){ 
    if(is_array($val)){ 
    $xml.="<".$key.">".arrayToXml($val)."</".$key.">"; 
    }else{ 
    $xml.="<".$key.">".$val."</".$key.">"; 
    } 
    } 
    $xml.="</xml>"; 
    return $xml; 
}

function xmlToArray($xml){ 
 
 //禁止引用外部xml实体 
 
libxml_disable_entity_loader(true); 
 
$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
 
$val = json_decode(json_encode($xmlstring),true); 
 
return $val; 
 
} 


//修改游戏奖品几率
function edit_game_prize($gameid){
        $CI = &get_instance();
        $query = $CI->db->where('gameId',$gameid)->order_by('stock','asc')->get('hf_game_prize');
        $list = $query->result_array();
        $stock = 0;
        //总库存
        foreach ($list as $key => $value) {
            $stock = $stock + $value['stock'];
        }

        $e = '1000000';

        //几率
        foreach ($list as $key => $value) {
            if($key == '0'){
                $list[$key]['RandomMax'] = '999999';
                $list[$key]['probability'] = $list[$key]['stock']/$stock;
                $list[$key]['RandomMin'] = $e-$list[$key]['probability']*1000000;
            }else{
                
                $list[$key]['RandomMax'] = $list[$key-1]['RandomMin']-1;
                $list[$key]['probability'] = $list[$key]['stock']/$stock;
                $list[$key]['RandomMin'] = $e-$list[$key]['probability']*1000000;
            }
            // var_dump($list[$key]['RandomMin']);
            if($key+1 == count($list)){
                $list[$key]['RandomMin'] = '1';
            }
            $ci = $CI->db->where('id',$value['id'])->update('hf_game_prize',$list[$key]);
        }

        echo "1";
}

//返回coupon 名称   
function ret_coupon_name($id){
        $CI = &get_instance();
        $query = $CI->db->where('id',$id)->get('hf_shop_coupon');
        $res = $query->row_array();
        return $res['title'].'-'.$res['name'];
}
//返回couponid
function retCouponId($userCouponid){
    $CI = &get_instance();
    $query = $CI->db->where('user_coupon_id',$userCouponid)->get('hf_user_coupon');
    $res = $query->row_array();
    return $res['store_coupon_id'];
}

//返回奖品抽中数
function select_prizeNum($id){
    $CI = &get_instance();
    $query = $CI->db->where('prizeId',$id)->get('hf_game_wining_history');
    $res = $query->result_array();
    return count($res);
}
//返回商家名称
function get_store_name($id){
    $CI = &get_instance();
    $query = $CI->db->where('store_id',$id)->get('hf_shop_store');
    $res = $query->row_array();
    return $res['store_name'];
}


 ?>