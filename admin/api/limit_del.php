<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 限重模块 - 数据表
// 删除 - 删除限重表的信息
//
include '../../session.inc';
include '../../conn.php';
$Name = $_GET['Id'];

$sql  = "DELETE FROM limits ";
$sql .= " WHERE ";
$sql .= "limit_id='".$Id."'"; // 限重编号
$sql .= ";";

if(inject_check($sql))
{
    if(mysql_query($sql,$conn)) // 执行语句
    {
//			echo("限重信息删除成功~"); // 执行成功
        header('Location: /admin/limit.php');
    }
    else
    {
        echo("限重信息删除失败！！！\n");
        echo("ERROR：". mysql_error()); // 执行失败
    }
}

mysql_close($conn); // 关闭数据库连接
?>