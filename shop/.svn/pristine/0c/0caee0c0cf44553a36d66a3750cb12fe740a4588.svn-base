<HTML>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>微信支付功能</title>
    <script type="text/javascript">
var cText = 0;
var cJson = 1;
var cInt = 2;
var appId = "wxd930ea5d5a258f4f";
var app_serect = "db426a9829e4b49a0dcac7b4162da6b6";
var app_key = "L8LrMqqeGRxST5reouB0K66CaYAWpqhAVsq7ggKkxHCOastWksvuX1uvmvQclxaHoYd3ElNBrNO2DHnnzgfVG9Qs473M3DTOZug5er46FhuGofumV8H2FVR9qkjSlC5K";
var partnerId = "1900000109";
var traceId = "crestxu_test";
var packageValue = "bank_type=WX&body=%E5%8D%83%E8%B6%B3%E9%87%91%E7%AE%8D%E6%A3%92&fee_type=1&input_charset=UTF-8?ify_url=http%3A%2F%2Fweixin.qq.com&out_trade_no=9d86d83f925f2149e9edb0ac3b492299c&partner=1900000109&spbill_create_ip=196.168.1.1&total_fee=1&sign=899815E4F3106CC5DCFAF76A4D16069B";
 
    window.uexOnload = function(){
        uexWeiXin.cbRegisterApp =function(opCode,dataType,data)
        {
            //0支持，1 不支持
            alert("cbRegisterApp："+data);
            document.getElementById("selectItem").innerHTML = data;
        }
        
        uexWeiXin.cbGotoPay = function(opCode,dataType,data)
        {
            //如果datatype是0说明返回的data是整数0，意味着支付成功了。
            //如果datatype是2说明返回的data是字符串，意味着支付失败了。data就是失败信息
            console.log("cbGotoPay");
            alert("cbGotoPay："+data);
            document.getElementById("showPayInfo").innerHTML = data;
        }
        
        uexWeiXin.cbGenerateAdvanceOrder = function(opCode,dataType,data)
        {
            alert("cbGenerateAdvanceOrder："+data);
            document.getElementById("showOrderInfo").innerHTML = data;
        }
        
        uexWeiXin.cbGetAccessToken = function(opCode,dataType,data)
        {
           alert("cbGetAccessToken："+data);
           document.getElementById("showAccess_token").innerHTML = data;
        }
        
        
        uexWeiXin.cbGetAccessTokenLocal = function(opCode,dataType,data)
        {
           alert("cbGetAccessTokenLocal:"+data);
           document.getElementById("showAccess_token").innerHTML = data;
        }
     }
 
   
   
    function getAccessToken(){
        uexWeiXin.getAccessToken(appId,app_serect); 
    }        
    function generateAdvanceOrder(){
        var JsonStr = document.getElementById("showAccess_token").innerHTML;
        var token = JSON.parse(JsonStr).access_token;
        uexWeiXin.generatePrepayID(token,app_key,packageValue);
    }
    function gotoPay(){
        var JsonStr = document.getElementById("showOrderInfo").innerHTML;
        var prepayid = JSON.parse(JsonStr).prepayid;
        uexWeiXin.sendPay(partnerId,prepayid,app_key,packageValue);
    }
       
       
       
       </script>
       </head>
       <body>
       <div class="tit">微信功能</div>
       <div class="conbor">
       <div class="consj">
       <span>1.注册app id </span>
       <input class="btn" type="button" value="注册App" onclick="uexWeiXin.registerApp('wxd930ea5d5a258f4f');">
       <div class="tcxx" id="selectItem"></div><br>
       <span>零.当前手机安装的微信版本是否支持微信支付</span>
       <span>返回0支持，1版本太低不支持</span>
       <input class="btn" type="button" value="判断是否支持微信支付" onclick="uexWeiXin.isSupportPay()">
       <div class="tcxx" id="showSupportInfo"></div><br>
       <span>一.获取微信支付access_token</span>
       <span>准备工作:在使用接口之前请先保证持有向微信开放平台申请得到的 appid、appsecret(长度为
       32 的字符串,用于获取 access_token)、appkey(长度为 128 的字符串,用于支付过程中生 成 app_signature)及 partnerkey(微信公众平台商户模块生成的商户密钥)。网页会在cbGetAccessTocken（）中获得。</span>
       <input class="btn" type="button" value="获取access_token" onclick="uexWeiXin.getAccessToken('wx652070b3a10fcd45','00f373c57777e46ba86d461cbcc2fbe8');">
       <div class="tcxx" id="showAccess_tokenold"></div><br>
       <span>一.获取本地微信支付access_token</span>
       <span>第一次调用getAccessTokenLocal，是没有办法获取access_token，必须通过getAccessToken获取access_token之后会把access_token存在本地，下次再使用access_token的时候就可以通过getAccessTokenLocal来获得，这么做的目的是因为微信对每天获得token的次数有限制</span>
       <input class="btn" type="button" value="获取本地access_token" onclick="uexWeiXin.getAccessTokenLocal();">
       <div class="tcxx" id="showAccess_token"></div><br>
       <span>二.生成预支付订单</span>
       <span>用第一步请求的 access_token 作为参数,然后往微信开放平台接口post订单详情(需要在服务器端生成)生成预支付订单。网页会在cbGetAccessTocken（）中获得生成订单情况</span>
       <input class="btn" type="button" value="生成预支付订单" onclick="generateAdvanceOrder()">
       <div class="tcxx" id="showOrderInfo"></div><br>
       <span>三.调起微信支付</span>
       <span>将第二步生成的 prepayId 作为参数,调用微信 sdk 发送支付请求到微信。</span>
       <input class="btn" type="button" value="调微信支付" onclick="gotoPay()">
       <div class="tcxx" id="showPayInfo"></div><br>
       </div>
       </div>
       </body>
       </html>