<?php
	//生成从$min---$max的整数。从小到大
	function unique_rand($min, $max, $num) {
		$count = 0;
		$return = array();
		while ($count < $num) {
			$return[] = mt_rand($min, $max);
			$return = array_flip(array_flip($return));
			$count = count($return);
		}
		shuffle($return);
		sort($return);
		return $return;
	}

	//检查是否登陆过
	function check_login(){
			$res=session('res');
			if(!empty($res)){
				return true;
			}else{
				return false;
			}
		}
	//加密方法
	function hcy_md6($str){
		return md5(sha1(md5(sha1($str)."".md5($str)))."".md5($str));
	}

?>