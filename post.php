<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include 'session.inc';
	include 'conn.php';
        
	@$SiBangYuan = $_POST['SiBangYuan']; // 司磅员
	@$FangXingYuan = $_POST['FangXingYuan']; // 放行员
	@$ZhuangTai = $_POST['ZhuangTai']; // 状态，第一次过磅；第二次过磅；放行
	@$DanHao = $_POST['DanHao']; // 单号
	@$CheHao = $_POST['CheHao']; // 车号
	@$CheXing = $_POST['CheXing']; // 车型
	@$DianHua =  $_POST['DianHua']; // 电话
	@$DanWei = $_POST['DanWei']; // 单位
	@$HuoWu = $_POST['HuoWu']; // 货物
	@$GuiGe = $_POST['GuiGe']; // 规格
	@$PiZhong = $_POST['PiZhong']; // 皮重
	@$MaoZhong = $_POST['MaoZhong']; // 毛重
	@$JingZhong = $_POST['JiangZhong']; // 净重
	@$DanJia = $_POST['DanJia']; // 单价
	@$JinE = $_POST['JinE']; // 金额
	@$BeiZhu = $_POST['BeiZhu']; // 备注信息
        
 	// 编码转换
	@$CheHao = iconv('GB2312', 'UTF-8', $CheHao); // 车号
	@$CheXing = iconv('GB2312', 'UTF-8', $CheXing); // 车型
	@$DanWei = iconv('GB2312', 'UTF-8', $DanWei); // 单位
	@$HuoWu = iconv('GB2312', 'UTF-8', $HuoWu); // 货物
	@$BeiZhu = iconv('GB2312', 'UTF-8', $BeiZhu); // 备注
	@$SiBangYuan = iconv('GB2312', 'UTF-8', $SiBangYuan); // // 司磅员
	@$FangXingYuan = iconv('GB2312', 'UTF-8', $FangXingYuan); // 放行员
        
	date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
	@$datetime = strtotime("now"); // 获得当前日期
	@$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换为指定格式的字符串
        
	switch($ZhuangTai)
	{
		// 第一次过磅
		case 1:
		{
			// 查询价目表（单位，车型，货物，规格）
			$Arr = Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe); 

			// “黑名单” 0=允许；1=禁止
			// 如果 “黑名单” 1=禁止， 则输出 “BlackList”，并结束
			$BlackList = $Arr['BlackList'];
			if($BlackList=="1")
			{
				print("BlackList");
				exit(0);
			}

			
			//
			// 判断 “警告额度” 和 “余额”，如果超过“警告额度”，则将警告信息写入单据备注“注意：您的余额不足，请尽快缴费。”。
			// 判断 “信用额度” 和 “余额”，如果超过“信用额度”，则禁止提交单据。
			//

			// 预存款客户 || 月结款客户
			$Type = $Arr['Type']; // 支付类型，只处理预存和月结客户
			if($Type == 1 || $Type == 2)
			{
				$YuE = $Arr['YuE']; // 余额
				$JingGao = $Arr['JingGao']; // 警告额度
				$XinYong = $Arr['XinYong']; // 信用额度
				
				// 比较余额和警告额度，输出注意信息到备注
				if($YuE <= $JingGao && $JingGao != 0.00)
				{
					// 余额 小于 警告额度的时候，则打印警告信息
					$BeiZhu = "注意：您的余额为 ".$YuE." ，请尽快缴费!!!";

					// 并判断 余额是否小于 信用额度
					// 比较余额和信用额度，返回“Credit”禁止提交到客户端
					if($YuE <= $XinYong && $XinYong != 0.00)
					{
						print("Credit");
						exit(0);
					}
					// 信用额度优先，这里输出警告信息
					print("JingGao:".$YuE."\0");
				}
			} // endif

			
			// 插入单据表	
			$sql = "INSERT INTO bill SET ";
			$sql .= "bill_GuoBang1="."'".$mysqldate."',"; // 第一次过磅的日期时间
			$sql .= "bill_DanHao="."'".$DanHao."',"; // 单号
			$sql .= "bill_CheHao="."'".$CheHao."',"; // 车号 
			$sql .= "bill_CheXing="."'".$CheXing."',"; // 车型。
			$sql .= "bill_DanWei="."'".$DanWei."',"; // 单位
			$sql .= "bill_HuoWu="."'".$HuoWu."',"; // 货物
			$sql .= "bill_GuiGe="."'".$GuiGe."',"; // 规格	
			$sql .= "bill_PiZhong="."'".$PiZhong."',"; // 皮重
			$sql .= "bill_BeiZhu="."'".$BeiZhu."',"; // 备注
			$sql .= "bill_ZhuangTai=0,"; // 不可放行
			$sql .= "bill_DianHua="."'".$Arr['DianHua']."',"; // 电话
			$sql .= "bill_YuE="."'".$Arr['YuE']."',"; // 余额
			$sql .= "bill_Type="."'".$Arr['Type']."',"; // 支付类型
			$sql .= "bill_MiDu="."'".$Arr['MiDu']."',"; // 密度
			$sql .= "bill_DanJiaDanWei="."'".$Arr['DanWei']."',"; // 单价单位
			$sql .= "bill_DanJia="."'".$Arr['DanJia']."'"; // 单价
			$sql .= ";";
	
			if(inject_check($sql))
			{
				if(mysql_query($sql,$conn)) // 执行插入单据表
				print("post1:".$mysqldate); // 成功
			else
				print("ERROR POST1:". mysql_error()); // 失败	
			}
            
			// 更新车辆信息表
			// 该判断是否插入还是更新
			$car  = "REPLACE INTO car SET ";
			$car .= "car_CheHao="."'".$CheHao."',"; // 车号
			$car .= "car_CheXing="."'".$CheXing."',"; // 车型
			$car .= "car_DanWei="."'".$DanWei."',"; // 单位
			$car .= "car_HuoWu="."'".$HuoWu."',"; // 货物
			$car .= "car_GuiGe="."'".$GuiGe."'"; // 规格
			$car .= ";";
			$result=mysql_query($car); // 执行SQL语句
    
			mysql_close($conn); // 关闭数据库连接
			break;
	
		}

		// 第二次过磅
		case 2:
		{
			// 检查余额
			// 查询价目表（单位，车型，货物，规格）
			$Arr = Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe); 

			// “黑名单” 0=允许；1=禁止
			// 如果 “黑名单” 1=禁止， 则输出 “BlackList”，并结束
			$BlackList = $Arr['BlackList'];
			if($BlackList=="1")
			{
				print("BlackList");
				exit(0);
			}

			// 预存款客户 || 月结款客户
			$Type = $Arr['Type']; // 支付类型，只处理预存和月结客户
			if($Type == 1 || $Type == 2)
			{
				$YuE = $Arr['YuE']; // 余额
				$JingGao = $Arr['JingGao']; // 警告额度
				$XinYong = $Arr['XinYong']; // 信用额度
				
				// 比较余额和警告额度，输出注意信息到备注
				if($YuE <= $JingGao && $JingGao != 0.00)
				{
					// 余额 小于 警告额度的时候，则打印警告信息
					$BeiZhu = "注意：您的余额为 ".$YuE." ，请尽快缴费!!!";

					// 并判断 余额是否小于 信用额度
					// 比较余额和信用额度，返回“Credit”禁止提交到客户端
					if($YuE <= $XinYong && $XinYong != 0.00)
					{
						print("Credit");
						exit(0);
					}
					// 信用额度优先，这里输出警告信息
					print("JingGao:".$YuE."\0");
				}
			} // endif


			// 开启事务
			mysql_query("BEGIN",$conn);

			// 在这里执行SQL语句
			// 更新的语句	
			$bill= "UPDATE bill SET ";
			$bill.= "bill_GuoBang2="."'".$mysqldate."',"; // 第二次过磅的日期时间
			$bill.= "bill_MaoZhong="."'".$MaoZhong."',"; // 毛重
 			$bill.= "bill_JingZhong="."'".$JingZhong."',"; // 净重
			$bill.= "bill_DanJia="."'".$DanJia."',"; // 单价
			$bill.= "bill_JinE="."'".$JinE."',"; // 金额
			$bill.= "bill_BeiZhu="."'".$BeiZhu."',"; // 备注信息
			$bill.= "bill_SiBangYuan="."'".$SiBangYuan."',"; // 司磅员
			$bill.= "bill_ZhuangTai=1"; // 放行状态（可放行）
			$bill.= " WHERE ";
			$bill.= "bill_DanHao="."'".$DanHao."'"; // 单号
			$bill.= ";";
			$res1 = mysql_query($bill,$conn); // 更新过磅单数据

 			if(strcmp($DanWei,"L零售")==0) // 零售用户
			{
				// 零售用户不需要修改余额
				if($res1){
					mysql_query("COMMIT",$conn); // 提交
					print("post2:".$mysqldate); // 成功
				}else{
					mysql_query("ROLLBACK",$conn); // 回滚
					print("ERROR POST2:". mysql_error()); // 失败
				}
				exit(0); // 退出
			}

			// 以下操作，只有预付款和月结用户需要减去相应费用

			// 获取余额数据
			$yue= "Select * FROM member WHERE member_name='".$DanWei."';";
			$res2 = mysql_query($yue,$conn); // 获得余额
			// 计算 新的余额
			$Member_YuE = 0.00; // 声明浮点数
			$row = mysql_fetch_array($res2 ); // 获得记录
			$Member_YuE = $row['member_YuE']; // 会员的余额
			$Member_id = $row['member_id']; // 会员编号
			$Member_YuE = $Member_YuE - $JinE; // 新余额 = 余额 - 金额

			// 插入支付表
			$pay  = "INSERT INTO pay SET ";
			$pay .= "member_name='".$DanWei."',"; // 客户
			$pay .= "bill_DanHao='".$DanHao."',"; // 账单号
			$pay .= "pay_JinE='-".$JinE."',"; // 消费的金额，注意'-'减号
			$pay .= "pay_YuE='".$Member_YuE."',"; // 余额
			$pay .= "pay_date='".$mysqldate ."',"; // 消费的时间
			$pay .= "pay_Type='1',"; // 消费类型 0=充值 1=消费 2=退款
			$pay .= "pay_Op='".$_SESSION['User']."';";
			$res3 = mysql_query($pay ,$conn); // 插入消费表

			// 将余额写入数据库
			$member  = "UPDATE member SET ";
			$member .= "member_YuE='".$Member_YuE."'"; // 余额
			$member .= " WHERE ";
			$member .= "member_id='".$Member_id."';"; // 单位
			$res4 = mysql_query($member ,$conn); // 更新余额表

			if($res1 && $res2 && $res3 && $res4){
				mysql_query("COMMIT",$conn); // 提交
				print("post2:".$mysqldate); // 成功
			}else{
				mysql_query("ROLLBACK",$conn); // 回滚
				print("ERROR POST2:". mysql_error()); // 失败
			}
         		      	mysql_close($conn); // 关闭数据库连接
			break;
		}

		// 改单 第一次过磅单
		case 3:
		{
			// 查询价目表
			$Arr = Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe); 
			
			$sql  = "UPDATE bill SET ";
			$sql .= "bill_GuoBang1="."'".$mysqldate."',"; // 第一次过磅的日期时间
			$sql .= "bill_CheHao="."'".$CheHao."',"; // 车号
			$sql .= "bill_CheXing="."'".$CheXing."',"; // 车型 
			$sql .= "bill_DanWei="."'".$DanWei."',"; // 单位
			$sql .= "bill_HuoWu="."'".$HuoWu."',"; // 货物
			$sql .= "bill_GuiGe="."'".$GuiGe."',"; // 规格
			$sql .= "bill_DianHua="."'".$Arr['DianHua']."',"; // 电话
			$sql .= "bill_PiZhong="."'".$PiZhong."',"; // 皮重
			$sql .= "bill_YuE="."'".$Arr['YuE']."',"; // 余额 
			$sql .= "bill_Type="."'".$Arr['Type']."',"; // 支付类型	
			$sql .= "bill_MiDu="."'".$Arr['MiDu']."',"; // 密度
			$sql .= "bill_DanJiaDanWei="."'".$Arr['DanWei']."',"; // 单价单位
			$sql .= "bill_DanJia="."'".$Arr['DanJia']."',"; // 单价
			$sql .= "bill_ZhuangTai=0"; // 第一次提交(改单)
			$sql .= " WHERE ";
			$sql .= "bill_DanHao="."'".$DanHao."'"; // 单号
			$sql .= ";";
			if(inject_check($sql))
			{
				if(mysql_query($sql,$conn)) // 更新单据表
				print("post3:".$mysqldate); // 成功
			else
				print("ERROR POST3:". mysql_error()); // 失败
			}
			break;
		}
		
		case 8:
		{
			// 门岗放行
			// 需要先查询第一次放行时间，然后计算是否超出1分钟，超出后不能继续放行。修改放行状态为3。
			$sql = "UPDATE bill SET ";
			$sql .= "bill_ChuChang="."'".$mysqldate."',"; // 车辆出场的日期时间
			$sql .= "bill_BaoAnYuan="."'".$FangXingYuan."',"; // 放行员(保安)	
			$sql .= "bill_ZhuangTai=2"; // 放行状态（已放行）
			$sql .= " WHERE ";
			$sql .= "bill_DanHao="."'".$DanHao."'"; // 单号
			$sql .= ";";
			if(inject_check($sql))
			{
				if(mysql_query($sql,$conn)) // 更新单据表
				print("post8:".$mysqldate); // 成功
			else
				print("ERROR POST8:". mysql_error()); // 失败	
			}
			mysql_close($conn); // 关闭数据库连接
			break;
		}
	}
	
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
		$goods .= "member.member_JingGao,"; // 客户的警告额度
		$goods .= "member.member_XinYong,"; // 客户的信用额度
		$goods .= "member.member_BlackList"; // 黑名单 0=允许 1=禁止
		
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

