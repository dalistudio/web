<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//
//    include 'inc/session.inc';
//	check_login();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>menu</title>
<style type="text/css">
body {
	background-image: url(/img/bg2.gif);
}
</style> 
</head>

<body leftmargin="0" topmargin="0" oncontextmenu="return false" onselectstart="return false">
<table border="0" background="img/bg.gif">
  <tr>
    <td rowspan="3" width="150"><h2 align="center">文峰石场系统</h2></td>
    <td rowspan="3">&nbsp;</td>
    <td width="600"><table width="600" border="0" >
      <tr><td>
      <ul id="nav">
        <li><a href="mainFrame.php" target="mainFrame">首页</a></li>
        <li><a href="user.php" target="mainFrame">用户管理</a></li>
        <li><a href="member.php" target="mainFrame">客户管理</a></li>
        <li><a href="type.php" target="mainFrame">货物管理</a></li>
        <li><a href="goods.php" target="mainFrame">价目管理</a></li>
        <li><a href="api/login.php?logout=yes" target="_top">安全退出</a></li></ul>
      </td></tr>
    </table></td>
    <td width="1">&nbsp;</td>
  </tr>
  <tr>
    <td><!-- marquee direction="left">跑马灯</marquee --></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="600" border="0">
      <tr>
        <td>
        <ul id="nav">
        <li><a href="bill.php" target="mainFrame">过磅单管理</a></li>
        <li><a href="pay.php" target="mainFrame">消费管理</a></li>
        <li><a href="report.php" target="mainFrame">账单生成</a></li>
        <li><a href="change.php" target="mainFrame">改单管理</a></li>
        <!-- li><a href="card.php" target="mainFrame">门禁卡管理</a></li -->
        <!-- li><a href="database.php" target="mainFrame">数据库管理</a></li -->
        </ul>
        </td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
