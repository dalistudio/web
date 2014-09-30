<?php
$username = 13800138000;
$password = 123456;
$sendto = 13976004848;
$message = "测试一个试试看！";

$curlPost = 'username='.urlencode($username).'&
password='.urlencode($password).'&
sendto='.urlencode($sendto).'&
message='.urlencode($message).'';

$ch = curl_init();//初始化curl
curl_setopt($ch,CURLOPT_URL,'http://sms.api.bz/fetion.php');//抓取指定网页
curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
$data = curl_exec($ch);//运行curl
curl_close($ch);
print_r($data);//输出结果
?>