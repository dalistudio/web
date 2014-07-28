<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
    include '../session.inc';
//	check_login();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>Info</title>
</head>

<body leftmargin="2" oncontextmenu="return false" onselectstart="return false">
<table width="150" border="0">
  <tr>
    <td>
    <table class="tbl" width="150" border="0">
      <tr>
        <th colspan="2">用户信息</th>
        </tr>
      <tr>
        <td width="51"><div align="center">账号：</div></td>
        <td width="87"><div align="center">
          <?=$_SESSION['name']?>
          </div></td>
        </tr>
      <tr>
        <td><div align="center">级别：</div></td>
        <td><div align="center"><?=$_SESSION['level']?></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
