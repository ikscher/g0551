<?php
 /*  $html="<span style='background-color:#3424fc'><font size='18'>cytech</font></span>";
  mail( "45397312@qq.com", "message from php", $html ,'ikscher@163.com'); */
  

//����ʼ�����
/* $emails = Array( "xiaoyz@birdy.dhs.org", "xiaoyz@hotmail.com" );
mail( implode(",", $emails), "message from php", "hello, xiaoyz!" ); */


$from = "ikscher@163.com";  
$to = "45397312@qq.com, wenthuang@sina.com";  
$subject = "�ʼ�����";  
$subject = "=?UTF-8?B?".base64_encode($subject)."?=";  
$attach_filename = date("Y-m-d") . ".html";  
  
$emailBody =  "  
���ĵ�һ��  
���ĵڶ���  
���ĵ�����  
The end!";  
  
# Ȼ������Ҫ��Ϊ������HTML�ļ�   
$attachment =  "<html>  
<head>  
<title>The attached file</title>  
</head>  
<body>  
<h2>This is the attached HTML file</h2>  
</body>  
</html>";  
  
$boundary = uniqid("");  
  
$headers =  "From: $from  
To: $to  
Content-type: multipart/mixed; boundary=\"$boundary\"";  
  
$emailBody =  "--$boundary  
Content-type: text/plain; charset=utf-8  
Content-transfer-encoding: 8bit  
  
$emailBody  
  
--$boundary  
Content-type: text/html; name=$attach_filename  
Content-disposition: inline; filename=$attach_filename  
Content-transfer-encoding: 8bit  
  
$attachment  
  
--$boundary--";  
  
mail($to, $subject, $emailBody, $headers);  

?>  