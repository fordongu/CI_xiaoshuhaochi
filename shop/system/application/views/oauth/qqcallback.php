<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if($user){?>QQ登陆成功<?php }?></title>
</head>
<body>
<img src="<?php echo $user['figureurl_2'];?>" />你好<?php echo $user['nickname'];?>
<br  />
<?php var_dump($user);?>
</body>
</html>