<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	require 'api/db_back.php';
	include '../conn.php';
//	fopen("a.sql","w");
	$table = "pay";
	echo get_table_data($table,$conn);
//	echo $db->get_table_data("pay");
?>