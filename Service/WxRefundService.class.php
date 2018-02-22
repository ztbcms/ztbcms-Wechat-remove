<?php
// +----------------------------------------------------------------------
// | Copyright (c) Zhutibang.Inc 2017 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhlhuang <zhlhuang888@foxmail.com>
// | 微信支付相关操作
// +----------------------------------------------------------------------

namespace Wechat\Service;

use System\Service\BaseService;

/**
 * 微信退款
 */
class WxRefundService extends BaseService {

    //TODO
    //1.商户key 可在open平台拿到
    const MCH_KEY = '';
    //2.证书路径 可在商户平台下载
    //证书路径
    static function getSslCertPah(){
        return 'apiclient_cert.pem';
    }
    //签名key文件路径
    static function getSslKeyPath(){
        return 'apiclient_key.pem';
    }

    /**
     * 退款 依赖wechat_pay_order表
     * @param $order_sn
     * @param $return_money
     */
    static function refund($order_sn, $return_money){
        $wechatOrder = M('WechatPayOrder')->where(['out_trade_no' => $order_sn])->find();

        $appid = $wechatOrder['appid'];
        $mch_id = $wechatOrder['mch_id'];
        $op_user_id = $mch_id;
        $nonce_str = rand(100000,999999);
        $out_refund_no = $order_sn.rand(1000,9999);
        $out_trade_no = $order_sn;
        $total_fee = $wechatOrder['total_fee'];

        //商户key
        $key = self::MCH_KEY;

        $str = "appid={$appid}&mch_id={$mch_id}&nonce_str={$nonce_str}&op_user_id={$op_user_id}";
        $str .= "&out_refund_no={$out_refund_no}&out_trade_no={$out_trade_no}&refund_fee={$return_money}&total_fee={$total_fee}";
        $str .= "&key={$key}";

        $data = [
            'appid'=>$appid,//应用ID，固定
            'mch_id'=>$mch_id,//商户号，固定
            'nonce_str'=>$nonce_str,//随机字符串
            'op_user_id'=>$op_user_id,//操作员
            'out_refund_no'=>$out_refund_no,//商户内部唯一退款单号
            'out_trade_no'=>$out_trade_no,//商户订单号,pay_sn码 1.1二选一,微信生成的订单号，在支付通知中有返回
            // 'transaction_id'=>'1',//微信订单号 1.2二选一,商户侧传给微信的订单号
            'refund_fee'=>$return_money,//退款金额
            'total_fee'=>$total_fee,//总金额
            'sign'=>md5($str)//签名
        ];
        $xml = self::arrayToXml($data);

        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $res = self::httpPost($url, $xml, true);

        if($res['status']){
            $xml = $res['data'];
            $arr = self::xmlToArray($xml);
            if($arr['result_code'] == 'SUCCESS'){
                //退款成功

            }else{
                //退款失败

            }
            M('WechatRefundOrder')->add($arr);
        }
        //curl出错 错误码$res['msg'];
    }

    /**
     * post method
     *
     * @param       $url
     * @param array $param
     * @param bool $useCert
     * @param int $second
     * @return bool|mixed
     */
    static function httpPost($url, $param = array(), $useCert = false, $second = 30) {

        if (empty($param)) {
            return self::createReturn(false, null, '缺少参数');
        }
        //证书
        $sslcert_path = self::getSslCertPah();
        $sslkey_path = self::getSslKeyPath();

        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, false);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $sslcert_path);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $sslkey_path);
        }

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //运行curl
        $data = curl_exec($ch);

        if($data){
            curl_close($ch);
            return self::createReturn(true, $data);
        }else{
            $error = curl_errno($ch);
            curl_close($ch);
            return self::createReturn(false, null, "curl出错，错误码:$error");
        }
    }

    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id 数字索引key转换为的属性名
     * @return string
     */
    protected static function arrayToXml($data, $item = 'item', $id = 'id') {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $id && $attr = " {$id}=\"{$key}\"";
                $key = $item;
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= (is_array($val) || is_object($val)) ? data_to_xml($val, $item, $id) : $val;
            $xml .= "</{$key}>";
        }
        return '<xml>'.$xml.'</xml>';
    }

    protected static function xmlToArray($xml){
        //考虑到xml文档中可能会包含<![CDATA[]]>标签，第三个参数设置为LIBXML_NOCDATA
        if (file_exists($xml)) {
            libxml_disable_entity_loader(false);
            $xml_string = simplexml_load_file($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        }else{
            libxml_disable_entity_loader(true);
            $xml_string = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        }
        $result = json_decode(json_encode($xml_string),true);
        return $result;
    }
}