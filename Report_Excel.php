<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include 'conn.php';

	$Start = $_POST['start']; // 开始时间
	$End = $_POST['end']; // 结束时间
	$CheHao = $_POST['CheHao']; // 车号
	$CheXing = $_POST['CheXing']; // 车型
	$DanWei = $_POST['DanWei']; // 单位
	$HuoWu = $_POST['HuoWu']; // 货物
	$GuiGe = $_POST['GuiGe']; // 规格
	$Type = $_POST['Type']; // 支付类型
	$SiBangYuan = $_POST['SiBangYuan']; // 司磅员

	// 测试用
//	$Start = '2014-07-10 00:00:00'; // 开始时间
//	$End = '2014-07-13 23:00:00'; // 结束时间
//	$CheHao = ''; // 车号
//	$CheXing = ''; // 车型
//	$DanWei = ''; // 单位
//	$HuoWu = ''; // 货物
//	$GuiGe = ''; // 规格

	// 编码转换
	$SiBangYuan = iconv('GB2312', 'UTF-8', $SiBangYuan); // 司磅员
	
	// 错误报告 
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	
	date_default_timezone_set('PRC'); // 中国+8时区

	if (PHP_SAPI == 'cli') // 判断如果是PHP客户端
		die('这个代码只能在Web浏览器中运行。');
	
	require_once dirname(__FILE__) . '/excel/Classes/PHPExcel.php'; // 引入EXCEL类
	$objPHPExcel = new PHPExcel(); // 创建EXCEL对象
	$objPHPExcel->getProperties()->setCreator("wangdali") // 创建者
							 ->setLastModifiedBy("wangdali") // 最后修改者
							 ->setTitle("Stone Report") // 标题
							 ->setSubject("Shift report") // 子标题
							 ->setDescription("Sales ledger") // 描述
							 ->setKeywords("report") // 关键字
							 ->setCategory("report"); // 类别

//***********************画出单元格边框*****************************  
    $styleArray = array(  
        'borders' => array(  
            'outline' => array(  
                'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框  
                //'color' => array('argb' => 'FFFF0000'),  
            ),  
        ),  
    );  
	
	$styleArrayBold = array(  
        'borders' => array(  
            'outline' => array(  
                'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的 
                //'color' => array('argb' => 'FFFF0000'),  
            ),  
        ),  
    );  
