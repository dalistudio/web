// 创建 XML HTTP 请求
function createXMLHttpRequest() 
{
    var request = false;
    if(window.XMLHttpRequest) // IE7+、Firefox、Chrome、Safari 以及 Opera
	{
        request = new XMLHttpRequest();
        if(request.overrideMimeType) 
		{
            request.overrideMimeType('text/xml');
        }
    } 
	else if(window.ActiveXObject) // IE6 及以前版本
	{
        var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP',
                        'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0',
                        'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
        for(var i=0; i<versions.length; i++) 
		{
            try 
			{
                request = new ActiveXObject(versions[i]);
                if(request) 
				{
                    return request;
                }
            } catch(e) {}
        }
    }
    return request;
}

/*
onreadystatechange 存储函数（或函数名），每当 readyState 属性改变时，就会调用该函数。
 
readyState 
存有 XMLHttpRequest 的状态。从 0 到 4 发生变化。
0: 请求未初始化
1: 服务器连接已建立
2: 请求已接收
3: 请求处理中
4: 请求已完成，且响应已就绪
 
status 
200: "OK"
404: 未找到页面

XMLHttpRequest 对象的 responseText 或 responseXML 属性
responseText 获得字符串形式的响应数据。 
responseXML 获得 XML 形式的响应数据。 

*/
// 通过 ajax 获得数据
function ajax(xmlhttp,_method, _url, _param, _callback) 
{
    if (typeof xmlhttp == 'undefined') return;
    xmlhttp.onreadystatechange = function() 
	{
        if (xmlhttp.readyState==4 && xmlhttp.status==200) // 返回正常及收到完整响应
		{
            _callback(xmlhttp); // 呼叫返回函数
        }
    }
    xmlhttp.open(_method, _url, true); // 异步方式请求
    if (_method == "POST") // 如果是POST方法
	{
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 添加请求头，POST的类型
        xmlhttp.setRequestHeader("Content-Length", _param.length); // 添加请求头，内容的长度
        xmlhttp.send(_param); // 发送带有参数
    }
    else {
        xmlhttp.send(null); // GET 方式发送不带任何参数
    }
}

/*
//使用举例

var xmlhttp = createXMLHttpRequest();
var t1; //用来作超时处理

// 返回执行函数
function adduserok(request) {
    alert(request.responseText);
    if (t1) clearTimeout(t1);
}

// 连接错误
function connecttoFail() {
    if (xmlhttp) xmlhttp.abort();
    alert ('Time out');
}

if (xmlhttp) {
    ajax(xmlhttp,"POST", "http://10.1.2.187/adduser.cgi","act=do&user=abc",adduserok);
    t1 = setTimeout(connecttoFail,30000); // 延时30秒
}
else {
    alert ("Init xmlhttprequest fail"); // 初始化 XML HTTP 失败
}
*/