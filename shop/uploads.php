<?php 
    
    function generate_code($len = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0, $count = strlen($chars); $i < $count; $i++)
        {
            $arr[$i] = $chars[$i];
        }

        mt_srand((double) microtime() * 1000000);
        shuffle($arr);
        $code = substr(implode('', $arr), 5, $len);
        return $code;
    }
    
	function GetID($prefix) {
		//第一步:初始化种子
		//microtime(); 是个数组
		/*$seedstr =split(" ",microtime(),5);
		$seed =$seedstr[0]*10000;
		//第二步:使用种子初始化随机数发生器
		srand($seed);
	*/	//第三步:生成指定范围内的随机数
		$random =rand(1000,10000);
	    $random.=generate_code(); 
		$filename = date("Ymd", time()).$random.$prefix;
	
		return $filename;
	}
		    
		    $path = "api_images/"; 
			$name_orgin = $_FILES['Filedata']['name']; 
			$name = GetID( ".".strtolower(substr($_FILES['Filedata']['name'], (strrpos($_FILES['Filedata']['name'], '.') + 1))));

			$path = $path.$name;
			
			move_uploaded_file($_FILES['Filedata']["tmp_name"],$path); 
			$data = array('fileUrl'=>"/".$path,'fileName'=>$name_orgin,'fileSize'=>ceil(filesize($path)/1000).'k'); 
			echo json_encode($data);
?>