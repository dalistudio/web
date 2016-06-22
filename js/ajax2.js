/**
 * 得到ajax对象
 */
function getajaxHttp() {
    var xmlHttp;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer
            try {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("您的浏览器不支持AJAX！");
                return false;
            }
        }
    }
    return xmlHttp;
}
/**
 * 发送ajax请求
 * url--url
 * methodtype(post/get)
 * con (true(异步)|false(同步))
 * parameter(参数)
 * functionName(回调方法名，不需要引号,这里只有成功的时候才调用)
 * (注意：这方法有二个参数，一个就是xmlhttp,一个就是要处理的对象)
 * obj需要到回调方法中处理的对象
 */
function ajaxrequest(url,methodtype,con,parameter,functionName,obj){
    var xmlhttp=getajaxHttp();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4){
            //HTTP响应已经完全接收才调用
            functionName(xmlhttp,obj);
        }
    };
    xmlhttp.open(methodtype,url,con);
    xmlhttp.send(parameter);
}
/*
//这就是参数
function createxml(){
    var xml="<user><userid>asdfasdfasdf<\/userid><\/user>";//"\/"这不是大写V而是转义是左斜杠和右斜杠
    return xml;
}
//这就是参数
function createjson(){
    var json={id:0,username:"好人"};
    return json;
}
function c(){
    alert("");
}
//测试
ajaxrequest("http://www.baidu.com","post",true,createxml(),c,document);
*/