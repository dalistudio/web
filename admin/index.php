<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录界面</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="api/login.php">
<table width="300" border="0" align="center">
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
    <td><input type="hidden" name="level" id="level" value="0" /></td>
    <td>
    	<input type="submit" name="button" id="button" value="提交" />
    </td>
  </tr>
</table>
</form>
</body>
</html>