//这里就是画出从单元格A5到N5的边框，看单元格最右边在哪哪个格就把这个N改为那个字母替代 
//    $objWorksheet->getStyle('A5:N'.$n)->applyFromArray($styleArray); 
//***********************画出单元格边框结束*****************************   

	// 报表名称
	switch($Type)
	{
		case "":
			$Title = "全部客户报表";
			break;
		case "0":
			$Title = "零售客户报表";
			break;
		case "1":
			$Title = "预存款客户报表";
			break;
		case "2":
			$Title = "月结客户报表";
			break;
	}

	//////////////////////////////////////////////////////////////////
	// 这里输出 头部数据
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8); // 设置A列的宽度
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:L1'); // 合并字段
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', $Title); // 标题
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('宋体' ); // 字体
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // 大小
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); // 粗体
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平方向上中间居中
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray); 
	
	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
	$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
	$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
	$objPHPExcel->getActiveSheet()->mergeCells('G2:H2');
	$objPHPExcel->getActiveSheet()->mergeCells('I2:J2');
	$objPHPExcel->getActiveSheet()->mergeCells('K2:L2');
	$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('C2:D2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E2:F2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G2:H2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('I2:J2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->applyFromArray($styleArray);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', '开始时间：')
	->setCellValue('C2', $Start)
	->setCellValue('G2', '结束时间：')
	->setCellValue('I2', $End)
	->setCellValue('K2', '单位(元)');
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', '序号')
	->setCellValue('B3', '单号')
	->setCellValue('C3', '车号')
	->setCellValue('D3', '车型')
	->setCellValue('E3', '客户')
	->setCellValue('F3', '货物')
	->setCellValue('G3', '规格')
	->setCellValue('H3', '吨')
	->setCellValue('I3', '立方')
	->setCellValue('J3', '金额')
	->setCellValue('K3', '司磅员')
	->setCellValue('L3', '备注');
	$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('C3:C3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('D3:D3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E3:E3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('F3:F3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('I3:I3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('J3:J3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('K3:K3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L3:L3')->applyFromArray($styleArray);
	//////////////////////////////////////////////////////////////////
	// 货物类型表
	$type_sql  = "SELECT * FROM type;";
	$type_result=mysql_query($type_sql); // 执行SQL语句
	
	$Id = 0; // 类型数
	$excel_pos = 4; // 行号
	
	$XJD ='';
	$XJF ='';
	$XJJ ='';
	while($type_row = mysql_fetch_array($type_result)) // 循环货物类型表
	{
		if(strcmp($HuoWu,'')==0 && strcmp($GuiGe,'')==0) // 如果货物和规格为空，则循环所有货物
		{
			$HuoWu2 = $type_row['type_HuoWu'];
			$GuiGe2 = $type_row['type_GuiGe'];
		}
		else // 否则，只显示指定货物下的所有规格
		{
			// 如果货物和规格都不为空
			if(strcmp($HuoWu,'')!=0 && strcmp($GuiGe,'')!=0)
			{
				if(strcmp($HuoWu,$type_row['type_HuoWu'])==0 && strcmp($GuiGe,$type_row['type_GuiGe'])==0)
				{
					$HuoWu2 = $HuoWu;
					$GuiGe2 = $GuiGe;
				}
				else
				{
					continue;
				}
			}
			
			// 如果货物为空，规格不为空
			if(strcmp($HuoWu,'')==0 && strcmp($GuiGe,'')!=0)
			{
				// 不处理，都跳过
				continue;
			}
			
			// 如果货物不为空，规格为空
			if(strcmp($HuoWu,'')!=0 && strcmp($GuiGe,'')==0)
			{
				if(strcmp($HuoWu,$type_row['type_HuoWu'])==0)
				{
					$HuoWu2 = $HuoWu;
					$GuiGe2 = $type_row['type_GuiGe'];
				}
				else
				{
					continue;
				}
			}
		} // if end
		
		
		// 单据表
		$bill_sql  = "SELECT * FROM bill WHERE ";
		$bill_sql .= "bill_GuoBang2 >= '".$Start."' and "; // 开始时间
		$bill_sql .= "bill_GuoBang2 <= '".$End."' and "; // 结束时间
		if(strcmp($CheHao,'')!=0)$bill_sql .= "bill_CheHao='".$CheHao."' and "; // 车号
		if(strcmp($CheXing,'')!=0)$bill_sql .= "bill_CheXing='".$CheXing."' and "; // 车型
		if(strcmp($DanWei,'')!=0)$bill_sql .= "bill_DanWei='".$DanWei."' and "; // 单位
		if(strcmp($HuoWu2,'')!=0)$bill_sql .= "bill_HuoWu='".$HuoWu2."' and "; // 货物
		if(strcmp($GuiGe2,'')!=0)$bill_sql .= "bill_GuiGe='".$GuiGe2."' and "; // 规格
		if(strcmp($Type,'')!=0)$bill_sql .= "bill_Type='".$Type."' and "; // 支付类型
		if(strcmp($SiBangYuan,'')!=0)$bill_sql .= "bill_SiBangYuan='".$SiBangYuan."' and "; // 司磅员
		$bill_sql .= "bill_ZhuangTai=1"; // 完成第二次过磅的单
		$bill_sql .= " ORDER BY bill_HuoWu DESC "; // 按货物进行排序
		$bill_sql .= ";";
	
//		print($bill_sql.'<br />');

		$bill_result = mysql_query($bill_sql); // 执行SQL语句
		$XiaoJi_Dun = 0; // 小计吨
		$XiaoJi_Pos = $excel_pos-1;
		while($bill_row = mysql_fetch_array($bill_result)) // 循环每条记录
		{
			// 这里显示表的内容
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$excel_pos, '=SUM(ROW()-ROW(A'.$XiaoJi_Pos.':H'.$XiaoJi_Pos.'))') // 通过行计算编号
			->setCellValue('B'.$excel_pos, $bill_row['bill_DanHao']) // 单号	
			->setCellValueExplicit('C'.$excel_pos, $bill_row['bill_CheHao'], PHPExcel_Cell_DataType::TYPE_STRING) // 车号	
			->setCellValue('D'.$excel_pos, $bill_row['bill_CheXing']) // 车型
			->setCellValue('E'.$excel_pos, $bill_row['bill_DanWei']) // 单位
			->setCellValue('F'.$excel_pos, $type_row['type_HuoWu']) // 货物
			->setCellValue('G'.$excel_pos, $type_row['type_GuiGe']) // 规格
			->setCellValue('H'.$excel_pos, round($bill_row['bill_JingZhong']/1000,2)) // 吨
			->setCellValue('I'.$excel_pos, round($bill_row['bill_JingZhong']/1000/$bill_row['bill_MiDu'],2)) // 立方
			->setCellValue('J'.$excel_pos, $bill_row['bill_JinE']) // 金额
			->setCellValue('K'.$excel_pos, $bill_row['bill_SiBangYuan']) // 司磅员
			->setCellValue('L'.$excel_pos, $bill_row['bill_BeiZhu']); // 备注
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':A'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$excel_pos.':B'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$excel_pos.':C'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$excel_pos.':D'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$excel_pos.':E'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$excel_pos.':F'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':J'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$excel_pos.':K'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$excel_pos.':L'.$excel_pos)->applyFromArray($styleArray);
			
			$excel_pos +=1; // 计算行号
			$XiaoJi_Dun += $bill_row['bill_JingZhong']; // 小计吨
		} // bill
		// 输出小计
		if(strcmp($XiaoJi_Dun,'0')!=0) // 小计吨为0则不输出这个类型
		{
			$Id +=1;
			$objPHPExcel->getActiveSheet()->mergeCells('K'.$excel_pos.':L'.$excel_pos);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$excel_pos.':L'.$excel_pos)->applyFromArray($styleArray);
			$PrePos = $excel_pos-1; // 前一行
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('G'.$excel_pos, '小计：')
			->setCellValue('H'.$excel_pos, '=SUM(H'.$XiaoJi_Pos.':H'.$PrePos.')') // 使用公式计算小计
			->setCellValue('I'.$excel_pos, '=SUM(I'.$XiaoJi_Pos.':I'.$PrePos.')') // 使用公式计算小计
			->setCellValue('J'.$excel_pos, '=SUM(J'.$XiaoJi_Pos.':J'.$PrePos.')')// 使用公式计算小计
			; // 结束
			
			if($Id==1)
			{
				$XJD .= ('H'.$excel_pos);
				$XJF .= ('I'.$excel_pos);
				$XJJ .= ('J'.$excel_pos);
			}
			else
			{
				$XJD .= ('+H'.$excel_pos);
				$XJF .= ('+I'.$excel_pos);
				$XJJ .= ('+J'.$excel_pos);
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArrayBold);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArrayBold);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':J'.$excel_pos)->applyFromArray($styleArrayBold);

			$excel_pos +=1; // 计算行号
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$excel_pos.':L'.$excel_pos);
			$excel_pos +=1; // 计算行号
		}
		
	} // type
	
	//////////////////////////////////////////////////////////////////
	// 这里输出 HTML
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('G'.$excel_pos, '合计：')
		->setCellValue('H'.$excel_pos, '=SUM('.$XJD.')')
		->setCellValue('I'.$excel_pos, '=SUM('.$XJF.')')
		->setCellValue('J'.$excel_pos, '=SUM('.$XJJ.')')
		; // 结束
			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':J'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$excel_pos.':L'.$excel_pos)->applyFromArray($styleArrayBold);

	$excel_pos +=2;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$excel_pos, '审核人：')
		->setCellValue('D'.$excel_pos, '出纳：')
		->setCellValue('G'.$excel_pos, '组长：')
		->setCellValue('J'.$excel_pos, '收款人：');
	$excel_pos +=1;
	$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$excel_pos)->applyFromArray($styleArray); // 外框
		
	$objPHPExcel->getActiveSheet()->setTitle($Title); // 修改报表标题
	$objPHPExcel->setActiveSheetIndex(0);

	//////////////////////////////////////////////////////////////////
	// 重定向输出到客户的Web浏览器 (Excel5)
	header('Content-Type: application/vnd.ms-excel'); // 设置文件类型
	header('Content-Type: application/vnd.ms-excel;charset=utf-8'); // 设置文件编码
	header('Content-Disposition: attachment;filename="Report.xls"'); // 以附件方式下载，及设置默认文件名
	header('Cache-Control: max-age=0');
	// 如果你使用IE9，则可能需要：
	header('Cache-Control: max-age=1');

	// 如果你使用 IE 的 SSL，则可能需要：
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // 最后修改日期
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
?>