<?php 
	
	// 验证码
	
	
	$width = 200;	// 宽
	$height = 50;	// 高
	$length = 3;	// 验证码字符数量
	
	// 1.创建画布
	$canvas = imagecreatetruecolor($width , $height);

	// 2.绘制过程

		// 分配颜色
		$bgColor = imagecolorallocate($canvas , mt_rand(180,240),mt_rand(180,240),mt_rand(180,240));

		// 填充
		imagefill($canvas , 0,0, $bgColor);

		// 干扰字符
		$letter = range('A','Z');
		shuffle($letter);	// 打乱
		$fontSize = 7;		//字体大小
		$fontStyle = './font/FZSTK.TTF';	// 字体类型
		$count = count($letter);	// 要循环的次数

		// imagettftext(目标,字体大小,角度, x,y,颜色,字体类型,文本);
		for($i = 0; $i < $count; $i++){
			// echo $letter[$i];
			$angle = mt_rand(0,360);	//角度
			$x = mt_rand(0 , $width);	
			$y = mt_rand(0 , $height);	
			$fontColor = imagecolorallocate($canvas , mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));	// 每一个字都要随机


			imagettftext($canvas ,$fontSize,$angle,$x,$y,$fontColor,$fontStyle, $letter[$i] );
		}

		

		unset($letter);	
		$lower = range('a','z');
		$upper = range('A','Z');
		$number = range(0,9);
		$letter = array_merge($lower,$upper,$number);	// 合并
		shuffle($letter); // 打乱字符顺序

		$fontSize = $height * 0.5 ; 	// 字体大小
		$x = 0;				// 字体的圆心x
		$y = $fontSize;		// 字体的圆心y
		
		$fontStyle = './font/msyh.ttf';	// 字体类型

		// imagettftext(目标,字体大小,角度, x,y,颜色,字体类型,文本);
		
		$xOffset = ($width - $fontSize * $length) / 2; // 第一个字的偏移量
		$yOffset = ($height - $fontSize) / 2; 


		// 用于存储验证码
		$code = '';
	
		// 循环输出字符
		for($i = 0; $i < $length; $i++){
			
			$angle = mt_rand(-45,45);	// 字体角度
			$fontColor = imagecolorallocate($canvas , mt_rand(50,150),mt_rand(50,150),mt_rand(50,150));	// 字体颜色
			$x = $i * $fontSize;	// 计算每个字的偏移量

			imagettftext($canvas ,$fontSize,$angle,$x + $xOffset,$y + $yOffset,$fontColor,$fontStyle, $letter[$i] );

			// 拼接验证码
			$code .= $letter[$i];
		}
		// 开启会话跟踪
		session_start();
		// 存储在session中
		$_SESSION['code'] = $code;
		file_put_contents('code.txt',$code);


	// 3.保存输出
	header('content-type:image/jpeg');
	imagejpeg($canvas);

	// 4.释放资源
	imagedestroy($canvas);



