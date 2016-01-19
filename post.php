<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include 'session.inc';
	include 'conn.php';
        
	$SiBangYuan = $_POST['SiBangYuan']; // 司磅员
	$FangXingYuan = $_POST['FangXingYuan']; // 放行员
	$ZhuangTai = $_POST['ZhuangTai']; // 状态，第一次过磅；第二次过磅；放行
	$DanHao = $_POST['DanHao']; // 单号
	$CheHao = $_POST['CheHao']; // 车号
	$CheXing = $_POST['CheXing']; // 车型
	$DianHua =  $_POST['DianHua']; // 电话
	$DanWei = $_POST['DanWei']; // 单位
	$HuoWu = $_POST['HuoWu']; // 货物
	$GuiGe = $_POST['GuiGe']; // 规格
	$PiZhong = $_POST['PiZhong']; // 皮重
	$MaoZhong = $_POST['MaoZhong']; // 毛重
	$JingZhong = $_POST['JiangZhong']; // 净重
	$DanJia = $_POST['DanJia']; // 单价
	$JinE = $_POST['JinE']; // 金额
	$BeiZhu = $_POST['BeiZhu']; // 备注信息
        
 	// 编码转换
	$CheHao = iconv('GB2312', 'UTF-8', $CheHao); // 车号
	$CheXing = iconv('GB2312', 'UTF-8', $CheXing); // 车型
	$DanWei = iconv('GB2312', 'UTF-8', $DanWei); // 单位
	$HuoWu = iconv('GB2312', 'UTF-8', $HuoWu); // 货物
	$BeiZhu = iconv('GB2312', 'UTF-8', $BeiZhu); // 备注
	$SiBangYuan = iconv('GB2312', 'UTF-8', $SiBangYuan); // // 司磅员
	$FangXingYuan = iconv('GB2312', 'UTF-8', $FangXingYuan); // 放行员
        
	date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
	$datetime = strtotime("now"); // 获得当前日期
	$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换为指定格式的字符串
        
	switch($ZhuangTai)
	{
		case 1:
		{
			// 第一次过磅
    
			$Arr = Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe); // 查询价目表
			
			//
			// 给 member 表添加 “信用额度” 和 “警告额度” 的字段
			// 将新添加的字段加入 Find_Goods() 返回
			//
			
			//
			// 判断 “警告额度” 和 “余额”，如果超过“警告额度”，则将警告信息写入单据备注“注意：您的余额不足，请尽快缴费。”。
			// 判断 “信用额度” 和 “余额”，如果超过“信用额度”，则禁止提交单据。
			//
			$Type = $Arr['Type']; // 支付类型，只处理预存和月结客户
			
			// 预存款客户
			if($Type == 1)
			{
				$YuE = $Arr['YuE']; // 余额
				$JingGao = $Arr['JingGao']; // 警告额度
				$XinYong = $Arr['XinYong']; // 信用额度
				
				// 比较余额和警告额度，输出注意信息到备注
				if(abs($YuE) >= abs($JingGao) && $JingGao != 0.00)
				{
					// 余额 大于等于 警告额度的时候，不需要打印警告信息。
					
				}else{
					// 余额 小于 警告额度的时候，则打印警告信息
					$BeiZhu = "注意：您的余额为 ".$YuE." ，请尽快缴费!!!";

					// 并判断 余额是否小于 信用额度
					// 比较余额和信用额度，返回“Credit”禁止提交到客户端
					if(abs($YuE) <= abs($XinYong) && $XinYong != 0.00)
					{
						print("Credit");
						exit(0);
					}
				}
			} // endif

			//月结款客户
			if($Type == 2)
			{
				$YuE = $Arr['YuE']; // 余额
				$JingGao = $Arr['JingGao']; // 警告额度
				$XinYong = $Arr['XinYong']; // 信用额度
				
				// 比较余额和警告额度，输出注意信息到备注
				if(abs($YuE) <= abs($JingGao) && $JingGao != 0.00)
				{
					// 余额 大于等于 警告额度的时候，不需要打印警告信息。
					
				}else{
					// 余额 小于 警告额度的时候，则打印警告信息
					$BeiZhu = "注意：您的余额为 ".$YuE." ，请尽快缴费!!!";

					// 并判断 余额是否小于 信用额度
					// 比较余额和信用额度，返回“Credit”禁止提交到客户端
					if(abs($YuE) >= abs($XinYong) && $XinYong != 0.00)
					{
						print("Credit");
						exit(0);
					}
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
                    print("post1"); // 成功
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
        
		case 2:
		{
            // 第二次过磅
            $sql  = "UPDATE bill SET ";
            $sql .= "bill_GuoBang2="."'".$mysqldate."',"; // 第二次过磅的日期时间
            $sql .= "bill_MaoZhong="."'".$MaoZhong."',"; // 毛重
            $sql .= "bill_JingZhong="."'".$JingZhong."',"; // 净重
            $sql .= "bill_DanJia="."'".$DanJia."',"; // 单价
            $sql .= "bill_JinE="."'".$JinE."',"; // 金额
            $sql .= "bill_BeiZhu="."'".$BeiZhu."',"; // 备注信息
            $sql .= "bill_SiBangYuan="."'".$SiBangYuan."',"; // 司磅员
            $sql .= "bill_ZhuangTai=1"; // 放行状态（可放行）
            $sql .= " WHERE ";
            $sql .= "bill_DanHao="."'".$DanHao."'"; // 单号
            $sql .= ";";
            if(inject_check($sql))
            {
                if(mysql_query($sql,$conn)) // 更新单据表
                    print("post2"); // 成功
                else
                    print("ERROR POST2:". mysql_error()); // 失败
            }
            
            // 判断如果是预存客户，需要减去相应费用。
            // 连接数据库读取所有会员的名字
            if(strcmp($DanWei,"零售")==0) // 零售用户
            {
                // 零售用户不需要修改余额
            }
            else // 预付款和月结用户
            {
                // 最后判定一下是否第二次提交已经完成。
                // 避免多次提交余额多次扣除。 可以采用先加上金额再扣除金额的方式，以后第三次提交修改后的金额。

                $member = "Select * FROM member WHERE member_name='".$DanWei."';";
                if(inject_check($member))
                {
                    $result=mysql_query($member); // 执行SQL语句
                }
        		
				$Member_YuE = 0.00; // 声明浮点数
                $row = mysql_fetch_array($result); // 获得记录
                $Member_YuE = $row['member_YuE']; // 会员的余额
                $Member_id = $row['member_id']; // 会员编号
            	
                $Member_YuE = $Member_YuE - $JinE; // 余额 = 余额 - 金额
				
				
// 屏蔽客户消费记录 2015-05-13
//				// 插入支付表
//				$pay  = "INSERT INTO pay SET ";
//				$pay .= "member_name='".$DanWei."',"; // 客户
//				$pay .= "bill_DanHao='".$DanHao."',"; // 账单号
//				$pay .= "pay_JinE='-".$Member_YuE."',"; // 消费的金额，注意'-'减号
//				$pay .= "pay_date='".$mysqldate."';"; // 消费的时间
//				mysql_query($pay); // 执行SQL语句
				
                // 将余额写入数据库
                $member  = "UPDATE member SET ";
                $member .= "member_YuE='".$Member_YuE."'"; // 余额
                $member .= " WHERE ";
                $member .= "member_id='".$Member_id."';"; // 单位
                mysql_query($member); // 执行SQL语句
            }
        
            mysql_close($conn); // 关闭数据库连接
            break;
		}
        
		case 3:
		{
			// 改单 第一次过磅单
			
			$Arr = Find_Goods($DanWei,$CheXing,$HuoWu,$GuiGe); // 查询价目表
			
			$sql  = "UPDATE bill SET ";
            $sql .= "bill_GuoBang1="."'".$mysqldate."',"; // 第一次过磅的日期时间
            $sql .= "bill_CheHao="."'".$CheHao."',"; // 车号
            $sql .= "bill_CheXing="."'".$CheXing."',"; // 车型 
            $sql .= "bill_DanWei="."'".$DanWei."',"; // 单位
            $sql .= "bill_HuoWu="."'".$HuoWu."',"; // 货物
            $sql .= "bill_GuiGe="."'".$GuiGe."',"; // 规格
			$sql .= "bill_DianHua="."'".$Arr['DianHua']."',"; // 电话
			$sql .= "bill_PiZhong="."'".$PiZhong."',"; // 皮重
//            $sql .= "bill_YuE="."'".$Arr['YuE']."',"; // 余额 // 2015-12-26 屏蔽改单提交余额
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
                    print("post3"); // 成功
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
                    print("post8"); // 成功
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
		'XinYong'=>$member_XinYong
		);
		return $Arr; // 返回数组
	}
?>
