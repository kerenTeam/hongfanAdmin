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



 ?>