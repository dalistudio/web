<?php
$username = 13800138000;
$password = 123456;
$sendto = 13976004848;
$message = "����һ�����Կ���";

$curlPost = 'username='.urlencode($username).'&
password='.urlencode($password).'&
sendto='.urlencode($sendto).'&
message='.urlencode($message).'';

$ch = curl_init();//��ʼ��curl
curl_setopt($ch,CURLOPT_URL,'http://sms.api.bz/fetion.php');//ץȡָ����ҳ
curl_setopt($ch, CURLOPT_HEADER, 0);//����header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Ҫ����Ϊ�ַ������������Ļ��
curl_setopt($ch, CURLOPT_POST, 1);//post�ύ��ʽ
curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
$data = curl_exec($ch);//����curl
curl_close($ch);
print_r($data);//������
?>