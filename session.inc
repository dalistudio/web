<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//
    ini_set('session.use_cookies',1); // 以Cookie作为会话ID的存放机制。
    ini_set('session.use_only_cookies',1); // 只使用Cookie作为会话ID传输的机制，不允许使用URL传输。
    session_start();

    function check_login()
    {
		// 如果会话存在且不为空
        if(!isset($_SESSION['User']) || !$_SESSION['User'])
            header('Location: /admin/index.php'); // 跳转登陆主页
    }
?>