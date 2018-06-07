<?php
//
// Copyright (c) 2014-2016, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
	
	check_login();
	if($_SESSION['Level']!=0)
	{
		print("无权访问");
		die();
	}
	
	@$Start = $_POST['start']; // 开始时间
	@$End = $_POST['end']; // 结束时间
	@$DanHao = $_POST['DanHao']; // 单号
	@$Member_name = $_POST['member']; // 客户名
	@$Type = $_POST['type']; // 类型
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>消费管理</title>
<script src="/js/WdatePicker.js"></script> 
<script src="/js/ajax.js"></script>
 <script>
function OnAdd()
{
	// 确认框
	var option=confirm("是否真的添加?");//true,false
	if(option){
		document.form1.action = "api/pay_add.php";
		document.form1.submit(); // 添加按钮
	}
}

  var xmlhttp = createXMLHttpRequest();

  function cc(val){
	var value = "getyue.php?DanWei=";
	value += val;

//    alert(value);
	if (xmlhttp) {
		ajax(xmlhttp,"GET", value ,"",c);
 	}
	else {
    		alert ("Init xmlhttprequest fail"); // 初始化 XML HTTP 失败
	}
     }

 function c(val){
//	alert(val.responseText);
	document.getElementById("div_YuE"). innerHTML= "余额："+ val.responseText;
}
 </script>
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
        <input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
        </td>
    </tr>
    <tr>
        <th>单号：</th>
        <td>
	<input name="DanHao" type="text" />
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
	<th>类型：</th>
	<td>
		<select name="type" id="type">
			<option value="">全部
			<option value="0">充值
			<option value="1">消费
			<option value="2">退款
		</select>
	</td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><input type="submit" value="查询"/></td>
  </tr>
</table>
</form>
<br />
<table class="tbl" width="900" border="1">
  <tr>
    <th width="10%">编号</th>
    <th width="15%">客户</th>
    <th width="10%">单号</th>
    <th width="15%">金额</th>
    <th width="15%">余额</th>
    <th width="17%">时间</th>
    <th width="8%">类型</th>
    <th width="10%">操作员</th>
  </tr>
<?php
  $sql = '';
  $sql .= "Select pay_id,pay.member_name,bill_DanHao,pay_JinE,pay_YuE,member.member_YuE,pay_date,pay_Type,pay_Op FROM pay,member";
  $sql .= " WHERE ";
  $sql .= " pay.member_name=member.member_name"; // 匹配单位
  if(strcmp($Start,'')!=0) $sql .= " and pay_date >= '".$Start."'"; // 开始时间
  if(strcmp($End,'')!=0) $sql .= " and pay_date <= '".$End."'"; // 结束时间
  if(strcmp($DanHao,'')!=0) $sql .= " and bill_DanHao='".$DanHao."'"; // 单号
  if(strcmp($Member_name,'')!=0)$sql .= " and pay.member_name='".$Member_name."'";
  if(strcmp($Type,'')!=0)$sql .= " and pay_Type ='".$Type."'"; // 类型

  if(empty($Start) && empty($End) && empty($DanHao) && empty($Member_name) && strcmp($Type,'')==0)$sql .= " and 1=0";

  $sql .= ";";
//print($sql);

  $result=mysql_query($sql); // 执行SQL语句
  $HeJi = 0;
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr>");
 	print("  <td>".$row['pay_id']."</td>");
  	print("  <td>".$row['member_name']."</td>");
  	print("  <td>".$row['bill_DanHao']."</td>");
  	print("  <td>".$row['pay_JinE']."</td>");
	print("  <td>".$row['pay_YuE']."</td>");
  	print("  <td>".$row['pay_date']."</td>");
	//print("  <td>".$row['pay_Type']."</td>");
	switch($row['pay_Type'])
	{
		case "0":
			print("<td>充值</td>");
			break;
		case "1":
			print("<td>消费</td>");
			break;
		case "2":
			print("<td>退款</td>");
			break;
	}
	print("  <td>".$row['pay_Op']."</td>");
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
<table class="tbl" width="300" border="1">
  <tr>
  	<th colspan="2">客户充值 / 退款</th>
  </tr>
  <tr>
    <td align="center">客户：</td>
    <td>
        <select name="Member" id="Member" onchange="cc(this.options[this.options.selectedIndex].value);">
        <?php
			$member_sql = "Select * FROM member WHERE member_Type=1 or member_Type=2 order by member_name asc;";
			$member_result=mysql_query($member_sql);
			while($member_row = mysql_fetch_array($member_result))
			{
				print("<option value=".$member_row['member_name'].">".$member_row['member_name']);
			}
		?>
    	</select>
	<div id="div_YuE"></div>
    </td>
  </tr>
  <tr>
    <td align="center">单号：</td>
    <td><input type="text" name="DanHao" id="DanHao" /></td>
  </tr>
  <tr>
    <td align="center">金额：</td>
    <td><input type="text" name="JinE" id="JinE" /><br>如退款请填写负号，如：-90000 </td>
  </tr>
  <tr>
    <td align="center">类型：</td>
    <td>
        <select name="Type" id="Type">
	<option value="0">充值
	<option value="2">退款
        </select>
        <input type="hidden" name="Op" id="Op"  value="<?=$_SESSION['User']?>" />
    </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
          <th scope="col"><input type="button" name="Add" id="Add" value="添加"  onclick="OnAdd();" /></th>
        </tr>
    </table></td>
    </tr>
</table>
</form>
</body>
</html>
