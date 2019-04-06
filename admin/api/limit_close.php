<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 限重模块 - 数据表
// 禁用 - 禁用限重模块
//
include '../../session.inc';
include '../../conn.php';
$sql  = "UPDATE sys SET ";
$sql .= "sys_limit_flag='0'"; // 限重(吨) 0=禁用  1=启用
$sql .= " WHERE ";
$sql .= "sys_id='1'";
$sql .= ";";

if(inject_check($sql))
{
    if(mysql_query($sql,$conn)) // 执行语句
    {
        header('Location: /admin/limit.php');
    }
    else
    {
        echo("限重模块禁用失败！！！\n");
        echo("ERROR：". mysql_error()); // 执行失败
    }
}

mysql_close($conn); // 关闭数据库连接
?>