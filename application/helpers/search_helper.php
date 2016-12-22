<?php 

//管理 员商品搜索
function search_goods($cate,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory){
            $CI = &get_instance();
            if(empty($state)){
                $state = '2';
            }else{
                $state = $state;
            }
            $res= '';
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                 $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                if($state == 2){
                    $state = '0';
                }
                echo "2";
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where("goods_state",$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->like("title",$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                } 

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
                
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                  $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && empty($state) && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
               
            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && !empty($state) && !empty($sear)){
                 if($state == 2){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && empty($state) && empty($sear)){

                 $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }
            return $res;
}






 ?>