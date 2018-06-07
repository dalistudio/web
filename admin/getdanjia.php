<?php
	include '../session.inc';
	include '../conn.php';
	$Member = $_GET['Member'];
	$CheXing = $_GET['CheXing'];
	$HuoWu = $_GET['HuoWu'];
	$GuiGe = $_GET['GuiGe'];
	
	$sql = "SELECT member_name,goods_MiDu,goods_DanJia,goods_DanWei FROM stone.member,stone.goods";
	$sql .= " WHERE "; 
	$sql .= "member_name='";
	$sql .= $Member;
	$sql .= "' AND ";
	$sql .= "member.member_id=goods.member_id";
	$sql .= " AND ";
	$sql .= "goods_name='";
	$sql .= $HuoWu;
	$sql .= "' AND ";
	$sql .= "goods_GuiGe='";
	$sql .= $GuiGe;
	$sql .= "' AND ";
	$sql .= "goods_CheXing='";
	$sql .= $CheXing;
	$sql .= "';";

//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句
	$row = mysql_fetch_array($result); // 循环每条记录

	$MiDu = $row['goods_MiDu']; // 密度
	$DanJia = $row['goods_DanJia'];  // 单价
	$DanWei = $row['goods_DanWei']; // 单位
	
	$Str = '{';
	$Str .= '"Member" : "';
	$Str .= $Member;
	$Str .= '", "MiDu" : "';
	$Str .= $MiDu;
	$Str .= '", "DanJia" : "';
	$Str .= $DanJia;
	$Str .= '", "DanWei" : "';
	$Str .= $DanWei;
	$Str .= '"}';
	print($Str);
	
?>
