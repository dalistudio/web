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

	///////////////////
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
		print('<tr align="center"><td colspan="5">海南证拓投资有限公司</td></tr>');
		print('<tr align="center"><td colspan="5">港口文峰石场分公司 -- 销售统计报表</td></tr>');
		print('<tr align="right"><td colspan="5">'.$Start.' 至 '.$End.'</td></tr>');
		print('<tr align="center"><td colspan="5">&nbsp;</td></tr>');
		print('<tr align="center"><td colspan="5">'.$HeJi.'</td></tr>');

		print('<tr align="center">');
		print('<td>序号</td>');
		print('<td>客户名</td>');
		print('<td>类型</td>');
		print('<td>销量(吨)</td>');
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
		print('<td align="right" colspan="3">小计：</td>');
		print('<td align="center">'.$Weight.'</td>');
		print('<td align="center">'.$PCT.'</td>');
		print('</tr>');

		print('<tr align="center"><td colspan="5">&nbsp;</td></tr>');
	}

	////////////////////
	// 输出 表内容
	// $Id         序号
	// $Name   客户名称
	// $Type   客户的类型
	// $Weight 销售（吨）
	// $PCT     销售比（%）
	function get_Body($Id, $Name, $Type, $Weight, $PCT) {
		if($Weight == 0) return;
		switch($Type) {
			case 0 : 
				$TypeName = "零售";
				break;
			case 1:
				$TypeName = "预付款";
				break;
			case 2:
				$TypeName="月结";
				break;
		}

		print('<tr align="center">');
		print('<td>'.$Id.'</td>');
		print('<td>'.$Name.'</td>');
		print('<td>'.$TypeName.'</td>');
		print('<td>'.$Weight.'</td>');
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
	// 2、获得 member 表中的所有 member_Type 客户列表
	//  SELECT * FROM stone.member WHERE member_Type=0;
	// 
	//  member_Type = 0 , 为 零售客户
	//  member_Type = 1 , 为 预存客户
	//  member_Type = 2 , 为 月结客户
	function get_Type($Type) {
		$SQL = '
			SELECT * FROM stone.member WHERE 
				member_Type='.$Type.' 
				order by member_name ASC;
		';

		$TypeArray = array(); // 声明一个空数组
		$Result=mysql_query($SQL);
		while($row=mysql_fetch_array($Result))
		{
			array_push($TypeArray ,$row['member_name']); // 将客户名 压入 数组
		}
		return $TypeArray; // 返回数组
	}
//	var_dump(get_Type(0));

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
	function get_jingZhong($Start, $End, $DanWei) {
		$SQL = ' SELECT sum(bill_JingZhong) FROM stone.bill WHERE
			bill_ZhuangTai>=1 AND
			bill_DanWei="'.$DanWei.'" AND 
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

//	print(get_jingZhong($Start, $End,"H华盛公司"));


	//////////////////
	// 4、根据 时间段、单据状态和 member_name = bill_DanWei 查询 bill 表
	//SELECT sum(bill_JingZhong) FROM stone.bill, stone.member WHERE
	//  member_Type = 0 And
	//  bill_DanWei = member_name AND
	//  bill_ZhuangTai>=1 AND 
	//  bill_GuoBang2>="2015-12-01" AND 
	//  bill_GuoBang2<="2015-12-31";
	//
	//  累计 bill_JingZhong 净重的值

	function get_Type_HJ($Start, $End, $Type) {
		$SQL = ' SELECT sum(bill_JingZhong) FROM stone.bill, stone.member WHERE
			member_Type = '.$Type.' AND
			bill_DanWei = member_name AND
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
/////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
	// 输出 销量合计
	$HJ = get_HeJi($Start, $End);
	$Context = "销量合计： " .round($HJ,2). " 吨";

	// 输出表头
	get_Header($Start, $End, $Context);

//////////////////////////////////////////	
for($Type=0;$Type<3;$Type++) {
	// 获得 某类型的客户列表
//	$Type = 0;
	$Member = get_Type($Type);

	$Id = 0;
	foreach($Member as $key => $Value) {
		

		// 获得指定客户的合计值
		$Mem_HJ = get_jingZhong($Start, $End,$Value);
		if($Mem_HJ !=0)$Id = $Id +1;
		get_Body($Id, $Value, $Type, round($Mem_HJ,2), round($Mem_HJ/$HJ,4)*100);
	}

	// 输出类型合计
	$Type_HJ = get_Type_HJ($Start, $End, $Type);
	get_Body_HJ($Type_HJ,  round($Type_HJ/$HJ,4)*100);	
}
/////////////////////////////////////////////////////

	get_Footer();



?>
