<?php 
//商家商品搜索
function search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear,$differentiate){
            $CI = &get_instance();
            $res= '';
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where("goods_state",$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->like("title",$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                  if($state == ''){
                    $state = '0';
                } 

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                  if($state == ''){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && !empty($sear)){
                  if($state == ''){
                    $state = '0';
                }

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->get();
                 $res = $query->result_array();
                
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                  $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->or_like('goods_code',$sear,'both')->like('title','both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && !empty($sear)){
                  if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->or_like('goods_code',$sear,'both')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
               
            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                 $CI->db->select('a.*, b.catname as catname');
                 $CI->db->from('hf_mall_goods a');
                 $CI->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
                 $query = $CI->db->where('differentiate',$differentiate)->where('storeid',$storeid)->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }
            return $res;
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

//帮帮团请求搜索
function search_help_request($userid,$helperid,$state,$sear){
    $CI = &get_instance();
    $res = '';
    if(!empty($userid) && empty($helperid) && $state == '' && empty($sear)){
        $query = $CI->db->where('user_id',$userid)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && !empty($helperid) && $state == '' && empty($sear)){
        $query = $CI->db->where('helper_id',$helperid)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && empty($helperid) && $state != '' && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('state',$state)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && empty($helperid) && $state == '' && !empty($sear)){
        $query = $CI->db->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
        $res = $query->result_array();
    }else
    //二组
    if(!empty($userid) && !empty($helperid) && $state == '' && empty($sear)){
        $query = $CI->db->where('user_id',$userid)->where('helper_id',$helperid)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(!empty($userid) && empty($helperid) && $state != '' && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('user_id',$userid)->where('state',$state)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(!empty($userid) && empty($helperid) && $state == '' && !empty($sear)){
         $query = $CI->db->where('user_id',$userid)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
         $res = $query->result_array();
    }else
    if(empty($userid) && !empty($helperid) && $state != '' && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('helper_id',$helperid)->where('state',$state)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && !empty($helperid) && $state == '' && !empty($sear)){
         $query = $CI->db->where('helper_id',$helperid)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
         $res = $query->result_array();
    }else
    if(empty($userid) && empty($helperid) && $state != '' && !empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('state',$state)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
         $res = $query->result_array();
    }else
    //三组
    if(!empty($userid) && !empty($helperid) && $state != '' && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where("user_id",$userid)->where('helper_id',$helperid)->where('state',$state)->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(!empty($userid) && !empty($helperid) && $state == '' && !empty($sear)){
        $query = $CI->db->where("user_id",$userid)->where('helper_id',$helperid)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(!empty($userid) && empty($helperid) && $state != '' && !empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where("user_id",$userid)->where('state',$state)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && !empty($helperid) && $state != '' && !empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where("helper_id",$helperid)->where('state',$state)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(!empty($userid) && !empty($helperid) && $state != '' && !empty($sear)){
          if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('user_id',$userid)->where("helper_id",$helperid)->where('state',$state)->like('title',$sear,'both')->like('content',$sear,'both')->get('hf_service_request');
        $res = $query->result_array();
    }else
    if(empty($userid) && empty($helperid) && $state == '' && empty($sear)){
        $query = $CI->db->get('hf_service_request');
        $res = $query->result_array();
    }
    return $res;
}


//管理 员商品搜索
function search_goods($cate,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory){
            $CI = &get_instance();
            $res= '';
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                 $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where("goods_state",$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->like("title",$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                } 

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
                
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                  $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else 
            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                $res = $query->result_array();
            }else
            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                 $res = $query->result_array();
               
            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){
                 if($state == ''){
                    $state = '0';
                }
                $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){

                 $CI->db->select('a.*,b.store_name,c.catname');
                $CI->db->from('hf_mall_goods as a');
                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
                 $query = $CI->db->order_by('create_time','desc')->order_by('create_time','desc')->get();
                  $res = $query->result_array();
            }
            return $res;
}

//管理员订单搜索
function order_search($state,$startPrice,$endPrice,$buyer,$seller,$time){
      $CI = &get_instance();
      $res = '';
      if(!empty($state) && empty($startPrice) && empty($buyer) && empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && empty($buyer) && empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && empty($startPrice) && !empty($buyer) && empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('buyer',$buyer)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && empty($startPrice) && empty($buyer) && !empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('seller',$seller)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();

      }else
      if(empty($state) && empty($startPrice) && empty($buyer) && empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      //两组
      if(!empty($state) && !empty($startPrice) && empty($buyer) && empty($seller) && empty($time)){
                 $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');   
            $query = $CI->db->where('order_status',$state)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && !empty($buyer) && empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && empty($buyer) && empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where("order_status",$state)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && !empty($buyer) && empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
             $query = $CI->db->where('buyer',$buyer)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
       if(empty($state) && !empty($startPrice) && empty($buyer) && empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
      }else
       if(empty($state) && empty($startPrice) && !empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('buyer',$buyer)->where('seller',$seller)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
       if(empty($state) && empty($startPrice) && !empty($buyer) && empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('buyer',$buyer)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
       if(empty($state) && empty($startPrice) && empty($buyer) && !empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('seller',$seller)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      //三组
       if(!empty($state) && !empty($startPrice) && !empty($buyer) && empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();

      }else
      if(!empty($state) && !empty($startPrice) && empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && !empty($startPrice) && empty($buyer) && empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
             $query = $CI->db->where('order_status',$state)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && !empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('buyer',$buyer)->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && !empty($buyer) && empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
           $query = $CI->db->where('buyer',$buyer)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && empty($startPrice) && !empty($buyer) && !empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('buyer',$buyer)->where('seller',$seller)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && empty($buyer) && !empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && !empty($buyer) && !empty($seller) && empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && empty($buyer) && !empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && !empty($buyer) && empty($seller) && !empty($time)){
             $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      //四组
      if(!empty($state) && !empty($startPrice) && !empty($buyer) && !empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && !empty($startPrice) && !empty($buyer) && empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(empty($state) && !empty($startPrice) && !empty($buyer) && !empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && empty($startPrice) && !empty($buyer) && !empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('buyer',$buyer)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && !empty($startPrice) && empty($buyer) && !empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }else
      if(!empty($state) && !empty($startPrice) && !empty($buyer) && !empty($seller) && !empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->where('seller',$seller)->where('amount >=',$startPrice)->where('amount <=',$endPrice)->like('a.create_time',$time,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();

      }else
      if(empty($state) && empty($startPrice) && empty($buyer) && empty($seller) && empty($time)){
            $CI->db->select('a.*,b.store_name,c.username');
            $CI->db->from('hf_mall_order as a');
            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');
            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $query = $CI->db->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
      }
      return $res;
}


//管理员搜索商家
function search_store_list($yetai,$state,$floor,$berth,$sear){
    $CI = &get_instance();
  
    $res= '';
    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){
        $query = $CI->db->where('commercial_type_name',$yetai)->order_by('create_time','desc')->get('hf_shop_store');
        $res = $query->result_array();
    }else
    if(empty($yetai) && $state != '' && empty($floor) && empty($berth) && empty($sear)){
        if($state == ''){
            $state = '0';
        }
         $query = $CI->db->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');
        $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){
         $query = $CI->db->where('floor_name',$floor)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && empty($sear)){
        $query = $CI->db->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){
        $query = $CI->db->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    //二组
    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yetai)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){
        $query = $CI->db->where('commercial_type_name',$yetai)->where('floor_name',$floor)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && empty($floor) && !empty($berth) && empty($sear)){
        $query = $CI->db->where('commercial_type_name',$yetai)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){
        $query = $CI->db->where('commercial_type_name',$yetai)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('floor_name',$floor)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('door_no',$berth)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){
        if($state == ''){
            $state = '0';
        }
        $query = $CI->db->where('state',$state)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && empty($sear)){

        $query = $CI->db->where('floor_name',$floor)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){
        $query = $CI->db->where('door_no',$berth)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
     }else
    // //三组
    if(!empty($yetai) && $state != '' && !empty($floor) && empty($berth) && empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yetai)->where('state',$state)->where('floor_name',$floor)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state != '' && empty($floor) && !empty($berth) && empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yetai)->where('state',$state)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state != '' && empty($floor) && empty($berth) && !empty($sear)){
         if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yetai)->where('state',$state)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && empty($sear)){
         if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('floor_name',$floor)->where('state',$state)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state != '' && !empty($floor) && empty($berth) && !empty($sear)){
         if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('floor_name',$floor)->where('state',$state)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state != '' && empty($floor) && !empty($berth) && !empty($sear)){
         if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('door_no',$berth)->where('state',$state)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && !empty($sear)){
       
        $query = $CI->db->where('floor_name',$floor)->where('door_no',$berth)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){
        
        $query = $CI->db->where('commercial_type_name',$yetai)->where('door_no',$berth)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && !empty($floor) && empty($berth) && !empty($sear)){
         
        $query = $CI->db->where('commercial_type_name',$yeai)->where('floor_name',$floor)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    //sizu
    if(!empty($yetai) && $state != '' && !empty($floor) && empty($berth) && !empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yeai)->where('state',$state)->where('floor_name',$floor)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('commercial_type_name',$yeai)->where('state',$state)->where('floor_name',$floor)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && !empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('door',$berth)->where('state',$state)->where('floor_name',$floor)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && !empty($sear)){
        if($state = ''){
            $state = '0';
        }
         $query = $CI->db->where('door',$berth)->where('commercial_type_name',$yetai)->where('floor_name',$floor)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state != '' && empty($floor) && !empty($berth) && !empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('door',$berth)->where('commercial_type_name',$yetai)->where('state',$state)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(!empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && !empty($sear)){
        if($state = ''){
            $state = '0';
        }
        $query = $CI->db->where('door',$berth)->where('commercial_type_name',$yetai)->where('state',$state)->where('floor_name',$floor)->like('store_name',$sear,'both')->or_like('barnd_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }else
    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){
        $query = $CI->db->order_by('create_time','desc')->get('hf_shop_store');
         $res = $query->result_array();
    }
    return $res;
}


 ?>