<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
	
	check_login();
	if($_SESSION['Level']!=0)
	{
		print("无权访问");
		die();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>无标题文档</title>
</head>

<body>
<table class="tbl" width="300" border="0">
	<tr>
    	<th colspan="3">定制短信内容</th>
    </tr>
    <tr>
    	<td width="51">客户：</td>
        <td><input type="text" name="textfield2" id="textfield2" /></td>
      <td>#DanWei</td>
    </tr>
    <tr>
    	<td>车号：</td>
        <td><input type="text" name="textfield3" id="textfield3" /></td>
      <td>#CheHao</td>
    </tr>
    <tr>
    	<td>货物：</td>
        <td><input type="text" name="textfield4" id="textfield4" /></td>
      <td>#HuoWu</td>
    </tr>
    <tr>
    	<td>规格：</td>
        <td><input type="text" name="textfield5" id="textfield5" /></td>
      <td>#GuiGe</td>
    </tr>
    <tr>
    	<td>净重：</td>
        <td><input type="text" name="textfield6" id="textfield6" /></td>
      <td>#JingZhong</td>
    </tr>
    <tr>
    	<td>金额：</td>
        <td><input type="text" name="textfield7" id="textfield7" /></td>
      <td>#JinE</td>
    </tr>
    <tr>
    	<td>余额：</td>
        <td><input type="text" name="textfield8" id="textfield8" /></td>
      <td>#YuE</td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
		<td>内容：</td>
        <td colspan="2"><textarea name="textarea2" cols="25" rows="5" id="textarea2"></textarea></td>
    </tr>
    <tr>
   	  <td>&nbsp;</td>
        <td align="center"><input name="input" type="button" value="测试" /></td>
        <td>&nbsp;</td>
    </tr>
</table>
<br />
<form id="form1" name="form1" method="post" action="http://127.0.0.1:8888/sms">
<table class="tbl" width="300" border="0">
  <tr>
    <th colspan="2" scope="col">发送短信</th>
  </tr>
  <tr>
    <td width="72">手机号码：</td>
    <td width="216">
      <input name="tel" type="text" id="tel" maxlength="11" />
    </td>
  </tr>
  <tr>
    <td>短信内容：</td>
    <td><textarea name="sms" cols="25" rows="5" id="sms"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" value="发送" /></td>
    </tr>
</table>
</form>
</body>
</html>