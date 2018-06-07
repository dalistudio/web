<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
	
	check_login();
	if($_SESSION['Level']!=0 && $_SESSION['Level']!=3)
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
<script language="javascript">
function onPost(id)
{
	if(id==1)
	{
		// 查询
		form1.action="Report_Gen.php";
		form1.submit(); 
	}
	if(id==2)
	{
		// 下载
		form1.action="Report_Excel.php";
		form1.submit(); 
	}
}

function onPost2(id)
{
	if(id==1)
	{
		// 查询
		form2.action="Report_Member.php";
		form2.submit(); 
	}
	if(id==2)
	{
		// 下载
		form2.action="Report_Member_Excel.php";
		form2.submit(); 
	}
}

function onPost3(id)
{
	if(id==1)
	{
		// 查询
		form3.action="Report_Type.php";
		form3.submit(); 
	}
	if(id==2)
	{
		// 下载
		form3.action="Report_Type_Excel.php";
		form3.submit(); 
	}
}

</script>
<script src="/js/WdatePicker.js"></script> 
<title>生成财务报表</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="Report_Excel.php">
  <br />
<table class="tbl" width="300" border="0">
  <tr>
    <th colspan="2" scope="col">查询条件</th>
    </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td><input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td><input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td width="91" align="right">车号：</td>
    <td width="199"><input type="text" name="CheHao" /></td>
  </tr>
  <tr>
    <td align="right">车型：</td>
    <td><input type="text" name="CheXing" /></td>
  </tr>
  <tr>
    <td align="right">客户：</td>
    <td>
    <select name="DanWei" id="DanWei">
        <?php
			$member_sql = "Select * FROM member order by member_name asc;";
			$member_result=mysql_query($member_sql);
			print("<option value=''>");
			while($member_row = mysql_fetch_array($member_result))
			{
				print("<option value=".$member_row['member_name'].">".$member_row['member_name']);
			}
		?>
    	</select>
    </td>
  </tr>
  <tr>
    <td align="right">客户类型：</td>
    <td><select name="Type">
    <OPTION VALUE="">全部
    <OPTION VALUE="0">零售
    <OPTION VALUE="1">预付款
    <OPTION VALUE="2">月结
    <OPTION VALUE="3">进料
    </select></td>
  </tr>
  <tr>
    <td align="right">货物：</td>
    <td><input type="text" name="HuoWu" /></td>
  </tr>
  <tr>
    <td align="right">规格：</td>
    <td><input type="text" name="GuiGe" /></td>
  </tr>
  <tr>
    <td align="right">司磅员：</td>
    <td><input type="text" name="SiBangYuan" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input type="button" value="查询" onclick="onPost(1);" /></td>
    <td><input type="button" value="下载" onclick="onPost(2);" />
    (注：生成需要10秒)</td>
  </tr>
</table>

</form>



<form id="form2" name="form2" method="post" action="Report_Member.php">
  <br />
<table class="tbl" width="300" border="0">
  <tr>
    <th colspan="2" scope="col">按客户合计生成报表</th>
    </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td><input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td><input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input type="button" value="查询" onclick="onPost2(1);" /></td>
    <td><!-- input type="button" value="下载" onclick="onPost2(2);" / -->
    (注：生成需要10秒)</td>
  </tr>
</table>

</form>










<form id="form3" name="form3" method="post" action="Report_Type.php">
  <br />
<table class="tbl" width="300" border="0">
  <tr>
    <th colspan="2" scope="col">按货物合计生成报表</th>
    </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td><input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td><input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input type="button" value="查询" onclick="onPost3(1);" /></td>
    <td><!-- input type="button" value="下载" onclick="onPost3(2);" / -->
    (注：生成需要10秒)</td>
  </tr>
</table>

</form>


</body>
</html>