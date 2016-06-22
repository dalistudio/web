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
	
	$Start = $_POST['start'];
	$End = $_POST['end'];
	$DanHao = $_POST['DanHao'];
	$Member = $_POST['Member'];
	$CheHao = $_POST['CheHao'];
	$Goods_HuoWu = $_POST['goods_HuoWu'];
	$Goods_GuiGe = $_POST['goods_GuiGe'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>过磅单管理</title>
<script src="/js/WdatePicker.js"></script> 
<script language="javascript">
	function OnDel()
	{
		var option=confirm("是否真的删除?");//true,false
		if(option){
			document.form1.action = "api/bill_del.php";
			document.form1.submit(); // 删除按钮
		}
	}

	// 处理选择行事件
	function OnSelect(id,DanHao,CheHao,DanWei,HuoWu,GuiGe)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("DanHao").value=DanHao;
		document.getElementById("CheHao").value=CheHao;
		document.getElementById("DanWei").value=DanWei;
		document.getElementById("HuoWu").value=HuoWu;
		document.getElementById("GuiGe").value=GuiGe;
	}
</script>
</head>

<body>
<form id="Form_Find" method="post" action="bill.php">
<table class="tbl" width="300" border="1">
	<tr>
    	<th colspan="2">查询条件</th>
    </tr>
    <tr>
    <th align="right">开始时间：</th>
    <td><input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <th align="right">结束时间：</th>
    <td><input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    	<th>单号</th>
        <td><input name="DanHao" type="text" />
        </td>
    </tr>
	<tr>
   	  <th width="100">客户</th>
      <td>
        <select name="Member" id="Member">
        <?php
			$member_sql = "Select * FROM member order by member_name asc;";
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
    	<th>车号</th>
        <td><input name="CheHao" type="text" />
        </td>
    </tr>
    <tr>
    	<th>货物</th>
        <td><input name="goods_HuoWu" type="text" />
        </td>
    </tr>
    <tr>
    	<th>规格</th>
        <td><input name="goods_GuiGe" type="text" />
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        <input type="submit" value="查询" />
        </td>
  </tr>
</table>
</form>

<br />
<table class="tbl" width="1200" border="1">
  <tr>
    <th scope="col" width="80">单号</th>
    <th scope="col" width="100">车号</th>
    <th scope="col" width="100">单位</th>
    <th scope="col" width="80">货物</th>
    <th scope="col" width="80">规格</th>
    <th scope="col" width="80">净重</th>
    <th scope="col" width="80">密度</th>
    <th scope="col" width="80">单价</th>
    <th scope="col" width="80">金额</th>
    <th scope="col" width="80">余额</th>
    <th scope="col" width="80">备注</th>
  </tr>
<?php
  $sql  = "Select * FROM bill";
  $sql .= " WHERE ";
  if(strcmp($Start,'')!=0) $sql .= "bill_GuoBang2 >= '".$Start."' and "; // 开始时间
  if(strcmp($End,'')!=0) $sql .= "bill_GuoBang2 <= '".$End."' and "; // 结束时间
  if(strcmp($DanHao,'')!=0) $sql .= "bill_DanHao='".$DanHao."' and "; // 单号
  if(strcmp($Member,'')!=0) $sql .= "bill_DanWei='".$Member."' and "; // 客户
  if(strcmp($CheHao,'')!=0) $sql .= "bill_CheHao='".$CheHao."' and "; // 车号
  if(strcmp($Goods_HuoWu,'')!=0) $sql .= "bill_HuoWu='".$Goods_HuoWu."' and "; // 货物
  if(strcmp($Goods_GuiGe,'')!=0) $sql .= "bill_GuiGe='".$Goods_GuiGe."' and "; // 规格
  if(strcmp($Start,'')!=0 || strcmp($End,'')!=0 || strcmp($DanHao,'')!=0 || strcmp($Member,'')!=0 || strcmp($CheHao,'')!=0 || strcmp($Goods_HuoWu,'')!=0 || strcmp($Goods_GuiGe,'')!=0)
  {
	  $sql .= "1=1";
  }
  else
  {
	  $sql .= "1=0";
  }
  $sql .= ";";

  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['bill_id']."','".$row['bill_DanHao']."','".$row['bill_CheHao']."','".$row['bill_DanWei']."','".$row['bill_HuoWu']."','".$row['bill_GuiGe']."');>");
 	print("  <td>".$row['bill_DanHao']."</td>");
	print("  <td>".$row['bill_CheHao']."</td>");
  	print("  <td>".$row['bill_DanWei']."</td>");
  	print("  <td>".$row['bill_HuoWu']."</td>");
  	print("  <td>".$row['bill_GuiGe']."</td>");
  	print("  <td>".$row['bill_JingZhong']."</td>");
  	print("  <td>".$row['bill_MiDu']."</td>");
	print("  <td>".$row['bill_DanJia']."</td>");
	print("  <td>".$row['bill_JinE']."</td>");
	print("  <td>".$row['bill_YuE']."</td>");
	print("  <td>".$row['bill_BeiZhu']."</td>");
  	print("</tr>");
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
  	<th colspan="2">过磅单数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">单号：</td>
    <td><input type="text" name="DanHao" id="DanHao" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">车号：</td>
    <td><input type="text" name="CheHao" id="CheHao" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">单位：</td>
    <td><input type="text" name="DanWei" id="DanWei" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">货物：</td>
    <td><input type="text" name="HuoWu" id="HuoWu" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">规格：</td>
    <td><input type="text" name="GuiGe" id="GuiGe" readonly="readonly" /></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <th scope="col">&nbsp;</th>
        <th scope="col"><input type="button" name="Del" id="Del" value="删除" onclick="OnDel();" /></th>
        <th scope="col">&nbsp;</th>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>