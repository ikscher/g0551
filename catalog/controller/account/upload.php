<?php
class ControllerAccountUpload extends Controller {

    public function index(){
		$customer_id=$this->customer->getId();
		//================图片上传==================================
		//上传文件类型列表  
		$uptypes=array(  
			'image/jpg',  
			'image/jpeg',  
			'image/png',  
			'image/pjpeg',  
			'image/gif',  
			'image/bmp',  
			'image/x-png'  
		);  
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}
		
		$min_file_size=20480;
		$max_file_size=1024000;     //上传文件大小限制, 单位BYTE 1M 
		$save_path = DIR_IMAGE."/data/avatar/";//上传文件路径  
		$save_url = "image/data/avatar/";//保存到数据库的URL
		
		//$destination_folder="uploadimg/"; 
		$watermark=1;      //是否附加水印(1为加水印,其他为不加水印);  
		$watertype=2;      //水印类型(1为文字,2为图片)  
		$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
		$waterstring="http://www.g0551.com/";  //水印字符串  
		$waterimg=$server."catalog/view/theme/default/image/watermark.png";    //水印图片  
		$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
		$imgpreviewsize=1/2;    //缩略图比例  
		
		if($this->request->post['isupload'] == '1') {
			if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])){  //是否存在文件
                 $this->showMessage('图片不存在！','index.php?route=account/edit');			
			}  
		  
			$file = $_FILES["upfile"];  
			
			if($max_file_size < $file["size"])  {  
                $this->showMessage('文件太大，请上传小于1M的图片!','index.php?route=account/edit');		//检查文件大小  					
			}  
			
			/* if($min_file_size > $file["size"])  {  
                $this->showMessage('文件太小，请上传大于20K的图片!','index.php?route=account/edit');		//检查文件大小  					
			} */ 
		  
			if(!in_array($file["type"], $uptypes)){   
			    //检查文件类型  
				$this->showMessage('文件类型不符!'.$file["type"],'index.php?route=account/edit');		
			}

            
			$file_content = file_get_contents($_FILES['upfile']['tmp_name']);
			$low_file_content = strtolower($file_content);
			$pos = strpos($low_file_content, '<?php');
	
		    if($pos){
				$notice = "照片中含有不安全信息请重新上传";
				$this->showMessage($notice,'index.php?route=account/edit');
				
			}
					
		  
			if(!file_exists($save_path))  {  
				mkdir($save_path);  
			}  
		  
			$filename=$file["tmp_name"];  
			$image_size = getimagesize($filename);  
			$pinfo=pathinfo($file["name"]);  
			$ftype=$pinfo['extension'];  
			$destination = $save_path.$customer_id.".".$ftype;  
			
			$save_url .=$customer_id.".".$ftype;  
			
			if(file_exists($destination)){
			    unlink($destination);
			}
			/* if (file_exists($destination) && $overwrite != true)  {  
				$this->showMessage('同名文件已经存在了!','index.php?route=account/edit');		
			} */  
		  
			if(!move_uploaded_file ($filename, $destination))  {  
				$this->showMessage('移动文件出错!','index.php?route=account/edit');		
			}  
		    
			if(empty($image_size)) $this->showMessage('错误');
			/* $pinfo=pathinfo($destination);  
			$fname=$pinfo[basename];  
			echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";  
			echo " 宽度:".$image_size[0];  
			echo " 长度:".$image_size[1];  
			echo "<br> 大小:".$file["size"]." bytes";   */
		  
			if($watermark==1) {  
				$iinfo=getimagesize($destination,$iinfo);  
				$nimage=imagecreatetruecolor($image_size[0],$image_size[1]);  
				$white=imagecolorallocate($nimage,255,255,255);  
				$black=imagecolorallocate($nimage,0,0,0);  
				$red=imagecolorallocate($nimage,255,0,0);  
				imagefill($nimage,0,0,$white);  
				switch ($iinfo[2])  {  
					case 1:  
					$simage =imagecreatefromgif($destination);  
					break;  
					case 2:  
					$simage =imagecreatefromjpeg($destination);  
					break;  
					case 3:  
					$simage =imagecreatefrompng($destination);  
					break;  
					case 6:  
					$simage =imagecreatefromwbmp($destination);  
					break;  
					default:  
					die("不支持的文件类型");  
					exit;  
				}  
		  
				imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);  
				imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);  
		  
				switch($watertype)  {  
					case 1:   //加水印字符串  
					imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);  
					break;  
					case 2:   //加水印图片  
					$simage1 =imagecreatefrompng($waterimg);  
					imagecopy($nimage,$simage1,0,0,0,0,200,50);  
					imagedestroy($simage1);  
					break;  
				}  
		  
				switch ($iinfo[2])  {  
					case 1:  
					imagegif($nimage);  
					//imagejpeg($nimage, $destination);  
					break;  
					case 2:  
					imagejpeg($nimage);  
					break;  
					case 3:  
					imagepng($nimage);  
					break;  
					case 6:  
					imagewbmp($nimage, $destination);  
					//imagejpeg($nimage, $destination);  
					break;  
				}  
		  
				//覆盖原上传文件  
				imagedestroy($nimage);  
				imagedestroy($simage);  
			}  
			
			$sql="update ".DB_PREFIX."customer set avatar='{$save_url}' where customer_id='{$customer_id}'";
			$this->db->query($sql);
       
			header("Location:index.php?route=account/edit");
			/* if($imgpreview==1)  
			{  
			echo "<br>图片预览:<br>";  
			echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);  
			echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";  
			}   */
	    }
		
	
	}
}

