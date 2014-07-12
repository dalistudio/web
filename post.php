<?php
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
	
	date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
	$datetime = strtotime("now"); // 获得当前日期
	$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换为指定格式的字符串
	
	if($ZhuangTai==4)
	{
		// 第一次过磅

		// 根据车型、单位、货物和规格
		// 从member和goods表中获得单价、密度、余额和电话等信息
		$goods  = "SELECT ";
		$goods .= "goods.goods_DanJia,"; // 单价
		$goods .= "goods.goods_DanWei,"; // 单价的单位
		$goods .= "goods.goods_MiDu,"; // 密度
		$goods .= "member.member_DianHua,"; // 客户电话
		$goods .= "member.member_YuE"; // 客户的余额
		$goods .= " FROM ";
		$goods .= "member,"; // 客户表
		$goods .= "goods"; // 价目表
		$goods .= " WHERE ";
		$goods .= "goods.member_id =member.member_id ";
		$goods .= "and ";
		$goods .= "member.member_name='".$DanWei."' "; // 单位
		$goods .= "and ";
		$goods .= "goods.goods_name='".$HuoWu."'"; // 货物
		$goods .= "and ";
		$goods .= "goods.goods_GuiGe='".$GuiGe."'"; // 规格
		$goods .= "and ";
		$goods .= "goods.goods_CheXing='".$CheXing."'"; // 车型
		$goods .= ";";
		$result=mysql_query($goods); // 执行SQL语句
		if($result)
		{
			$row = mysql_fetch_array($result); // 获得记录
			$goods_DanJia = $row['goods_DanJia']; // 单价
			$goods_DanWei = $row['goods_DanWei']; // 单价的单位
			$goods_MiDu = $row['goods_MiDu']; // 密度
			$member_DianHua = $row['member_DianHua']; // 客户的电话
			$member_YuE = $row['member_YuE']; // 余额
		}
		
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
		$sql .= "bill_ZhuangTai=0,"; // 不可放行
		$sql .= "bill_DianHua="."'".$member_DianHua."',"; // 电话
		$sql .= "bill_YuE="."'".$member_YuE."',"; // 余额
		$sql .= "bill_MiDu="."'".$goods_MiDu."',"; // 密度
		$sql .= "bill_DanJiaDanWei="."'".$goods_DanWei."',"; // 单位
		$sql .= "bill_DanJia="."'".$goods_DanJia."'"; // 单价
		$sql .= ";";
		if(inject_check($sql))
		{
			if(mysql_query($sql,$conn)) // 执行插入单据表
				print("post1"); // 成功
			else
				print("ERROR：". mysql_error()); // 失败
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
	}
	else if($ZhuangTai==6)
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
				print("ERROR：". mysql_error()); // 失败
		}
		
		// 判断如果是预存客户，需要减去相应费用。
		// 连接数据库读取所有会员的名字
		if(strcmp($DanWei,"零售")==0) // 零售用户
		{
			// 零售用户不需要修改余额
		}
		else // 预付款用户
		{
			// 最后判定一下是否第二次提交已经完成。
			// 避免多次提交余额多次扣除。 可以采用先加上金额再扣除金额的方式，以后第三次提交修改后的金额。
			$member = "Select * FROM member WHERE member_name='".$DanWei."';";
			if(inject_check($member))
			{
				$result=mysql_query($member); // 执行SQL语句
			}
	
			$row = mysql_fetch_array($result); // 获得记录
			$Member_YuE = $row['member_YuE']; // 会员的余额
			$Member_id = $row['member_id']; // 会员编号
		
			$Member_YuE = $Member_YuE - $JinE; // 余额 = 余额 - 金额
		
		
			// 将余额写入数据库
			$member  = "UPDATE member SET ";
			$member .= "member_YuE='".$Member_YuE."'"; // 余额
			$member .= " WHERE ";
			$member .= "member_id='".$Member_id."';"; // 单位
			if(inject_check($member))
			{
				$result=mysql_query($member); // 执行SQL语句
			}
		}
	
		mysql_close($conn); // 关闭数据库连接
	}
	else if($ZhuangTai==8)
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
				print("post3"); // 成功
			else
				print("ERROR：". mysql_error()); // 失败
		}
		mysql_close($conn); // 关闭数据库连接
	}
?>