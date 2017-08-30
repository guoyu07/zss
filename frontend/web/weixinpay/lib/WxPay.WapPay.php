<?php

namespace pay\wxpay;

require_once "WxPay.Api.php";

/**
 * 
 * wap支付实现类
 * @author shaozhigang
 *
 * @date  2015/12/07
 */
class WapPay {

    /**
     * 
     * 生成扫描支付URL,模式一
     * @param BizPayUrlInput $bizUrlInfo
     */
    public function GetWapPayUrl($prepayid) {
        $wap = new WxPayWap();
        $wap->SetPackage('WAP');
        $wap->SetPrepay_id($prepayid);

        $values = WxpayApi::wappayurl($wap);
        var_dump($values);
        //$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
        //return $url;
    }

    /**
     * 
     * 参数数组转换为url参数
     * @param array $urlObj
     */
    private function ToUrlParams($urlObj) {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 
     * 预支付订单信息
     * @param UnifiedOrderInput $input
     */
    public function GetPrepayInfo($input) {

        if ($input->GetTrade_type() == "WAP") {

            $result = WxPayApi::unifiedOrder($input);
            return $result;
        }
    }

}
