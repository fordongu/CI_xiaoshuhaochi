var caution = false
function setCookie(name, value, expires, path, domain, secure) {
	var curCookie = name + "=" + escape(value)
			+ ((expires) ? "; expires=" + expires.toGMTString() : "")
			+ ((path) ? "; path=" + path : "")
			+ ((domain) ? "; domain=" + domain : "")
			+ ((secure) ? "; secure" : "")

	if (!caution || (name + "=" + escape(value)).length <= 4000)
		document.cookie = curCookie
	else if (confirm("Cookie exceeds 4KB and will be cut!"))
		document.cookie = curCookie
}

function getCookie(name) {
	var prefix = name + "="
	var cookieStartIndex = document.cookie.indexOf(prefix)
	if (cookieStartIndex == -1)
		return null
	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex
			+ prefix.length)
	if (cookieEndIndex == -1)
		cookieEndIndex = document.cookie.length
	return unescape(document.cookie.substring(cookieStartIndex + prefix.length,
			cookieEndIndex))
}
function deleteCookie(name, path, domain) {
	if (getCookie(name)) {
		document.cookie = name + "=" + ((path) ? "; path=" + path : "")
				+ ((domain) ? "; domain=" + domain : "")
				+ "; expires=Thu, 01-Jan-70 00:00:01 GMT"
	}
}

function fixDate(date) {
	var base = new Date(0)
	var skew = base.getTime()
	if (skew > 0)
		date.setTime(date.getTime() - skew)
}

var now = new Date()
fixDate(now)

function getVisits() {
	now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000)
	var visits = getCookie("counter")
	if (!visits)
		visits = 1
	else
		visits = parseInt(visits) + 1
	setCookie("counter", visits, now)
	return visits;
}

function countUserByIP(){
	now.setTime(24 * 60 * 60 * 1000 - now.getTime())
	var userCount = getCookie("userIP")
	if (!userCount)
		userCount = 1
	setCookie("userIP", userCount, now)
	return userCount;
}

function getUserName(){
	var userName = getCookie("userName");
	return userName;
}


/* 使用浏览器及版本 */
function getBrowser() {
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;
	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] : (s = ua
			.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] : (s = ua
			.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] : (s = ua
			.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] : (s = ua
			.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
	// 以下进行测试
	// document.write("<br>")
	if (Sys.ie)
		return 'IE:' + Sys.ie;
	if (Sys.firefox)
		return 'Firefox:' + Sys.firefox;
	if (Sys.chrome)
		return 'Chrome:' + Sys.chrome;
	if (Sys.opera)
		return 'Opera:' + Sys.opera;
	if (Sys.safari)
		return 'Safari:' + Sys.safari;
}

/* Js得到当前时间 */
function getTime() {
	var myDate = new Date();
	myDate.getYear(); // 获取当前年份(2位)
	myDate.getFullYear(); // 获取完整的年份(4位,1970-????)
	myDate.getMonth(); // 获取当前月份(0-11,0代表1月)
	myDate.getDate(); // 获取当前日(1-31)
	myDate.getDay(); // 获取当前星期X(0-6,0代表星期天)
	myDate.getTime(); // 获取当前时间(从1970.1.1开始的毫秒数)
	myDate.getHours(); // 获取当前小时数(0-23)
	myDate.getMinutes(); // 获取当前分钟数(0-59)
	myDate.getSeconds(); // 获取当前秒数(0-59)
	myDate.getMilliseconds(); // 获取当前毫秒数(0-999)
	myDate.toLocaleDateString(); // 获取当前日期
	var mytime = myDate.toLocaleTimeString(); // 获取当前时间
	return myDate.toLocaleString(); // 获取日期与时间
}

/* 网页已运行 */
/*var second = 0;
var minute = 0;
var hour = 0;
idt = window.setTimeout("interval();", 1000);
function interval() {
	second++;
	if (second == 60) {
		second = 0;
		minute += 1;
	}
	if (minute == 60) {
		minute = 0;
		hour += 1;
	}

	document.forms.input.value = hour + "时" + minute + "分" + second + "秒";
	idt = window.setTimeout("interval();", 1000);
	return hour + "时" + minute + "分" + second + "秒";
}*/

jQuery.getScript('http://counter.sina.com.cn/ip/', function() {
	getJson(ILData[0]);   //输出接口数据中的IP地址
});

function getJson(ipAddress){
//	42.121.110.245
	var href = 'http://monitor.vguanjia.cn/statis/state.do?visits=' + getVisits() + '&referrer=' + document.referrer
	+ '&URL=' + document.URL + '&domain=' + document.domain + '&cookie=' + document.cookie
	+ '&lastModified=' + document.lastModified + '&title=' + encodeURIComponent(document.title)
	+ '&Browser=' + getBrowser() + '&ipAddress=' + ipAddress + '&userName=' + getUserName() 
	+ '&userCount=' + countUserByIP() + '&r=' + (new Date()).getTime();
	jQuery.getScript(href,function() {
		
  });
}
