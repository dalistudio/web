<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

	include 'session.inc';
	include 'conn.php';
	
	$Id = $_GET['id']; // ����
	if($Id==0)
	{
		// ��ѯ���ݿ⣬���sys���е���������
		// ����1�����µĵ��š�
		$sql="Select * FROM sys WHERE sys_id=1;";
		$result=mysql_query($sql); // ִ��SQL���
		while($row = mysql_fetch_array($result)) // ѭ��ÿ����¼
		{
			$DanHao = $row['sys_DanHao']; // ����
		}
		$DanHao += 1; // ���� +1
		print('{"id":"'.$DanHao.'"}'); // ����JSON����
		
		// ���µ���
		$sql="UPDATE sys SET ";
		$sql .= "sys_DanHao="."'".$DanHao."'"; 
		$sql .= " WHERE ";
		$sql .= "sys_id=1";
		$sql .= ";";
		mysql_query($sql,$conn);
	}
	else // ��ñ��еĵ�������
	{
		$sql="Select * FROM bill WHERE bill_DanHao='".$Id."';"; // ���ݵ��Ų�ѯ����
		if(inject_check($sql))
		{
			$result=mysql_query($sql); // ִ��SQL���
		}
	
		$row = mysql_fetch_array($result);
		//while($row = mysql_fetch_array($result)) // ѭ��ÿ����¼
		{
			if(empty($row))
			{
				print('{');
				print('"id":"0"'); // ����IDΪ0����ʾ���ݿ���û���ҵ��������
				print('}');
			}
			else
			{
				print('{');
				print('"id":"'.$row['bill_DanHao'].'",'); // ����
				print('"ch":"'.$row['bill_CheHao'].'",'); // ����
				print('"cx":"'.$row['bill_CheXing'].'",'); // ����
				print('"dh":"'.$row['bill_DianHua'].'",'); // �绰
				print('"dw":"'.$row['bill_DanWei'].'",'); // ��λ
				print('"hw":"'.$row['bill_HuoWu'].'",'); // ����
				print('"gg":"'.$row['bill_GuiGe'].'",'); // ���
				print('"pz":"'.$row['bill_PiZhong'].'",'); // Ƥ��
				print('"mz":"'.$row['bill_MaoZhong'].'",'); // ë��
				print('"jz":"'.$row['bill_JingZhong'].'",'); // ����
				print('"dj":"'.$row['bill_DanJia'].'",'); // ����
				print('"djdw":"'.$row['bill_DanJiaDanWei'].'",'); // ���۵�λ
				print('"md":"'.$row['bill_MiDu'].'",'); // �ܶ�
				print('"je":"'.$row['bill_JinE'].'",'); // ���
				print('"ye":"'.$row['bill_YuE'].'",'); // ���
				print('"bz":"'.$row['bill_BeiZhu'].'",'); // ��ע
				print('"gb1":"'.$row['bill_GuoBang1'].'",'); // ��һ�ι���ʱ��
				print('"gb2":"'.$row['bill_GuoBang2'].'",'); // �ڶ��ι���ʱ��
				print('"cc":"'.$row['bill_ChuChang'].'",'); // ����ʱ��
				print('"sby":"'.$row['bill_SiBangYuan'].'",'); // ˾��Ա
				print('"bay":"'.$row['bill_BaoAnYuan'].'",'); // ����Ա
				print('"zt":"'.$row['bill_ZhuangTai'].'",'); // ״̬
				print('"type":"'.$row['bill_Type'].'"'); // ֧������
				print('}');
			}
			
		}
	}
	mysql_close($conn); // �ر����ݿ�����
?>