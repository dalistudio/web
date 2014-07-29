<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

/**
 * @desc php,mysql数据库备份
 * @author mengdejun
 * @date 201011202222
 */
include '../../session.inc';
include '../../conn.php';
	

	//发送数据库命令
	function send($sql,$conn)
	{
		mysql_query($sql,$conn);
	}
	//枚举数据库表
	function list_tables($database,$conn)
	{
	    $rs = mysql_list_tables($database,$conn);
	    $tables = array();
	    while ($row = mysql_fetch_row($rs)) 
	    {
	        $tables[] = $row[0];
	    }
	    mysql_free_result($rs);
	    return $tables;
	}
	//导出数据库数据
	function get_table_data($table,$conn)
	{
		//$tables=null;
	    $rs=mysql_query("SELECT * FROM `{$table}`",$conn);
	    while ($row=mysql_fetch_row($rs))
	    {
	        $tables.=$this->get_insert_sql($table, $row);
	    }
	    mysql_free_result($rs);
	    return $tables;
	}
	//导出数据库结构
	function get_table_structure($table,$conn)
	{
		print($conn);
		$a=mysql_query("show create table `{$table}`",$conn);
		$row=mysql_fetch_assoc($a);
		return $row['Create Table'].';';//导出表结构
	}
	//获取insert语句
	function get_insert_sql($table,$row)
	{
	    $sql = "INSERT INTO `{$table}` VALUES (";
	    $values = array();
	    foreach ($row as $value)
	    {
	        $values[] = "'".mysql_real_escape_string($value)."'";
	    }
	    $sql.=implode(',',$values).");";
	    return $sql;
	}

?>