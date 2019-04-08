<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
//

// 获得限重的信息

include 'session.inc';
include 'conn.php';

$sql  = "Select * FROM sys;";
$result=mysql_query($sql); // 执行SQL语句
while($row = mysql_fetch_array($result)) // 循环每条记录
{
    switch($row['sys_limit_flag'])
    {
        case "0":
        {
            // 禁用限重功能,无需返回限重车型列表
            print("{\"limit_flag\":0}");
            break;
        }
        case "1":
        {
            print("{\"limit_flag\": 1,\"limit_list\": [");
                // 这里循环获取限重列表数据
                $sql2 = "Select * FROM limits;";
                $result2=mysql_query($sql2); // 执行SQL语句
                while($row2 = mysql_fetch_array($result2)) // 循环每条记录
                {
                    printf("{\"axle\":\"%s\",\"type\":\"%s\",\"weight\":\"%s\"},",$row2['limit_axle'],$row2['limit_type'],$row2['limit_weight']);
                }
            print("{\"axle\":\"0\",\"type\":\"0\",\"Weight\":0}]}");
            break;
        }
    }
}

/*

禁用例子:
{"limit_flag":0}

启用例子:
{
	"limit_flag": 1,
	  "limit_list": [
		{"axle":"2轴","type":"载货汽车","Weight":"18"},
		{"axle":"3轴","type":"载货汽车","Weight":"25"},
		{"axle":"3轴","type":"载货汽车","Weight":"27"},
		{"axle":"4轴","type":"载货汽车","Weight":"31"},
		{"axle":"4轴","type":"挂车列车","Weight":"35"},
		{"axle":"4轴","type":"铰接列车","Weight":"36"},
		{"axle":"5轴","type":"挂车列车","Weight":"43"}
	  ]
}
 */
?>