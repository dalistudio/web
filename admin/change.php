<?php
//
// Copyright (c) 2014-2016, wangdali <wangdali@qq.com>, All Rights Reserved.
//
// 改单模块
//

	include '../session.inc';
	include '../conn.php';
	check_login();
	if($_SESSION['Level']!=0)
	{
		print("无权访问");
		die();
	}
	
	$DanHao = $_POST['DanHao'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>改单管理</title>
<script src="/js/WdatePicker.js"></script> 
<script src="/js/ajax.js"></script> 
<script>
	var xmlhttp = createXMLHttpRequest();

	// 获得单价
	function OnGetDanJia()
	{

		// 获得： 客户、车型、货物、规格
		var Member = document.getElementById("Member").value;
		var CheXing = document.getElementById("CheXing").value;
		var HuoWu = document.getElementById("HuoWu").value;
		var GuiGe = document.getElementById("GuiGe").value;

		var url = "/getdanjia.php?";
		url += "Member=";
		url += Member;
		url += "&CheXing=";
		url += CheXing;
		url += "&HuoWu=";
		url += HuoWu;
		url += "&GuiGe=";
		url += GuiGe;

//		alert(url);
		if (xmlhttp) {
			ajax(xmlhttp,"GET", url ,"",c);
 		}
		else {
    			alert ("Init xmlhttprequest fail"); // 初始化 XML HTTP 失败
		}

	}

	// 获得单价的返回函数
 	function c(val){
//		alert(val.responseText);
		var json = val.responseText;
		var obj = eval('(' + json + ')'); 
		document.getElementById("MiDu").value=obj.MiDu;
		document.getElementById("DanJia").value=obj.DanJia;
		document.getElementById("DanWei").value=obj.DanWei;
	}

	// 计算金额
	function OnGetJinE(type)
	{
//		alert("计算金额");
		var PiZhong = document.getElementById("PiZhong").value;
		var MaoZhong = document.getElementById("MaoZhong").value;
		var DanJia = document.getElementById("DanJia").value;
		var DanWei = document.getElementById("DanWei").value;
		var MiDu =  document.getElementById("MiDu").value;

		var JingZhong = MaoZhong -PiZhong;
		document.getElementById("JingZhong").value = JingZhong ;

		// 吨转立方：  立方=吨/密度
		var Dun = JingZhong/1000; // 计算吨数
		var LiFang = Dun/MiDu; // 计算立方数
		LiFang = LiFang.toFixed(4); // 精确到小数点后4位

		var JinE = 0;
		if(DanWei=="吨")
		{
			// 当 type=0 时，表示零售，需要舍去10元以下的金额
			JinE = Dun * DanJia; // 计算金额
		}
		else
		{
			// 当 type=0 时，表示零售，需要舍去10元以下的金额
			JinE = LiFang * DanJia; // 计算金额
		}
		JinE = JinE.toFixed(2);
 		document.getElementById("JinE").value = JinE;

	}

	// 提交改单
	function OnChange()
	{
		document.form1.action = "api/bill_change.php";
		document.form1.submit(); // 提交按钮
	}

	function OnRefund()
	{
		document.form1.action = "";
		document.form1.submit(); // 退款按钮
	}


	// 处理选择行事件
	function OnSelect(DanHao,DanWei,CheXing,HuoWu,GuiGe,PiZhong,MaoZhong,JinE)
	{
		//alert("test");
		document.getElementById("DanHao").value=DanHao;
		document.getElementById("DanWei").value=DanWei;
		document.getElementById("CheXing").value=CheXing;
		document.getElementById("HuoWu").value=HuoWu;
		document.getElementById("GuiGe").value=GuiGe;
		document.getElementById("PiZhong").value=PiZhong;
		document.getElementById("MaoZhong").value=MaoZhong;
		document.getElementById("JinE").value=JinE;
	}
</script>
</head>

<body>
<form id="Form_Find" method="post" action="change.php">
<table class="tbl" width="300" border="1">
	<tr>
    	<th colspan="2">查询条件</th>
    </tr>
  <tr>
    	<th>单号</th>
        <td><input name="DanHao" type="text" />
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        <input type="submit" value="查询" />
        </td>
  </tr>
</table>
</form>
<br>

<?php
  $sql  = "Select * FROM bill";
  $sql .= " WHERE ";
  $sql .= "bill_DanHao='".$DanHao."'"; // 单号
  $sql .= ";";

  $result=mysql_query($sql); // 执行SQL语句
  $row = mysql_fetch_array($result);
?>
<form id="form1" name="form1" method="get" action="">
<table class="tbl" width="1100" border="1">
  <tbody>
    <tr>
      <th align="center" style="font-weight: bold">原始 / 修改数据</th>
      <th align="center" style="font-weight: bold">原始 / 修改数据</th>
      <th align="center" style="font-weight: bold">原始 / 修改数据</th>
    </tr>
    <tr>
      <td bgcolor="#FFFD00">
		<label for="DanHao2">单号：</label>
		<input name="DanHao2" id="DanHao2" type="text" width="30" value="<?=$row['bill_DanHao']?>" readonly>
		类型：
		<?php
			$Type=$row['bill_Type'];
			$Str="";
			switch($Type)
			{
				case "0":
					$Str="零售";
					break;
				case "1":
					$Str="预付";
					break;
				case "2":
					$Str="月结";
					break;
			}
			print($Str);
		?>
      </td>
      <td bgcolor="#B8FF00">
        <label for="Member">客户：</label>
		<input type="text" width="30" value="<?=$row['bill_DanWei']?>" disabled>      
  	    <select name="Member" id="Member">
		<option value="<?=$row['bill_DanWei']?>"><?=$row['bill_DanWei']?>
		<?php
			$member_sql = "SELECT * FROM stone.member order by member_name ASC;";
			$member_result=mysql_query($member_sql); // 执行SQL语句
			 while($member_row = mysql_fetch_array($member_result)) // 循环每条记录
			{
				print("<option value=".$member_row['member_name'].">".$member_row['member_name']);
			}
		?>
  	    </select>
      </td>
      <td bgcolor="#FFFD00">
		<label for="CheXing">车型：</label>
		<input type="text" width="30" value="<?=$row['bill_CheXing']?>" disabled>      
		<select name="CheXing" id="CheXing" width="30">
			<option value="<?=$row['bill_CheXing']?>"><?=$row['bill_CheXing']?>
			<option value="大车">大车
			<option value="小车">小车
		</select>
	</td>
    </tr>
    <tr>
      <td bgcolor="#B8FF00">
        <label for="HuoWu">货物：</label>
		<input type="text" width="30" value="<?=$row['bill_HuoWu']?>" disabled>      
  	    <select name="HuoWu" id="HuoWu">
		<option value="<?=$row['bill_HuoWu']?>"><?=$row['bill_HuoWu']?>
		<?php
			$type_sql = "SELECT distinct type_HuoWu  FROM stone.type order by type_HuoWu ASC;";
			$type_result=mysql_query($type_sql); // 执行SQL语句
			 while($type_row = mysql_fetch_array($type_result)) // 循环每条记录
			{
				print("<option value=".$type_row['type_HuoWu'].">".$type_row['type_HuoWu']);
			}
		?>

  	    </select>
	</td>
      <td bgcolor="#FFFD00">
        <label for="GuiGe">规格：</label>
		<input type="text" width="30" value="<?=$row['bill_GuiGe']?>" disabled>      
		<select name="GuiGe" id="GuiGe">
			<option value="<?=$row['bill_GuiGe']?>"><?=$row['bill_GuiGe']?>
			<?php
			$type_sql2 = "SELECT distinct type_GuiGe  FROM stone.type order by type_GuiGe ASC;";
			$type_result2=mysql_query($type_sql2); // 执行SQL语句
			 while($type_row2 = mysql_fetch_array($type_result2)) // 循环每条记录
			{
				print("<option value=".$type_row2['type_GuiGe'].">".$type_row2['type_GuiGe']);
			}
			?>
		</select>
      </td>
      <td bgcolor="#B8FF00">
        <label for="CheHao">车号：</label>
		<input type="text" width="30" value="<?=$row['bill_CheHao']?>" disabled>      
		<input type="text" name="CheHao" id="CheHao" width="30"  value="<?=$row['bill_CheHao']?>">
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFD00">
        <label for="DanJia2">单价：</label>
		<input type="text" name="DanJia2" id="DanJia2" width="30" value="<?=$row['bill_DanJia']?>" disabled>      
		<input type="text" name="DanJia" id="DanJia" width="30" value="<?=$row['bill_DanJia']?>"  disabled>
      </td>
      <td bgcolor="#B8FF00">
        <label for="DanWei">单位：</label>
		<input type="text" width="30" value="<?=$row['bill_DanJiaDanWei']?>" disabled>      
		<input type="text" name="DanWei" id="DanWei" width="30" disabled>
      </td>
      <td bgcolor="#FFFD00">
        <label for="MiDu">密度：</label>
		<input type="text" width="30" value="<?=$row['bill_MiDu']?>" disabled>      
		<input type="text" name="MiDu" id="MiDu" width="30"  disabled>
      </td>
    </tr>
    <tr>
        <td colspan=3 align="center">
		<?php
			$ZhuangTai = $row['bill_ZhuangTai'];
			if($ZhuangTai=="1" || $ZhuangTai=="2")
			{
				print("<input type='button' name='GetDanJia' id='GetDanJia' value='1、获得单价' onclick='OnGetDanJia();' />");
				print("&nbsp&nbsp&nbsp&nbsp");
				print("<input type='button' name='GetJinE' id='GetJinE' value='2、计算金额' onclick='OnGetJinE(".$row['bill_Type'].");' />");

			}
			else
			{
				print("<input type='button' name='GetDanJia' id='GetDanJia' disabled  value='1、获得单价' onclick='OnGetDanJia();' />");
				print("&nbsp&nbsp&nbsp&nbsp");
				print("<input type='button' name='GetJinE' id='GetJinE' disabled  value='2、计算金额' onclick='OnGetJinE(".$row['bill_Type'].");' />");
			}
		?>

	
        </td>
     </tr>
    <tr>
      <td bgcolor="#B8FF00">
        <label for="PiZhong2">皮重：</label>
		<input type="text" name="PiZhong2" id="PiZhong2" width="30" value="<?=$row['bill_PiZhong']?>" disabled>      
		<input type="text" name="PiZhong" id="PiZhong" width="30" value="<?=$row['bill_PiZhong']?>">
      </td>
      <td bgcolor="#FFFD00">
        <label for="MaoZhong2">毛重：</label>
		<input type="text" name="MaoZhong2" id="MaoZhong2" width="30" value="<?=$row['bill_MaoZhong']?>" disabled>      
		<input type="text" name="MaoZhong" id="MaoZhong" width="30" value="<?=$row['bill_MaoZhong']?>">
      </td>
      <td bgcolor="#B8FF00">
        <label for="Jingzhong">净重：</label>
		<input type="text" width="30" value="<?=$row['bill_JingZhong']?>" disabled>      
		<input type="text" name="JingZhong" id="JingZhong" width="30"  disabled>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFD00">
        <label for="JinE">金额：</label>
		<input type="text" width="30" value="<?=$row['bill_JinE']?>" disabled>      
		<input type="text" name="JinE" id="JinE" width="30"  disabled>
      </td>
      <td bgcolor="#B8FF00">
        <label for="YuE">余额：</label>
		<input type="text" width="30" value="<?=$row['bill_YuE']?>" disabled>      
		<!-- input type="text" name="YuE" id="YuE" width="30"  readonly -->
      </td>
      <td bgcolor="#FFFD00">
        <label for="BeiZhu">备注：</label>
		<input type="text" width="30" value="<?=$row['bill_BeiZhu']?>" disabled>      
		<input type="text" name="BeiZhu" id="BeiZhu" width="30">
      </td>
    </tr>
    <tr>
      <td bgcolor="#B8FF00">
        <label for="GuoBang1">一次：</label>
		<input type="text" width="30" value="<?=$row['bill_GuoBang1']?>" disabled>
      </td>
      <td bgcolor="#FFFD00">
        <label for="GuoBang2">二次：</label>
		<input type="text" width="30" value="<?=$row['bill_GuoBang2']?>" disabled>
      </td>
      <td bgcolor="#B8FF00">
        <label for="ChuChang">出厂：</label>
		<input type="text" width="30" value="<?=$row['bill_ChuChang']?>" disabled>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFD00">
        <label for="SiBangYuan">司磅：</label>
		<input type="text" width="30" value="<?=$row['bill_SiBangYuan']?>" disabled>
      </td>
      <td bgcolor="#B8FF00">
        <label for="BaoAnYuan">保安：</label>
		<input type="text" width="30" value="<?=$row['bill_BaoAnYuan']?>" disabled>
      </td>
      <td bgcolor="#FFFD00">
        <label for="CaoZuoYuan">操作：</label>
		<input type="text" width="30" value="<?=$row['change_Op']?>" disabled>
      </td>
    </tr>
    <tr>
      <td colspan="3">
	<table width="100%" border="0">
	<tr>
		<th scope="col">
		<?php
			$ZhuangTai = $row['bill_ZhuangTai'];
			if($ZhuangTai=="1" || $ZhuangTai=="2")
			{
				print("<input type='button' name='Change' id='Change' value='3、提交改单' onclick='OnChange();' />");
				print("&nbsp;&nbsp;&nbsp;&nbsp;");
				print("<input type='button' name='Change' id='Change' value='退料' onclick='OnRefund();' />");

			}
			else
			{
				print("<input type='button' name='Change' id='Change'  disabled value='3、提交改单' onclick='OnChange();' />");
				print("&nbsp;&nbsp;&nbsp;&nbsp;");
				print("<input type='button' name='Change' id='Change'  disabled value='退料' onclick='OnRefund();' />");
			}
		?>
		</th>
	</tr>
      </table>
      </td>
    </tr>
  </tbody>
</table>
</form>
</body>
</html>