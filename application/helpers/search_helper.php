<?php 
//搜索用户返回数据
function selectMember($gender,$t,$e,$sear){
        $CI = &get_instance();

        $res= '';
        if(!empty($gender) && empty($t) && empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && !empty($t) && empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && empty($t) && !empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && !empty($t) && empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->where('gender',$gender)->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && empty($t) && !empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && !empty($t) && !empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && !empty($t) && !empty($sear)){
             $CI->db->select('user_id');
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('create_time >=',$t)->where('create_time <=',$e)->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();

        }elseif(empty($gender) && empty($t) && empty($sear)){
            $CI->db->select('user_id');
            $query = $CI->db->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            $res = $query->result_array();
        }
        return $res;
}
function selectMember_page($gender,$t,$e,$sear,$page,$size){
        $CI = &get_instance();

        $res= '';
        if(!empty($gender) && empty($t) && empty($sear)){
            $query = $CI->db->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && !empty($t) && empty($sear)){
            $query = $CI->db->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && empty($t) && !empty($sear)){
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && !empty($t) && empty($sear)){
            $query = $CI->db->where('gender',$gender)->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && empty($t) && !empty($sear)){
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(empty($gender) && !empty($t) && !empty($sear)){
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('create_time >=',$t)->where('create_time <=',$e)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }elseif(!empty($gender) && !empty($t) && !empty($sear)){
            $query = $CI->db->like('nickname',$sear)->or_like('phone',$sear)->where('create_time >=',$t)->where('create_time <=',$e)->where('gender',$gender)->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();

        }elseif(empty($gender) && empty($t) && empty($sear)){
            $query = $CI->db->where('gid','5')->order_by('create_time','desc')->limit($page,$size)->get('hf_user_member');
            $res = $query->result_array();
        }
        return $res;
}

//搜索问答问题
function searchQuestion($typeId,$faqsType,$questionStates,$sear,$t,$e){
        $CI = &get_instance();
        $res= '';

        if(!empty($faqsType) && empty($questionStates) && empty($sear) && empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            echo "2";
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && !empty($sear) && empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        //2
        }else if(!empty($faqsType) && !empty($questionStates) && empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && !empty($sear) && empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && !empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && !empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();

        //3
        }else if(!empty($faqsType) && !empty($questionStates) && !empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.questionStates',$questionStates)->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && !empty($questionStates) && empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && !empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && !empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        //4
        }else if(!empty($faqsType) && !empty($questionStates) && !empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && empty($sear) && empty($t)){

            $CI->db->select('a.*,b.nickname,c.name,c.id');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->order_by('a.create_time','desc')->get();
            $res = $query->result_array();
        }
        return $res;
}
function searchQuestion_page($typeId,$faqsType,$questionStates,$sear,$t,$e,$page,$size){
        $CI = &get_instance();
        $res= '';

        if(!empty($faqsType) && empty($questionStates) && empty($sear) && empty($t)){

            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && !empty($sear) && empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        //2
        }else if(!empty($faqsType) && !empty($questionStates) && empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && !empty($sear) && empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && !empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.questionStates',$questionStates)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && !empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();

        //3
        }else if(!empty($faqsType) && !empty($questionStates) && !empty($sear) && empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'both')->where('a.questionStates',$questionStates)->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && !empty($questionStates) && empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->where('a.questionStates',$questionStates)->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(!empty($faqsType) && empty($questionStates) && !empty($sear) && !empty($t)){
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.faqsType',$faqsType)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && !empty($questionStates) && !empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        //4
        }else if(!empty($faqsType) && !empty($questionStates) && !empty($sear) && !empty($t)){
            if($questionStates == '2'){
                $questionStates = '0';
            }
            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->like('a.content',$sear,'borh')->where('a.questionStates',$questionStates)->where('a.create_time >=',$t)->where('a.create_time <=',$e)->where('a.faqsType',$faqsType)->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }else if(empty($faqsType) && empty($questionStates) && empty($sear) && empty($t)){

            $CI->db->select('a.*,b.nickname,c.name');
            $CI->db->from('hf_faqs_group as c');
            $CI->db->join('hf_friends_news as a', 'a.faqsType = c.id','left');
            $CI->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
            $query = $CI->db->where('typeId','2')->order_by('a.create_time','desc')->limit($page,$size)->get();
            $res = $query->result_array();
        }
        return $res;
}




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



                 $sql = "SELECT a.*,b.catid from hf_mall_goods as a,hf_mall_category as b where a.categoryid = b.catid and storeid = '$storeid' and differentiate = '$differentiate' and concat(title, goods_code) like '%$sear%'";

                 $query = $CI->db->query($sql);

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




//管理 员商品搜索

function search_goods($diff,$cate,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory){

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
function search_goods_page($diff,$cate,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory,$page,$size){

            $CI = &get_instance();

            $res= '';

            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('categoryid',$cate)->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else 

            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){

                 $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where("goods_state",$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->like("title",$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(!empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                 $query = $CI->db->where('categoryid',$cate)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(!empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('categoryid',$cate)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){



                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                 $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else 

            if(empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){



                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                $res = $query->result_array();

            }else 

            if(empty($cate) && empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){



                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('goods_state',$state)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                $res = $query->result_array();

            }else

            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && empty($sear)){



                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

            }else

            if(!empty($cate) && !empty($startPrice) && empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                 $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

                

            }else 

            if(empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                  $query = $CI->db->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                 $query = $CI->db->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                $res = $query->result_array();

            }else

            if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state == '' && !empty($sear)){

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                $query = $CI->db->where('categoryid',$cate)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->where('goods_state',$state)->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('amount >=',$startRepertory)->where('amount <=',$endRepertory)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

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

                $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                 $res = $query->result_array();

               

            }else if(!empty($cate) && !empty($startPrice) && !empty($startRepertory) && $state != '' && !empty($sear)){

                 if($state == ''){

                    $state = '0';

                }

                $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                 $query = $CI->db->where('categoryid',$cate)->where('goods_state',$state)->where('price >=',$startPrice)->where('price <=',$endPrice)->where('price >=',$startPrice)->where('price <=',$endPrice)->like('title',$sear,'both')->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                  $res = $query->result_array();

            }else if(empty($cate) && empty($startPrice) && empty($startRepertory) && $state == '' && empty($sear)){



                 $CI->db->select('a.*,b.store_name,c.catname');

                $CI->db->from('hf_mall_goods as a');

                $CI->db->join('hf_shop_store as b','a.storeid = b.store_id','left');

                $CI->db->join('hf_mall_category as c','a.categoryid = c.catid','left');

                 $query = $CI->db->order_by('create_time','desc')->order_by('create_time','desc')->limit($page,$size)->get();

                  $res = $query->result_array();

            }

            return $res;

}


//管理员订单搜索

function order_search($state,$buyer,$seller,$time,$endtime,$type,$orderid){

      $CI = &get_instance();

      $res = '';

      if(!empty($state) && empty($buyer) && empty($seller) && empty($time) && empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(empty($state) && !empty($buyer) && empty($seller) && empty($time) && empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('a.buyer',$buyer)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(empty($state) && empty($buyer) && !empty($seller) && empty($time) && empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('seller',$seller)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();



      }else
      if(empty($state) && empty($buyer) && empty($seller) && empty($time) && !empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('a.order_type',$type)->where('a.order_id',$orderid)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
      }else

      if(empty($state) && empty($buyer) && empty($seller) && !empty($time) && empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      //两组

    

      if(!empty($state) && !empty($buyer) && empty($seller) && empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(!empty($state) &&  empty($buyer) && !empty($seller) && empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(!empty($state) &&  empty($buyer) && empty($seller) && !empty($time)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where("order_status",$state)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      

       if(empty($state) &&  !empty($buyer) && !empty($seller) && empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('buyer',$buyer)->where('seller',$seller)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

       if(empty($state) &&  !empty($buyer) && empty($seller) && !empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('buyer',$buyer)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

       if(empty($state) && empty($buyer) && !empty($seller) && !empty($time)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('seller',$seller)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      //三组

    

      if(empty($state) && !empty($buyer) && !empty($seller) && !empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('buyer',$buyer)->where('seller',$seller)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(!empty($state) && empty($buyer) && !empty($seller) && !empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(!empty($state) && !empty($buyer) && !empty($seller) && empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(!empty($state) && !empty($buyer) && empty($seller) && !empty($time)){

             $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('buyer',$buyer)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      //四组

      if(!empty($state) && !empty($buyer) && !empty($seller) && !empty($time)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->where('order_status',$state)->where('seller',$seller)->where('buyer',$buyer)->where('a.create_time >',$time)->where('a.create_time <',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }else

      if(empty($state) && empty($buyer) && empty($seller) && empty($time) && empty($orderid)){

            $CI->db->select('a.*,b.store_name,c.nickname');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');

            $query = $CI->db->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

      }

      return $res;

}


//管理员搜索商家

function search_store_list($yetai,$state,$floor,$berth,$sear,$type){

    $CI = &get_instance();

  

    $res= '';

    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->order_by('create_time','desc')->get('hf_shop_store');

        $res = $query->result_array();

    }else

    if(empty($yetai) && $state != '' && empty($floor) && empty($berth) && empty($sear)){

        if($state == ''){

            $state = '0';

        }

         $query = $CI->db->where('store_distinction',$type)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');

        $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){

         $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){

        $query = $CI->db->like('store_name',$sear,'both')->where('store_distinction',$type)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    //二组

    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){

        if($state == ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('city',$floor)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && empty($floor) && !empty($berth) && empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && !empty($floor) && empty($berth) && empty($sear)){

        if($state == ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){

        if($state == ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('door_no',$berth)->where('state',$state)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && !empty($sear)){

        if($state == ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('state',$state)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && empty($sear)){



        $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->where('door_no',$berth)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

     }else

    // //三组

    if(!empty($yetai) && $state != '' && !empty($floor) && empty($berth) && empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('state',$state)->where('city',$floor)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state != '' && empty($floor) && !empty($berth) && empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('state',$state)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state != '' && empty($floor) && empty($berth) && !empty($sear)){

         if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('state',$state)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && empty($sear)){

         if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->where('state',$state)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state != '' && !empty($floor) && empty($berth) && !empty($sear)){

         if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->where('state',$state)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state != '' && empty($floor) && !empty($berth) && !empty($sear)){

         if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('door_no',$berth)->where('state',$state)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && !empty($sear)){

       

        $query = $CI->db->where('store_distinction',$type)->where('city',$floor)->where('door_no',$berth)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && empty($floor) && !empty($berth) && !empty($sear)){

        

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yetai)->where('door_no',$berth)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && !empty($floor) && empty($berth) && !empty($sear)){

         

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yeai)->where('city',$floor)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    //sizu

    if(!empty($yetai) && $state != '' && !empty($floor) && empty($berth) && !empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yeai)->where('state',$state)->where('city',$floor)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('commercial_type_name',$yeai)->where('state',$state)->where('city',$floor)->where('door_no',$berth)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && !empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('door',$berth)->where('state',$state)->where('city',$floor)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state == '' && !empty($floor) && !empty($berth) && !empty($sear)){

        if($state = ''){

            $state = '0';

        }

         $query = $CI->db->where('store_distinction',$type)->where('door',$berth)->where('commercial_type_name',$yetai)->where('city',$floor)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state != '' && empty($floor) && !empty($berth) && !empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('door',$berth)->where('commercial_type_name',$yetai)->where('state',$state)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(!empty($yetai) && $state != '' && !empty($floor) && !empty($berth) && !empty($sear)){

        if($state = ''){

            $state = '0';

        }

        $query = $CI->db->where('store_distinction',$type)->where('door',$berth)->where('commercial_type_name',$yetai)->where('state',$state)->where('city',$floor)->like('store_name',$sear,'both')->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }else

    if(empty($yetai) && $state == '' && empty($floor) && empty($berth) && empty($sear)){

        $query = $CI->db->where('store_distinction',$type)->order_by('create_time','desc')->get('hf_shop_store');

         $res = $query->result_array();

    }

    return $res;

}


//财务导出订单

function moll_order_list($storeid,$time,$endtime,$state){

      $CI = &get_instance();

      $res= '';

      if(!empty($time) && empty($state)){
        if($storeid == '-2'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type !=','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

        }elseif($storeid == '-1'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }else{
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }
      }elseif(empty($time) && !empty($state)){
        if($storeid == '-2'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type !=','0')->where('a.order_status',$state)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

        }elseif($storeid == '-1'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.order_status',$state)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }else{
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.order_status',$state)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }
      }elseif(!empty($time) && !empty($state)){
        if($storeid == '-2'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type !=','0')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

        }elseif($storeid == '-1'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }else{
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }
      }elseif(empty($time) && empty($state)){
        if($storeid == '-2'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type !=','0')->order_by('a.create_time','desc')->get();

            $res = $query->result_array();

        }elseif($storeid == '-1'){
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }else{
            $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

            $CI->db->from('hf_mall_order as a');

            $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

            $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
            $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
            $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->order_by('a.create_time','desc')->get();

            $res = $query->result_array();
        }
      }
      // elseif(!empty($time) && empty($state)){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();

      // }elseif(empty($storeid) && empty($time) && !empty($state)){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.order_status',$state)->order_by('a.create_time','desc')->get();
      //       $res = $query->result_array();
      //   //laingge
      // }elseif(!empty($storeid) && !empty($time) && empty($state)){
      //   if($storeid == '-1'){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }else{
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }
      // }if(!empty($storeid) && empty($time) && !empty($state)){
      //    if($storeid == '-1'){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.order_status',$state)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }else{
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.order_status',$state)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }
      // }if(empty($storeid) && !empty($time) && !empty($state)){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_status',$state)->order_by('a.create_time','desc')->get();
      //       $res = $query->result_array();
      // }if(!empty($storeid) && !empty($time) && !empty($state)){

      //   if($storeid == '-1'){
      //       $CI->db->select('a.*,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');
      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.order_type','0')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }else{
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->where('a.seller',$storeid)->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      //   }
      // }if(empty($storeid) && empty($time) && empty($state)){
      //       $CI->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

      //       $CI->db->from('hf_mall_order as a');

      //       $CI->db->join('hf_shop_store as b','a.seller = b.store_id','left');

      //       $CI->db->join('hf_user_member as c','a.buyer = c.user_id','left');
      //       $CI->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
           
      //       $query = $CI->db->where('order_status !=','1')->order_by('a.create_time','desc')->get();

      //       $res = $query->result_array();
      // }

      return $res;



}
function store_order_list($storeid,$time,$endtime,$type){

      $CI = &get_instance();

      $res= '';

      if(empty($time) && empty($type)){

            if($storeid == '0'){

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `order_type` != '0'  ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);

                $res = $query->result_array();

            }else{

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `seller` = '$storeid' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);
                $res = $query->result_array();

            }

      }else if(!empty($time) && empty($type)){

            if($storeid == '0'){

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `order_type` != '0' AND `a`.`create_time` >= '$time' AND `a`.`create_time` <= '$endtime' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);

                $res = $query->result_array();

            }else{

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `seller` = '$storeid' AND `a`.`create_time` >= '$time' AND `a`.`create_time` <= '$endtime'  ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);                

                $res = $query->result_array();

            }



      }else if(empty($time) && !empty($type)){

            if($storeid == '0'){

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `order_type` != '0' AND `a`.`order_type` = '$type' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);

                $res = $query->result_array();

            }else{

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `seller` = '$storeid' AND `a`.`order_type` = '$type' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);                

                $res = $query->result_array();

            }
      }else if(!empty($time) && !empty($type)){

            if($storeid == '0'){

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `order_type` != '0' AND `a`.`order_type` = '$type' AND `a`.`create_time` >= '$time' AND `a`.`create_time` <= '$endtime' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);

                $res = $query->result_array();

            }else{

                $sql = "SELECT `a`.*, `b`.`store_name` FROM `hf_mall_order` as `a` LEFT JOIN `hf_shop_store` as `b` ON `a`.`seller` = `b`.`store_id` WHERE `order_status` != '1' AND `seller` = '$storeid' AND `a`.`order_type` = '$type' AND `a`.`create_time` >= '$time' AND `a`.`create_time` <= '$endtime' ORDER BY `create_time` DESC";

                $query = $CI->db->query($sql);                

                $res = $query->result_array();
                
            }
      }



      return $res;



}


//交友会员搜索
function friends_member_search($age,$gender,$startTime,$endTime,$sear){
    $CI = &get_instance();
    $res= '';

    //1
    if(!empty($age) && empty($startTime) && empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->get('hf_user_member');
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->where("gender",$gender)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->where("gender",$gender)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->where("gender",$gender)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->where("gender",$gender)->get('hf_user_member');
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && !empty($startTime) && empty($sear)){
        if($gender == ''){
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' AND `create_time` between '$startTime' and '$endTime'";
            $query = $CI->db->query($sql);
            $res = $query->result_array();
        }else{
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender = '$gender' AND `create_time` between '$startTime' and '$endTime'";
            $query = $CI->db->query($sql);
            $res = $query->result_array();

        }

    }else if(empty($age) && empty($startTime) && !empty($sear)){
        if($gender == ''){
            $query = $CI->db->where('gid','5')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
        }else{
            $query = $CI->db->where('gid','5')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->where("gender",$gender)->get('hf_user_member');
            $res = $query->result_array();
        }
    //2
    }else if(!empty($age) && !empty($startTime) && empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);                
                $res = $query->result_array();
            }else if($age == '3'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);  
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '45' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);  
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                 $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'";
                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '46' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }

        }

    }else if(!empty($age) && empty($startTime) && !empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->get('hf_user_member');
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && !empty($startTime) && !empty($sear)){
        if($gender == ''){
             $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' AND `create_time` between '$startTime' and '$endTime'";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
          
        }else{
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' AND `create_time` between '$startTime' and '$endTime'";

            $query = $CI->db->query($sql);
            $res = $query->result_array();
        
        }
    //3
    }else if(!empty($age) && !empty($startTime) && !empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
              $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '45' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
              $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '45' AND `create_time` between '$startTime' and '$endTime'";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && empty($startTime) && empty($sear)){
        if($gender == ''){
            $CI->db->select('user_id');
            $query = $CI->db->where('gid','5')->where('gender','1')->or_where('gender','2')->get('hf_user_member');
            $res = $query->result_array();
        }else{
            $CI->db->select('user_id');
            $query = $CI->db->where('gid','5')->where('gender',$gender)->get('hf_user_member');
            $res = $query->result_array();
        }
    }
    return $res;

}
function friends_member_search_page($age,$gender,$startTime,$endTime,$sear,$size,$page){
    $CI = &get_instance();
    $res= '';

    //1
    if(!empty($age) && empty($startTime) && empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->where("gender",$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->where("gender",$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->where("gender",$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->where("gender",$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && !empty($startTime) && empty($sear)){
        if($gender == ''){
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";
            $query = $CI->db->query($sql);
            $res = $query->result_array();
        }else{
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender = '$gender' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";
            $query = $CI->db->query($sql);
            $res = $query->result_array();

        }

    }else if(empty($age) && empty($startTime) && !empty($sear)){
        if($gender == ''){
            $query = $CI->db->where('gid','5')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
        }else{
            $query = $CI->db->where('gid','5')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->where("gender",$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
            $res = $query->result_array();
        }
    //2
    }else if(!empty($age) && !empty($startTime) && empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);                
                $res = $query->result_array();
            }else if($age == '3'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);  
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and age >= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);  
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                 $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";
                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and age >= '46' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
            }

        }

    }else if(!empty($age) && empty($startTime) && !empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $query = $CI->db->where('gid','5')->where('age >=','18')->where('age <=','25')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '2'){
                $query = $CI->db->where('gid','5')->where('age >=','26')->where('age <=','35')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '3'){
                $query = $CI->db->where('gid','5')->where('age >=','36')->where('age <=','45')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }else if($age == '4'){
                $query = $CI->db->where('gid','5')->where('age >=','46')->where("gender",$gender)->like('nickname',$sear,'both')->or_like('phone',$sear,'both')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && !empty($startTime) && !empty($sear)){
        if($gender == ''){
             $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

                $query = $CI->db->query($sql);
                $res = $query->result_array();
          
        }else{
            $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

            $query = $CI->db->query($sql);
            $res = $query->result_array();
        
        }
    //3
    }else if(!empty($age) && !empty($startTime) && !empty($sear)){
        if($gender == ''){
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
              $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and nickname like '%$sear%' or phone like '%$sear%' and age >= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }
        }else{
            if($age == '1'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '18' and age <= '25' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '2'){
              $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '26' and age <= '35' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '3'){
               $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '36' and age <= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }else if($age == '4'){
                $sql = "SELECT * FROM `hf_user_member` WHERE `gid` = '5' and gender='$gender' and nickname like '%$sear%' or phone like '%$sear%' and age >= '45' AND `create_time` between '$startTime' and '$endTime'order by savePhotoTime desc limit $page,$size";

               $query = $CI->db->query($sql);
                $res = $query->result_array();
            }

        }

    }else if(empty($age) && empty($startTime) && empty($sear)){
        if($gender == ''){
            $query = $CI->db->where('gid','5')->where('gender','1')->or_where('gender','2')->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
                $res = $query->result_array();
        }else{
            $query = $CI->db->where('gid','5')->where('gender',$gender)->order_by('savePhotoTime','desc')->limit($size,$page)->get('hf_user_member');
            $res = $query->result_array();
        }
    }
    return $res;

}

//中奖纪录搜索
function search_history($startTime,$endTime,$prize){
    $CI = &get_instance();
    $res= '';

    if(!empty($startTime) && empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->get();
        $query = $CI->db->where('a.gameId','2')->where('a.createTime >=',$startTime)->where('a.createTime <=',$endTime)->order_by('a.createTime','desc')->get();
        $res = $query->result_array();
    }elseif(empty($startTime) && !empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->get();
        $query = $CI->db->where('a.gameId','2')->where('a.prizeId',$prize)->order_by('a.createTime','desc')->get();
        $res = $query->result_array();
    }elseif(!empty($startTime) && !empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->get();
        $query = $CI->db->where('a.gameId','2')->where('a.prizeId',$prize)->where('a.createTime >=',$startTime)->where('a.createTime <=',$endTime)->order_by('a.createTime','desc')->get();
        $res = $query->result_array();
    }elseif(empty($startTime) && empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->get();
        $query = $CI->db->where('a.gameId','2')->order_by('a.createTime','desc')->get();
        $res = $query->result_array();
    }
    return $res;


}
//
function search_history_page($startTime,$endTime,$prize,$page,$size){
     $CI = &get_instance();
    $res= '';
    if(!empty($startTime) && empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->get();
        $query = $CI->db->where('a.gameId','2')->where('a.createTime >=',$startTime)->where('a.createTime <=',$endTime)->order_by('a.createTime','desc')->limit($page,$size)->get();
        $res = $query->result_array();
    }elseif(empty($startTime) && !empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->limit($page,$size)->get();
        $query = $CI->db->where('a.gameId','2')->where('a.prizeId',$prize)->order_by('a.createTime','desc')->limit($page,$size)->get();
        $res = $query->result_array();
    }elseif(!empty($startTime) && !empty($prize)){
        //echo "2";
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->limit($page,$size)->get();
        $query = $CI->db->where('a.gameId','2')->where('a.prizeId',$prize)->where('a.createTime >=',$startTime)->where('a.createTime <=',$endTime)->order_by('a.createTime','desc')->limit($page,$size)->get();
        $res = $query->result_array();
    }elseif(empty($startTime) && empty($prize)){
        $CI->db->select('a.*,b.nickname,c.title');
        $CI->db->from('hf_game_wining_history a');
        $CI->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $CI->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $CI->db->order_by('a.createTime','desc')->limit($page,$size)->get();
        $query = $CI->db->where('a.gameId','2')->order_by('a.createTime','desc')->limit($page,$size)->get();
        $res = $query->result_array();
    }
    return $res;
}


//返回领取纪录
function AllReceive($id,$state,$time,$endtime){
    $CI = &get_instance();
    $res= '';
    if(!empty($id) && empty($state) && empty($time)){
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.store_coupon_id',$id)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(empty($id) && !empty($state) && empty($time)){
        if($state == '2'){
            $state = '0';
        }
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.user_coupon_state',$state)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(empty($id) && empty($state) && !empty($time)){
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(!empty($id) && !empty($state) && empty($time)){
        if($state == '2'){
            $state = '0';
        }
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.store_coupon_id',$id)->where('a.user_coupon_state',$state)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(!empty($id) && empty($state) && !empty($time)){
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.store_coupon_id',$id)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(empty($id) && !empty($state) && !empty($time)){
        if($state == '2'){
            $state = '0';
        }
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.user_coupon_state',$state)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(!empty($id) && !empty($state) && !empty($time)){
        if($state == '2'){
            $state = '0';
        }
        $CI->db->select('a.*,c.nickname,c.phone,b.name,b.title');
        $CI->db->from('hf_user_coupon as a');
        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');
        $query = $CI->db->where('a.store_coupon_id',$id)->where('a.user_coupon_state',$state)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }elseif(empty($id) && empty($state) && empty($time)){
        $CI->db->select('a.*,c.nickname,c.phone');

        $CI->db->from('hf_user_coupon as a,b.name,b.title');

        $CI->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $CI->db->join('hf_shop_coupon as b','a.store_coupon_id = b.id','left');

        $query = $CI->db->order_by('a.user_coupon_id','desc')->get();
        $res = $query->result_array();
    }
    return $res;

}



 ?>