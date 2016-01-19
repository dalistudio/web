<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>管理员登录界面</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="api/login.php">
<table class="tbl" width="300" border="0" align="center">
  <tr>
    <th colspan="2">登录</th>
    </tr>
  <tr>
    <td>用户：</td>
    <td>
      <input name="user" type="text" id="user" size="16" />
    </td>
  </tr>
  <tr>
    <td>密码：</td>
    <td>
    	<input name="pwd" type="password" id="pwd" maxlength="16" />
    </td>
  </tr>
  <tr>
    <td>
    	<input type="submit" name="button" id="button" value="登录" />
    </td>
  </tr>
</table>
</form>
</body>
</html>