//print(iconv('UTF-8', 'GB2312', $goods));


		$number = mysql_num_rows($result); // 获得结果集中的记录条数

		if($result && $number != 0)
		{
			$row = mysql_fetch_array($result); // 获得记录
			$goods_DanJia = $row['goods_DanJia']; // 单价
			$goods_DanWei = $row['goods_DanWei']; // 单价的单位
			$goods_MiDu = $row['goods_MiDu']; // 密度
			$member_DianHua = $row['member_DianHua']; // 客户的电话
			$member_YuE = $row['member_YuE']; // 余额
			$member_Type = $row['member_Type']; // 支付类型
			$member_JingGao = $row['member_JingGao']; // 警告额度
			$member_XinYong = $row['member_XinYong']; // 信用额度
			$member_BlackList = $row['member_BlackList']; // 黑名单
		}
		else
		{
			// 找不到客户对应的货物价格记录，则打印输出 JiaGe，并退出脚本。
			print("JiaGe");
			exit(0);
		}
		$Arr = array(
		'DanJia'=>$goods_DanJia,
		'DanWei'=>$goods_DanWei,
		'MiDu'=>$goods_MiDu,
		'DianHua'=>$member_DianHua,
		'YuE'=>$member_YuE,
		'Type'=>$member_Type,
		'JingGao'=>$member_JingGao,
		'XinYong'=>$member_XinYong,
		'BlackList'=>$member_BlackList
		);
		return $Arr; // 返回数组
	}
?>
