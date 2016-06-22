<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
//	include 'session.inc';
	include 'conn.php';

        print("aaaaaa<br>");
	Find_Goods("伍小宝","大车","大片石","0");
	print("bbbbbbbbbbb<br>");
	function Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe)
	{
		// 根据车型、单位、货物和规格
		// 从member和goods表中获得单价、密度、余额和电话等信息
		$goods  = "SELECT ";
		$goods .= "goods.goods_DanJia,"; // 单价
		$goods .= "goods.goods_DanWei,"; // 单价的单位
		$goods .= "goods.goods_MiDu,"; // 密度
		$goods .= "member.member_DianHua,"; // 客户电话
		$goods .= "member.member_YuE,"; // 客户的余额
		$goods .= "member.member_Type,"; // 客户的支付类型 0=零售 1=预付 2=月结
		//
		// 在 member 表添加新的字段
		//
		$goods .= "member.member_JingGao,"; // 客户的警告额度
		$goods .= "member.member_XinYong"; // 客户的信用额度
		
		$goods .= " FROM ";
		$goods .= "member,"; // 客户表
		$goods .= "goods"; // 价目表
		$goods .= " WHERE ";
		$goods .= "goods.member_id =member.member_id ";
		$goods .= " and ";
		$goods .= "member.member_name='".$DanWei."' "; // 单位
		$goods .= " and ";
		$goods .= "goods.goods_name='".$HuoWu."'"; // 货物
		$goods .= " and ";
		$goods .= "goods.goods_GuiGe='".$GuiGe."'"; // 规格
		$goods .= " and ";
		$goods .= "goods.goods_CheXing='".$CheXing."'"; // 车型
		$goods .= ";";
		$result=mysql_query($goods); // 执行SQL语句


$number = mysql_num_rows($result);
		if($result && $number != 0)
		{
			$row = mysql_fetch_array($result); // 获得记录
			$goods_DanJia = $row['goods_DanJia']; // 单价
			$goods_DanWei = $row['goods_DanWei']; // 单价的单位
			$goods_MiDu = $row['goods_MiDu']; // 密度
			$member_DianHua = $row['member_DianHua']; // 客户的电话
			$member_YuE = $row['member_YuE']; // 余额
			$member_Type = $row['member_Type']; // 支付类型

			//
			// 添加新的返回结果到数组
			//
			$member_JingGao = $row['member_JingGao']; // 警告额度
			$member_XinYong = $row['member_XinYong']; // 信用额度
		}
		else
		{
			// 找不到客户对应的货物价格记录，则打印输出 JiaGe，并退出脚本。
			print("JiaGe");
//			exit(0);
		}
		$Arr = array(
		'DanJia'=>$goods_DanJia,
		'DanWei'=>$goods_DanWei,
		'MiDu'=>$goods_MiDu,
		'DianHua'=>$member_DianHua,
		'YuE'=>$member_YuE,
		'Type'=>$member_Type,
		'JingGao'=>$member_JingGao,
		'XinYong'=>$member_XinYong
		);
		return $Arr; // 返回数组
	}
?>