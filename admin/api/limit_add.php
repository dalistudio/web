<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 限重模块 - 数据表
// 添加 - 添加车型限重信息
//

include '../../session.inc';
include '../../conn.php';
$Axle = $_GET['Axle'];
$Type = $_GET['Type'];
$Weight = $_GET['Weight'];

$sql  = "INSERT INTO limits SET ";
$sql .= "limit_axle='".$Axle."',"; // 车轴数
$sql .= "limit_type='".$Pwd."',"; // 车类型
$sql .= "limit_weight='".$Weight."'"; // 限重(吨)

if(inject_check($sql))
{
    if(mysql_query($sql,$conn)) // 执行语句
    {
//			echo("限重信息添加成功~"); // 执行成功
        header('Location: /admin/limit.php');
    }
    else
    {
        echo("限重信息添加失败！！！\n");
        echo("ERROR：". mysql_error()); // 执行失败
    }
}

mysql_close($conn); // 关闭数据库连接

?>