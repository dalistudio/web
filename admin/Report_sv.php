<?php
//
// Copyright (c) 2014-2016, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../conn.php';

	// 从 POST 提交的数据中获得
	$Start = $_POST['start']; // 开始时间
	$End = $_POST['end']; // 结束时间

	///////////////////
	// 1、获得 member 表中的所有 member_Type 客户列表
	//  SELECT * FROM stone.member WHERE member_Type=0;
	// 
	//  member_Type = 0 , 为 零售客户
	//  member_Type = 1 , 为 预存客户
	//  member_Type = 2 , 为 月结客户



	//////////////////
	// 2、累计 时间段和完整单据 的净重值，作为 “净重总合计”
	//   SELECT sum(bill_JingZhong)
	//       FROM stone.bill WHERE 
	//            bill_ZhuangTai>=1 AND 
	//            bill_GuoBang2>="2015-12-01" AND 
	//            bill_GuoBang2<="2015-12-31";



	//////////////////
	// 3、根据 时间段、单据状态和 member_name = bill_DanWei 查询 bill 表
	//   SELECT sum(bill_JingZhong)
	//       FROM stone.bill WHERE 
	//            bill_ZhuangTai>=1 AND 
	//            bill_DanWei="H华盛公司" AND 
	//            bill_GuoBang2>="2015-12-01" AND 
	//            bill_GuoBang2<="2015-12-31";
	//
	//  累计 bill_JingZhong 净重的值



	/////////////////
	// 4、计算 客户净重合计与销量净重总合计 的比重
	// 销量比重 = 客户净重合计 / 销量净重总合计 × 100%

?>
