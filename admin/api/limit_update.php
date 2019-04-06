<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 限重模块 - 数据表
// 编辑 - 编辑限重的信息
//
include '../../session.inc';
include '../../conn.php';
$Id = $_GET['id'];
$Axle = $_GET['Axle'];
$Type = $_GET['Type'];
$Weight = $_GET['Weight'];

$sql  = "UPDATE limits SET ";
$sql .= "limit_axle='".$Axle."',"; // 车轴数
$sql .= "limit_type='".$Type."',"; // 车类型
$sql .= "limit_weight='".$Weight."'"; // 限重(吨)
$sql .= " WHERE ";
$sql .= "limit_id='".$Id."'";
$sql .= ";";

if(inject_check($sql))
{
    if(mysql_query($sql,$conn)) // 执行语句
    {
//			echo("限重信息更新成功~"); // 执行成功
        header('Location: /admin/limit.php');
    }
    else
    {
        echo("限重信息更新失败！！！\n");
        echo("ERROR：". mysql_error()); // 执行失败
    }
}

mysql_close($conn); // 关闭数据库连接
?>