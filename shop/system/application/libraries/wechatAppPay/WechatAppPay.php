<?php
require_once('WechatPayBase.php');
class WechatAppPay extends WechatPayBase
{
    //package参数
    public $package = [];

    //异步通知参数
    public $notify = [];

    //推送预支付订单参数
    protected $config = [];

    //存储access token和获取时间的文件
    protected $file;

    //access token
    protected $accessToken;

    //取access token的url
    const ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';

    //生成预支付订单提交地址
    const POST_ORDER_URL = 'https://api.weixin.qq.com/pay/genprepay?access_token=%s';

    public function __construct()
    {
        $this->file = __DIR__ . '/payAccessToken.txt';
    }

    /**
     * 创建APP支付最终返回参数
     * @throws \Exception
     * @return multitype:string NULL
     */
    public function createAppPayData()
    {
        $this->generateConfig();

        try{
            $prepayid = $this->getPrepayid();
        } catch(\Exception $e) {
            header("Content-type: text/html; charset=utf-8");
            //throw new \Exception($e->getMessage());
            return ['status' => 502,'data' => $e->getMessage()];
        }

        $array = [
                'appid' => $this->appid,
                'appkey' => $this->paySignkey,
                'noncestr' => $this->getRandomStr(),
                'package' => 'Sign=WXPay',
                'partnerid' => $this->partnerId,
                'prepayid' => $prepayid,
                'timestamp' => (string)time(),
            ];

            $array['sign'] = $this->sha1Sign($array);
            unset($array['appkey']);

        return $array;
    }

    /**
     * 验证支付成功后的通知参数
     *
     * @throws \Exception
     * @return boolean
     */
    public function verifyNotify()
    {
        try{
            $staySignStr = $this->notify;
            unset($staySignStr['sign']);
            $sign = $this->signData($staySignStr);

            return $this->notify['sign'] === $sign;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 魔术方法，给添加支付参数进来
     *
     * @param string $name  参数名
     * @param string $value  参数值
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * 设置access token
     * @param string $token
     * @throws \Exception
     * @return boolean
     */
    public function setAccessToken()
    {
        try{
            if(!file_exists($this->file) || !is_file($this->file)) {
                $f = fopen($this->file, 'a');
                fclose($f);
            }
            $content = file_get_contents($this->file);
            if(!empty($content)) {
                $info = json_decode($content, true);
                if( time() - $info['getTime'] < 7150 ) {
                    $this->accessToken = $info['accessToken'];
                    return true;
                }
            }

            //文件内容为空或access token已失效，重新获取
            $this->outputAccessTokenToFile();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    /**
     * 写入access token 到文件
     * @throws \Exception
     * @return boolean
     */
    protected function outputAccessTokenToFile()
    {
        try{
            $f = fopen($this->file, 'wb');
            $token = [
                'accessToken' => $this->getAccessToken(),
                'getTime' => time(),
            ];
            flock($f, LOCK_EX);
            fwrite($f, json_encode($token));
            flock($f, LOCK_UN);
            fclose($f);

            $this->accessToken = $token['accessToken'];
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    /**
     * 取access token
     *
     * @throws \Exception
     * @return string
     */
    protected function getAccessToken()
    {
        $url = sprintf(self::ACCESS_TOKEN_URL, $this->appid, $this->appSecret);
        $result = json_decode( $this->getUrl($url), true );

        if(isset($result['errcode'])) {
            throw new \Exception("get access token failed:{$result['errmsg']}");
        }

        return $result['access_token'];
    }

    /**
     * 取预支付会话标识
     *
     * @throws \Exception
     * @return string
     */
    protected function getPrepayid()
    {
        $data = json_encode($this->config);
        $url = sprintf(self::POST_ORDER_URL, $this->accessToken);
        $result = json_decode( $this->postUrl($url, $data), true );

        if( isset($result['errcode']) && $result['errcode'] != 0 ) {
            throw new \Exception($result['errmsg']);
        }

        if( !isset($result['prepayid']) ) {
            throw new \Exception('get prepayid failed, url request error.');
        }

        return $result['prepayid'];
    }

    /**
     * 组装预支付参数
     *
     * @throws \Exception
     */
    public function generateConfig()
    {
        try{
            $this->config = [
                    'appid' => $this->appid,
                    'traceid' => $this->traceid,
                    'noncestr' => $this->getRandomStr(),
                    'timestamp' => time(),
                    'package' => $this->generatePackage(),
                    'sign_method' => $this->sign_method,
            ];
            $this->config['app_signature'] = $this->generateSign();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 生成package字段
     *
     * 生成规则:
     * 1、生成sign的值signValue
     * 2、对package参数再次拼接成查询字符串，值需要进行urlencode
     * 3、将sign=signValue拼接到2生成的字符串后面得到最终的package字符串
     *
     * 第2步urlencode空格需要编码成%20而不是+
     *
     * RFC 1738会把 空格编码成+
     * RFC 3986会把空格编码成%20
     *
     * @return string
     */
    protected function generatePackage()
    {
        $this->package['sign'] = $this->signData($this->package);

        return http_build_query($this->package, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * 生成签名
     *
     * @return string
     */
    protected function generateSign()
    {
        $signArray = [
            'appid' => $this->appid,
            'appkey' => $this->paySignkey,
            'noncestr' => $this->config['noncestr'],
            'package' => $this->config['package'],
            'timestamp' => $this->config['timestamp'],
            'traceid' => $this->traceid,
        ];
        return $this->sha1Sign($signArray);
    }

    /**
     * 签名数据
     *
     * 生成规则:
     * 1、字典排序，拼接成查询字符串格式，不需要urlencode
     * 2、上一步得到的字符串最后拼接上key=paternerKey
     * 3、MD5哈希字符串并转换成大写得到sign的值signValue
     *
     * @param array $data 待签名数据
     * @return string 最终签名结果
     */
    protected function signData($data)
    {
        ksort($data);
        $str = $this->arrayToString($data);
        $str .= "&key={$this->partnerKey}";
        return strtoupper( $this->signMd5($str) );
    }

    /**
     * sha1签名
     * 签名规则
     * 1、字典排序
     * 2、拼接查询字符串
     * 3、sha1运算
     *
     * @param array $arr
     * @return string
     */
    protected function sha1Sign($arr)
    {
        ksort($arr);

        return sha1( $this->arrayToString($arr) );
    }

}
