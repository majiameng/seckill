<?php
	

	$url = 'https://www.majiameng.com/seckill/index.php?app=app&c=seckill&a=addQsec&gid=2&type=transaction';
	$result = file_get_contents($url);
	
	var_dump($result);
