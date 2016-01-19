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
	
	$Start = $_POST['start']; // 开始时间
	$End = $_POST['end']; // 结束时间
	$Member_name = $_POST['member']; // 客户名
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>消费管理</title>
<script src="/js/WdatePicker.js"></script> 
</head>

<body>
<form id="Form_Find" method="post" action="pay.php">
<table class="tbl" width="300" border="1">
	<tr>
    	<th colspan="2">查询条件</th>
    </tr>
    <tr>
    	<th width="63">开始：</th>
        <td width="221">
        <input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
        </td>
    </tr>
    <tr>
    	<th>结束：</th>
        <td>
        <input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
        </td>
    </tr>
    <tr>
    	<th>客户：</th>
        <td>
        <select name="member" id="member">
        <?php
			$member_sql  = "Select * FROM member";
			$member_sql .= " WHERE ";
			$member_sql .= "member_Type=1 or member_Type=2"; // 只列出预存和月结客户
			$member_sql .= " order by member_name asc ";
			$member_sql .= ";";
			$member_result=mysql_query($member_sql);
			print("<option value=''>全部");
			while($member_row = mysql_fetch_array($member_result))
			{
				print("<option value=".$member_row['member_name'].">".$member_row['member_name']);
			}
		?>
    	</select>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><input type="submit" value="查询"/></td>
  </tr>
</table>
</form>
<br />
<table class="tbl" width="600" border="1">
  <tr>
    <th width="10%">编号</th>
    <th width="20%">客户</th>
    <th width="15%">单号</th>
    <th width="15%">金额</th>
    <th width="30%">时间</th>
  </tr>
<?php
  $sql  = "Select * FROM pay";
  $sql .= " WHERE ";
  $sql .= "pay_date >= '".$Start."'"; // 开始时间
  $sql .= " and pay_date <= '".$End."'"; // 结束时间
  if(strcmp($Member_name,'')!=0)$sql .= " and member_name='".$Member_name."'";
  $sql .= ";";
  $result=mysql_query($sql); // 执行SQL语句
  $HeJi = 0;
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr>");
 	print("  <td>".$row['pay_id']."</td>");
  	print("  <td>".$row['member_name']."</td>");
  	print("  <td>".$row['bill_DanHao']."</td>");
  	print("  <td>".$row['pay_JinE']."</td>");
  	print("  <td>".$row['pay_date']."</td>");
  	print("</tr>");
	$HeJi += $row['pay_JinE'];
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">合计：</td>
    <td><?=$HeJi?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="api/pay_add.php">
<table class="tbl" width="300" border="1">
  <tr>
  	<th colspan="2">预付款客户充值</th>
  </tr>
  <tr>
    <td align="center">客户：</td>
    <td>
        <select name="Member" id="Member">
        <?php
			$member_sql = "Select * FROM member WHERE member_Type=1 order by member_name asc;";
			$member_result=mysql_query($member_sql);
			while($member_row = mysql_fetch_array($member_result))
			{
				print("<option value=".$member_row['member_name'].">".$member_row['member_name']);
			}
		?>
    	</select>
    </td>
  </tr>
  <tr>
    <td align="center">单号：</td>
    <td><input type="text" name="DanHao" id="DanHao" /></td>
  </tr>
  <tr>
    <td align="center">金额：</td>
    <td><input type="text" name="JinE" id="JinE" /></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
          <th scope="col"><input type="submit" name="Add" id="Add" value="添加" /></th>
        </tr>
    </table></td>
    </tr>
</table>
</form>
</body>
</html>