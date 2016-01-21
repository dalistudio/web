<?php
//
// Copyright (c) 2014-2016, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../conn.php';

	// 从 POST 提交的数据中获得
	$Start = $_POST['start']; // 开始时间
	$End = $_POST['end']; // 结束时间

//	$Start = '2015-12-01';
//	$End = '2015-12-31';


	//////////////////
	// 1、累计 时间段和完整单据 的净重值，作为 “净重总合计”
	//   SELECT sum(bill_JingZhong)
	//       FROM stone.bill WHERE 
	//            bill_ZhuangTai>=1 AND 
	//            bill_GuoBang2>="2015-12-01" AND 
	//            bill_GuoBang2<="2015-12-31";
	function get_HeJi($Start, $End) {
		$SQL = ' SELECT sum(bill_JingZhong) FROM stone.bill WHERE
			bill_ZhuangTai>=1 AND
			bill_GuoBang2>="'.$Start.'" AND 
			bill_GuoBang2<="'.$End.'";
		';

		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			// 合计此时间段内所有符合状态的单据 净重的总和，并转换为吨。
			$HeJi = $row['sum(bill_JingZhong)'] / 1000;  
			return $HeJi;
		}
	}

//	print(get_HeJi($Start, $End));




	///////////////////
	// 2、获得 type 表中的所有货物列表
	//  SELECT * FROM stone.type  ORDER BY type_HuoWu ASC; 
	// 
	function get_Type() {
		$SQL = '
			SELECT * FROM stone.type
			    ORDER BY type_HuoWu ASC;
		';
 
		$TypeArray = array(); // 声明一个空数组
		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			$TypeArray[$row['type_HuoWu']] = $row['type_GuiGe'];
		}
		return $TypeArray; // 返回数组
	}

var_dump(get_Type());

	//////////////////
	// 3、根据 时间段、单据状态查询 bill 表，获得货物净重的合计
	//  SELECT sum(bill_JingZhong) FROM stone.bill WHERE
	//    bill_HuoWu = "半青石" AND
    	//    bill_GuiGe = "1.3" AND
	//    bill_ZhuangTai>=1 AND
	//    bill_GuoBang2>="2015-12-01" AND 
	//    bill_GuoBang2<="2015-12-31";
	//
	//  累计 bill_JingZhong 净重的值
	function get_jingZhong($Start, $End, $HuoWu, $GuiGe) {
		$SQL = ' SELECT sum(bill_JingZhong) FROM stone.bill WHERE
			bill_HuoWu = "'.$HuoWu.'" AND
			bill_GuiGe = "'.$GuiGe.'" AND
			bill_ZhuangTai>=1 AND
			bill_GuoBang2>="'.$Start.'" AND 
			bill_GuoBang2<="'.$End.'";
		';

		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			// 合计此时间段内所有符合状态的单据 净重的总和，并转换为吨。
			$HeJi = $row['sum(bill_JingZhong)'] / 1000;  
			return $HeJi;
		}
	}




?>
