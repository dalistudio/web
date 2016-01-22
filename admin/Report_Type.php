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

	////////////////////////
	// 输出 报表头
	// $Start 报表开始的时间
	// $End  报表截至的时间
	// $HeJi  时间段内销量的总计
	function get_Header($Start, $End, $HeJi)
	{
		print('<!Doctype html>');
		print('<html>');
		print('<head>');
		print('<title>销售统计报表</title>');
		print('<meta charset="utf-8">');
		print('</head>');
		print('<body>');

		print('<table border="1" width="900">');
		print('<tr align="center"><td colspan="6">海南证拓投资有限公司</td></tr>');
		print('<tr align="center"><td colspan="6">港口文峰石场分公司 -- 销售统计报表</td></tr>');
		print('<tr align="right"><td colspan="6">'.$Start.' 至 '.$End.'</td></tr>');
		print('<tr align="center"><td colspan="6">&nbsp;</td></tr>');
		print('<tr align="center"><td colspan="6">'.$HeJi.'</td></tr>');

		print('<tr align="center">');
		print('<td>序号</td>');
		print('<td>货物名</td>');
		print('<td>规格</td>');
		print('<td>销量(吨)</td>');
		print('<td>金额(元)</td>');
		print('<td>销量比(%)</td>');
		print('</tr>');
	}
	
	///////////////////
	// 输出 表内容的标题头
	// $Context 合并所有列，输出一条内容的记录
	function get_Body_Head($Context) {
		print('<tr align="center"><td colspan="5">'.$Context.'</td></tr>');
	}

	////////////////////
	// 输出 表内容的小计
	// $Weight 某类型的小计销售重量
	// $PCT     此类型占总计的比重
	function get_Body_HJ($Weight,$PCT) {
		print('<tr>');
		print('<td align="right" colspan="4">小计：</td>');
		print('<td align="center">'.$Weight.'</td>');
		print('<td align="center">'.$PCT.'</td>');
		print('</tr>');

		print('<tr align="center"><td colspan="5">&nbsp;</td></tr>');
	}

	////////////////////
	// 输出 表内容
	// $Id          序号
	// $HuoWu 货物名称
	// $GuiG     货物规格
	// $Weight  销售（吨）
	// $Money    金额（元）
	// $PCT      销售比（%）
	function get_Body($Id, $HuoWu, $GuiGe, $Weight, $Money , $PCT) {
		if($Weight == 0) return;

		print('<tr align="center">');
		print('<td>'.$Id.'</td>');
		print('<td>'.$HuoWu.'</td>');
		print('<td>'.$GuiGe.'</td>');
		print('<td>'.$Weight.'</td>');
		print('<td>'.$Money.'</td>');
		print('<td>'.$PCT .'</td>');
		print('</tr>');
	}

	/////////////////////
	/// 输出 页面结尾
	function get_Footer() {
		print('</table>');
		print('</body>');
		print('</html>');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
	// 输出 销量合计
	$HJ = get_HeJi($Start, $End);
	$JinE_HJ = get_JinE_HJ($Start, $End);
	$Context = "销量合计： " .round($HJ,2). " 吨" . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;销售金额合计：" .$JinE_HJ ."元";

	// 输出表头
	get_Header($Start, $End, $Context);
	//////////////////////////////////////////
	$Data = get_Type();
	$Id = 0;

	foreach ($Data as $key => $value){ 
		foreach($value as $HuoWu => $GuiGe){
			$Id = $Id +1;

//			print($HuoWu .' = '.$GuiGe);
//			print('<br>');
			// 这里循环输出 货物
			$Type_HJ = get_jingZhong($Start, $End, $HuoWu , $GuiGe);
			$Type_JE = get_jinE($Start, $End, $HuoWu , $GuiGe);
//print($Type_JE); print('<br>');
			get_Body($Id, $HuoWu , $GuiGe, $Type_HJ, $Type_JE, round($Type_HJ/$HJ,4)*100 );
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
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


	//////////////////
	// 2、累计 时间段和完整单据 的金额值，作为 “金额总合计”
	//   SELECT sum(bill_JinE)
	//       FROM stone.bill WHERE 
	//            bill_ZhuangTai>=1 AND 
	//            bill_GuoBang2>="2015-12-01" AND 
	//            bill_GuoBang2<="2015-12-31";
	function get_JinE_HJ($Start, $End) {
		$SQL = ' SELECT sum(bill_JinE) FROM stone.bill WHERE
			bill_ZhuangTai>=1 AND
			bill_GuoBang2>="'.$Start.'" AND 
			bill_GuoBang2<="'.$End.'";
		';

		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			// 合计此时间段内所有符合状态的单据 金额的总和。
			$HeJi = $row['sum(bill_JinE)'];  
			return $HeJi;
		}
	}

//	print(get_HeJi($Start, $End));


	///////////////////
	// 3、获得 type 表中的所有货物列表
	//  SELECT * FROM stone.type  ORDER BY type_HuoWu ASC; 
	// 
	function get_Type() {
		$SQL = '
			SELECT * FROM stone.type
			    ORDER BY type_HuoWu ASC;
		';
 
		$TypeArray = array(); // 声明一个空数组
		$Result=mysql_query($SQL);
		$Id = 0;
		while($row=mysql_fetch_array($Result))
		{
			$TypeArray[$Id] =array($row['type_HuoWu'] => $row['type_GuiGe']);
			$Id = $Id + 1;
		}
		return $TypeArray; // 返回数组
	}

//var_dump(get_Type());
/*
$Data = get_Type();
foreach ($Data as $key => $value){ 
	foreach($value as $HuoWu => $GuiGe){
		print($HuoWu .' = '.$GuiGe);
		print('<br>');
	}
}
*/
	//////////////////
	// 4、根据 时间段、单据状态查询 bill 表，获得货物净重的合计
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


	//////////////////
	// 5、根据 时间段、单据状态查询 bill 表，获得货物金额的合计
	//  SELECT sum(bill_JinE) FROM stone.bill WHERE
	//    bill_HuoWu = "半青石" AND
    	//    bill_GuiGe = "1.3" AND
	//    bill_ZhuangTai>=1 AND
	//    bill_GuoBang2>="2015-12-01" AND 
	//    bill_GuoBang2<="2015-12-31";
	//
	//  累计 bill_JinE 净重的值
	function get_jinE($Start, $End, $HuoWu, $GuiGe) {
		$SQL = ' SELECT sum(bill_JinE) FROM stone.bill WHERE
			bill_HuoWu = "'.$HuoWu.'" AND
			bill_GuiGe = "'.$GuiGe.'" AND
			bill_ZhuangTai>=1 AND
			bill_GuoBang2>="'.$Start.'" AND 
			bill_GuoBang2<="'.$End.'";
		';

		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			// 合计此时间段内所有符合状态的单据 金额的总和。
			$HeJi = $row['sum(bill_JinE)'] ;  
			return $HeJi;
		}
	}


?>
