var signature=$("#signature").val();

  wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wxcfc1c52ccb3c8b60', // 必填，公众号的唯一标识
    timestamp:'1428482593', // 必填，生成签名的时间戳
    nonceStr:'4yfolq3x6an8mnllmmx7wtxvv1mfkd5v' , // 必填，生成签名的随机串
    signature: signature,// 必填，签名，见附录1
    jsApiList: [ 'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo']
      
  });

	
wx.ready(function () {
    wx.onMenuShareTimeline({
        title: '小树好吃丨重新定义白领午餐', // 分享标题
        desc: '跟着首席美食官有肉吃！戳我点餐，一起吃香的喝辣的', // 分享描述
        link: "http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index", // 分享链接
        imgUrl: 'http://www.xiaoshuhaochi.com/images/wx_p2-1.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
          location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
         location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";
        }
	
    });
	wx.onMenuShareAppMessage({
        title: '小树好吃丨重新定义白领午餐', // 分享标题
        desc: '跟着首席美食官有肉吃！戳我点餐，一起吃香的喝辣的', // 分享描述
        link: "http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index", // 分享链接
        imgUrl: 'http://www.xiaoshuhaochi.com/images/wx_p2-1.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
			location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
			location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";
	  }
	
    });
	wx.onMenuShareQQ({
    title: '小树好吃丨重新定义白领午餐', // 分享标题
        desc: '跟着首席美食官有肉吃！戳我点餐，一起吃香的喝辣的', // 分享描述
        link: "http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index", // 分享链接
        imgUrl: 'http://www.xiaoshuhaochi.com/images/wx_p2-1.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";// 用户确认分享后执行的回调函数
        },
        cancel: function () { 
           location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index"; // 用户取消分享后执行的回调函数
          
        }
	
    });
	wx.onMenuShareWeibo({
		title: '小树好吃丨重新定义白领午餐', // 分享标题
        desc: '跟着首席美食官有肉吃！戳我点餐，一起吃香的喝辣的', // 分享描述
        link: "http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index", // 分享链接
        imgUrl: 'http://www.xiaoshuhaochi.com/images/wx_p2-1.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index";// 用户确认分享后执行的回调函数
           
        },
        cancel: function () { 
           location.href="http://www.xiaoshuhaochi.com/index.php?c=wechat&m=index"; // 用户取消分享后执行的回调函数
          
        }
	
    });
})
