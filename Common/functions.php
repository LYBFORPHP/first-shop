<?php
	
	/**
	 * 文件上传
	 * @param [string] $field  		form表单的name名
	 * @param [string] $savePath  	保存的路径
	 * @param [int]    $maxSize  	文件限制的大小
	 * @param [array]  $allowType  	文件限制的类型
	 * @return [array] $result 		返回给用户的信息
	 */
	
	function upload($field , $savePath = './save' ,$maxSize = 0 , $allowType = array())
	{
		$myFile = $_FILES[$field];

		// 用于给用户反馈信息，如：报错信息
		$result = array( 'status' => false , 'info' => '' , 'name' => '');

		// 处理保存的目录
		$savePath = rtrim($savePath , '/') . '/';

		// 如果目录不存在，则创建
		if(!file_exists($savePath)){
			mkdir($savePath , 777 , true);
		}

		// 1.判断错误号
		if($myFile['error'] > 0){
			switch($myFile['error']){
				case 1:
					$info = '超出 upload_max_filesize 的限制！';
					break;
				case 2:
					$info = '超出 MA_FILE_SIZE 的限制！';
					break;
				case 3:
					$info = '文件只被部分上传';
					break;
				case 4:
					$info = '没有上传的文件!';
					break;
				case 6:
					$info = '找不到临时文件';
					break;
				case 7:
					$info = '写入失败！';
					break;
				default :
					$info = '未知错误！';
					break;
			}

			// 将错误信息赋值给数组
			$result['info'] = $info;
			return $result;
		}

		// 2.判断文件大小
		if($maxSize > 0){
			// 当用户设定的值大于0时，再进行大小检测
			if($myFile['size'] > $maxSize){
				$result['info'] = '已经超出用户自定义的大小！' . $maxSize;
				return $result;
			}
		}

		// 3.判断文件类型
		if(count($allowType) > 0){
			if(!in_array($myFile['type'],$allowType)){
				$result['info'] = '不允许上传的类型！！';
				return $result;
			}
		}

		// 获取后缀
		$suffix = pathinfo($myFile['name'],PATHINFO_EXTENSION);

		do{
			// 4.生成随机名
			$name = mt_rand( 0,999999999);
			$name .= time();
			$name .= uniqid();
			$name = md5($name);
			$fileName = $name . '.' . $suffix;
		}while(file_exists($savePath . $fileName));
		
		// 5.判断是否合法
		if( !is_uploaded_file($myFile['tmp_name'])){
			$result['info'] = '非法数据！';
			return $result;
		}

		// 6.执行上传
		$res = move_uploaded_file($myFile['tmp_name'], $savePath . $fileName);

		if($res){
			$result['info'] = '上传成功！';
			$result['name'] = $fileName;
			$result['status'] = true;
		}else{
			$result['info'] = '上传失败！';
		}

		return $result;
	}


	/**
	 * [zoom 文件缩放]
	 * @param  [type] $pic 		[文件的路径]
	 * @param  [type] $savePath [保存的路径]
	 * @param  [type] $zoomSize [缩放的大小/如果高度已经传递，则充当宽度]
	 * @param  [type] $zoomHeight = 0 [缩放的大小]
	 * @param  [type] $prefix 	[前缀]
	 * @return [type] $[description]
	 */
	function zoom($pic,$savePath,$zoomSize,$zoomHeight = 0 , $prefix = 's_'){

		// 路径的处理
		$savePath = rtrim($savePath,'/') . '/';
		// 如果文件夹不存在，则创建
		if(!file_exists($savePath)){
			mkdir($savePath,777,true);
		}

		// 获取图片信息
		$info = getimagesize($pic);

		// 图片的宽
		$picWidth = $info[0];	
		// 图片的高
		$picHeight = $info[1];	

		// 取出后缀
		$suffix = explode('/',$info['mime'])[1];

		// 根据不同的后缀拼接不同的变量函数
		$imagecreate = 'imagecreatefrom' . $suffix;

		// 打开要缩放的图片
		$picSource = $imagecreate($pic);

		if($zoomHeight > 0){
			// 表示用户已经传递了高度，等价于指定宽高缩放
			$zoomWidth = $zoomSize;		// 充当了宽
			$zoomHeight = $zoomHeight;	// 高度
		}else{
			// 按照比例缩放
			if($picWidth > $picHeight){
				$zoomWidth = $zoomSize;
				$zoomHeight = $zoomWidth / ($picWidth / $picHeight);
			}else{
				$zoomHeight = $zoomSize;
				$zoomWidth = ($picWidth / $picHeight) * $zoomHeight ;
			}
		}
		// 创建画布
		$canvas = imagecreatetruecolor($zoomWidth , $zoomHeight);

		// 进行缩放
		imagecopyresampled(
			$canvas , 	// 新增画布
			$picSource ,	// 缩放的图片
			0,0, 	// 新增画布的起始点x,y
			0,0, 	// 缩放的图片的起始点x,y
			$zoomWidth,	// 新增画布的宽
			$zoomHeight,// 新增画布的高
			imagesx($picSource),	// 缩放的图片的宽
			imagesy($picSource)	// 缩放的图片的高
		);

		// 拼接变量函数
		$save = 'image' . $suffix;

		// 获取原名
		$saveName = pathinfo($pic,PATHINFO_BASENAME);

		// 添加前缀的目的就是方便存储，也可以根据不同页面使用不同大小的图片
		
		$save($canvas , $savePath .  $prefix . $saveName);       //变量函数！  等价于image[jpg,png,gif...](画布，保存的图片名)

		// 释放资源
		imagedestroy($picSource);
		imagedestroy($canvas);
	
	}


	function readFileName($dirPath)
	{
		// 判断是否目录
		if(!is_dir($dirPath)) return false;
		// 路径处理
		$dirPath = rtrim($dirPath,'/') . '/';

		// 保存的目录路径
		$savePath = './pic/';
		if(!file_exists($savePath)){
			mkdir($savePath);
		}

		// 打开目录(句柄或标记)
		$source = opendir($dirPath);
		// 读取
		while(false !== ($fileName = readdir($source))){
			// 跳过 . 和 ..
			if($fileName == '.' || $fileName == '..') continue;
			$path = $dirPath . $fileName;
			if(is_dir($path)){
				$var = __FUNCTION__;
				$var($path);
			}else{
				echo iconv( 'gbk','utf-8' ,$path) . '<br>';
				// $suffix = array('jpg','jpeg','png','gif');
				// $suf = strtolower(pathinfo($path,PATHINFO_EXTENSION));
				// if(in_array($suf,$suffix)){
				// 	copy($path,$savePath.basename($path));
				// }
				// 删除文件
				// unlink($path);
			}
		}

		// 关闭
		closedir($source);

		// 在遍历时，已经把所有文件删除了，我可剩下的空目录要删除掉
		// rmdir($dirPath);
	}
