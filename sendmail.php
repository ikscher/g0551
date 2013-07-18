<?php
 /*  $html="<span style='background-color:#3424fc'><font size='18'>cytech</font></span>";
  mail( "45397312@qq.com", "message from php", $html ,'ikscher@163.com'); */
  

//多封邮件发送
/* $emails = Array( "xiaoyz@birdy.dhs.org", "xiaoyz@hotmail.com" );
mail( implode(",", $emails), "message from php", "hello, xiaoyz!" ); */


$from = "ikscher@163.com";  
$to = "45397312@qq.com, wenthuang@sina.com";  
$subject = "邮件主题";  
$subject = "=?UTF-8?B?".base64_encode($subject)."?=";  
$attach_filename = date("Y-m-d") . ".html";  
  
$emailBody =  "  
正文第一行  
正文第二行  
正文第三行  
The end!";  
  
# 然后我们要作为附件的HTML文件   
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