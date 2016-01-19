<?php
$mysql_server_name='192.168.1.30';
$mysql_username='root';
$mysql_password='123456';
$mysql_database='stone';
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
if(!$conn) // 连接数据库失败
{
	die('Could not connect: ' . mysql_error()); 
}

mysql_query("set character set 'utf8'"); 
mysql_query("SET NAMES UTF8");
mysql_select_db($mysql_database,$conn); // 选择数据库

function inject_check($sql_str) { 
return eregi('select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str); // 进行过滤 
} 
?>
