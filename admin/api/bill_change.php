<?php
//
// Copyright (c) 2016, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 磅单，改单功能
//
	include '../../session.inc';
	include '../../conn.php';
	$DanHao = $_GET['DanHao2']; // 单号
	$Member = $_GET['Member']; // 客户
	$CheXing = $_GET['CheXing']; // 车型
	$HuoWu = $_GET['HuoWu']; // 货物
	$GuiGe = $_GET['GuiGe']; // 规格
	$PiZhong = $_GET['PiZhong']; // 皮重
	$MaoZhong = $_GET['MaoZhong']; // 毛重
	$CheHao = $_GET['CheHao']; // 车号
	$BeiZhu = $_GET['BeiZhu']; // 备注

	date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
	$datetime = strtotime("now"); // 获得当前日期
	$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换为指定格式的字符串
exit(0);
/*
	// 测试输出
	print("单号：".$DanHao."<br>");
	print("客户：".$Member."<br>");
	print("车型：".$CheXing."<br>");
	print("货物：".$HuoWu."<br>");
	print("规格：".$GuiGe."<br>");
	print("皮重：".$PiZhong."<br>");
	print("毛重：".$MaoZhong."<br>");
	print("车号：".$CheHao."<br>");
	print("备注：".$BeiZhu."<br>");
*/

	// 01、开启事务
	mysql_query("BEGIN",$conn);
	/////////////////////////////////////////////////////////////////

	// 02、将 bill 表原始数据 复制到 change 表
	// 读取指定单号的磅单数据
	$bill_sql = "SELECT * FROM stone.bill WHERE bill_DanHao='".$DanHao."';";
	$bill_res = mysql_query($bill_sql,$conn); // 执行SQL
	$bill_row = mysql_fetch_array($bill_res );

	// 将原始磅单数据，插入改单数据表
	// 即：备份原始磅单数据，每次修改都要备份
	$change_sql = "INSERT INTO bill SET ";
	$change_sql .= "bill_DanHao="."'".bill_row['bill_DanHao']."',"; // 单号
	$change_sql .= "bill_CheHao="."'".bill_row['bill_CheHao']."',"; // 车号 
	$change_sql .= "bill_CheXing="."'".bill_row['bill_CheXing']."',"; // 车型
	$change_sql .= "bill_DanWei="."'".bill_row['bill_DanWei']."',"; // 客户
	$change_sql .= "bill_DianHua="."'".bill_row['bill_DianHu']."',"; // 电话
	$change_sql .= "bill_HuoWu="."'".bill_row['bill_HuoWu']."',"; // 货物
	$change_sql .= "bill_GuiGe="."'".bill_row['bill_GuiGe']."',"; // 规格	
	$change_sql .= "bill_PiZhong="."'".bill_row['bill_PiZhong']."',"; // 皮重
	$change_sql .= "bill_MaoZhong="."'".bill_row['bill_MaoZhong']."',"; // 毛重
	$change_sql .= "bill_JingZhong="."'".bill_row['bill_JingZhong']."',"; // 净重
	$change_sql .= "bill_DanJia="."'".bill_row['bill_DanJia']."',"; // 单价
	$change_sql .= "bill_DanJiaDanWei="."'".bill_row['bill_DanJiaDanWei']."',"; // 单价单位
	$change_sql .= "bill_MiDu="."'".bill_row['bill_MiDu']."',"; // 密度
	$change_sql .= "bill_JinE="."'".bill_row['bill_JinE']."',"; // 金额
	$change_sql .= "bill_YuE="."'".bill_row['bill_YuE']."',"; // 余额
	$change_sql .= "bill_BeiZhu="."'".bill_row['bill_BeiZhu']."',"; // 备注
	$change_sql .= "bill_ZhuangTai="."'".bill_row['bill_ZhuangTai']."',"; // 状态
	$change_sql .= "bill_GuoBang1="."'".bill_row['bill_GuoBang1']."',"; // 第1次过磅的日期时间
	$change_sql .= "bill_GuoBang2="."'".bill_row['bill_GuoBang2']."',"; // 第2次过磅的日期时间
	$change_sql .= "bill_ChuChang="."'".bill_row['bill_ChuChang']."',"; // 出厂的日期时间
	$change_sql .= "bill_SiBangYuan="."'".bill_row['bill_SiBangYuan']."',"; // 司磅员
	$change_sql .= "bill_BaoAnYuan="."'".bill_row['bill_BaoAnYuan']."',"; // 保安员
	$change_sql .= "bill_ZhuangTai="."'".bill_row['bill_ZhuangTai']."',"; // 状态
	$change_sql .= "bill_Type="."'".bill_row['bill_Type']."',"; // 支付类型
	$change_sql .= "change_Date="."'".mysqldate ."',"; // 改单时间
	$change_sql .= "change_Op='".$_SESSION['User']."'"; // 改单操作员
	$change_sql .= ";";

	$change_res = mysql_query($change_sql,$conn); // 执行SQL
	/////////////////////////////////////////////////////////////////

	// 03、根据 修改的内容 计算出修改的数据
	// 修改的内容可能有：1客户、2车型、3车号、4货物、5规格、6皮重、7毛重、8备注
	// 更新的内容可能有：1单价、2单位、3密度、4净重、5类型、6余额

	// A、根据1客户、2车型、4货物、5规格，取出：单价、单位、密度
	$goods_sql = "SELECT member_name,goods_MiDu,goods_DanJia,goods_DanWei FROM stone.member,stone.goods";
	$goods_sql .= " WHERE member_name='"; 
	$goods_sql .= $Member;
	$goods_sql .= "' AND member.member_id=goods.member_id";
	$goods_sql .= " AND goods_name='";
	$goods_sql .= $HuoWu;
	$goods_sql .= "' AND goods_GuiGe='";
	$goods_sql .= $GuiGe;
	$goods_sql .= "' AND goods_CheXing='";
	$goods_sql .= $CheXing;
	$goods_sql .= "';";
	$goods_res = mysql_query($goods_sql,$conn); // 执行SQL
	$goods_row = mysql_fetch_array($goods_res );

	// 这里取出：单价、单位和密度
	$DanJia = goods_row['goods_DanJia']; // 单价
	$DanWei = goods_row['goods_DanWei']; // 单位
	$MiDu = goods_row['goods_MiDu']; // 密度

	// B、根据6皮重、7毛重，计算出：净重，并转换为吨
	$JingZhong = $MaoZhong - $PiZhong; // 计算净重
	$Dun = JingZhong / 1000; // 转换为吨

	// C、根据单位（吨/立方）选择不同的算法计算出金额和余额
	$LiFang = $Dun / $MiDu; // 计算立方数

	$Old_JinE = bill_row['bill_JinE']; // 原始金额
	$New_JinE = 0; // 金额
	if(strcmp($DanWei, "吨")==0) // 吨
	{
		$New_JinE = $Dun * $DanJia; // 按吨计算金额
	}
	else // 立方
	{
		$New_JinE = $LiFang * $DanJia; // 按立方计算金额
	}

	// D、根据客户获得其支付的类型
	member_sql = "SELECT * FROM stone.member WHERE member_name='".$Member."';";
	$member_res = mysql_query($member_sql,$conn); // 执行SQL
	$member_row = mysql_fetch_array($member_res );
	$Type = $member_row['member_Type'];  // 客户的支付类型 0=零售 1=预付 2=月结
	$New_YuE = $member_row['member_YuE']; // 获得新客户的余额

	// 获得原始单据的客户信息
	member_sql2 = "SELECT * FROM stone.member WHERE member_name='".bill_row['bill_DanWei']."';"; // 原始单据的客户
	$member_res2 = mysql_query($member_sql2, $conn); // 执行SQL
	$member_row2 = mysql_fetch_array($member_res2);
	$Old_YuE = $member_row2['member_YuE']; // 获得老客户的余额

	// E、根据客户获取余额
	// 如果原始客户 ！= 修改的客户名，则取出两个客户的余额
	// 并分别对客户的余额进行加、减操作

	if(strcmp($Member, $bill_row['bill_DanWei'])==0) // 比较两客户是否相同
	{
		// 计算新的余额
		$Old_YuE = $Old_YuE +$Old_JinE； // 将金额退回去
		$Old_YuE = $Old_YuE - $New_JinE; // 根据新金额计算新余额

		// 更新 客户表
		$member_sql3  = "UPDATE member SET ";
		$member_sql3 .= "member_YuE='";
		$member_sql3 .= $Old_YuE;
		$member_sql3 .= "' WHERE ";
		$member_sql3 .= "member_name='";
		$member_sql3 .= bill_row['bill_DanWei'];
		$member_sql3 .= "';";
		$member_res3 = mysql_query($member_sql3, $conn); // 执行SQL
	}
	else // 不同
	{
		// 取出两个客户的余额
		$Old_YuE = $Old_YuE + $Old_JinE; // 将原金额加回老客户
		$New_YuE = $New_YuE - $New_JinE; // 将新金额从新客户减去
		
		// 更新 客户表
		$member_sql4  = "UPDATE member SET ";
		$member_sql4 .= "member_YuE='";
		$member_sql4 .= $Old_YuE;
		$member_sql4 .= "' WHERE ";
		$member_sql4 .= "member_name='";
		$member_sql4 .= bill_row['bill_DanWei']; // 老客户
		$member_sql4 .= "';";
		$member_res4 = mysql_query($member_sql4, $conn); // 执行SQL

		$member_sql5  = "UPDATE member SET ";
		$member_sql5 .= "member_YuE='";
		$member_sql5 .= $New_YuE;
		$member_sql5 .= "' WHERE ";
		$member_sql5 .= "member_name='";
		$member_sql5 .= $Member; // 新客户
		$member_sql5 .= "';";
		$member_res5 = mysql_query($member_sql5, $conn); // 执行SQL

	}

	// F、直接更新3车号和8备注
	// 无需处理

	/////////////////////////////////////////////////////////////////

	// 04、对磅单表进行更新
	// 更新内容有：1客户、2车型、3车号、4货物、5规格、6皮重、7毛重、8备注
	//                    1单价、2单位、3密度、4净重、5类型、6余额、7金额
	$bill_sql2 = "UPDATE bill SET ";
	$bill_sql2 .= "bill_DanWei="."'".$Member."',"; // 单位
	$bill_sql2 .= "bill_CheXing ="."'".$CheXing."',"; // 车型
	$bill_sql2 .= "bill_CheHao="."'".$CheHao."',"; // 车号
	$bill_sql2 .= "bill_HuoWu="."'".$HuoWu."',"; // 货物
	$bill_sql2 .= "bill_GuiGe="."'".$GuiGe."',"; // 规格
	$bill_sql2 .= "bill_PiZhong="."'".$PiZhong."',"; // 皮重
	$bill_sql2 .= "bill_MaoZhong="."'".$MaoZhong."',"; // 毛重
	$bill_sql2 .= "bill_JingZhong="."'".$JingZhong."',"; // 净重
	$bill_sql2 .= "bill_DanJia="."'".$DanJia."',"; // 单价
	$bill_sql2 .= "bill_DanJiaDanWei="."'".$DanJiaDanWei."',"; // 单价单位
	$bill_sql2 .= "bill_MiDu="."'".$MiDu."',"; // 密度
	$bill_sql2 .= "bill_JinE="."'".$JinE."',"; // 金额
	$bill_sql2 .= "bill_YuE="."'".$YuE."',"; // 余额
	$bill_sql2 .= "bill_BeiZhu="."'".$BeiZhu."',"; // 备注
	$bill_sql2 .= "bill_Type="."'".$Type."',";; // 支付类型
	$bill_sql2 .= " WHERE ";
	$bill_sql2 .= "bill_DanHao="."'".$DanHao."'"; // 单号
	$bill_sql2 .= ";";
	$bill_res2 = mysql_query($bill_sql2 ,$conn); // 更新过磅单数据

	/////////////////////////////////////////////////////////////////

	// 05、提交SQL，并执行
	if($bill_res && $change_res && $goods_res && $member_res && $member_res2 && $bill_res2)
	{
		mysql_query("COMMIT",$conn); // 提交
		print("改单提交成功~");
	}
	else
	{
		mysql_query("ROLLBACK",$conn); // 回滚
		print("失败！！！，数据回滚！！！");

	}

?>