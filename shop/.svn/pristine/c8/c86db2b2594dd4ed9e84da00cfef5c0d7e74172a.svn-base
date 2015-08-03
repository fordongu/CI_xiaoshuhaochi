<?php 
 
class Seven30show extends Controller
{
	function clear_log($params = array())
	{
		
		// 清理LOG
		error_log(print_r('log_excute'.date('Y-m-d H:i:s'),true),3,'/home/www/7dian/excute'.date('Y-m-d H:i:s').'.txt');
		$history = $this->tickets->select('wallet_history');
		error_log(print_r($history,true),3,'/home/www/7dian/history.txt');
		
	}

	//.....
}


?>