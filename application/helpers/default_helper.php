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
function search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear){
            $CI = &get_instance();
            
            $res= '';
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where("goods_state",$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->like("title",$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if(empty($state)){
                    $state = '0';
                } 

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('goods_state',$state)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
                
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                  $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
               
            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if(empty($state)){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate','1')->where('storeid',$storeid)->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }
            return $res;
}





 ?>