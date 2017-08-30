<?php

namespace pay\wxpay;

/**
 * 微信支付
 * 
 */
class Wxpay {

    //扫描支付
    public function do_nativepay($order_info) {
        
        include_once 'lib/WxPay.NativePay.php';
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order_info['goods_name']);
        $input->SetAttach("");
        $input->SetOut_trade_no($order_info['order_sn']);
		//echo $order_info['order_sn'];die;
        $input->SetTotal_fee($order_info['order_amount']);
        $input->SetTime_start(date("YmdHis") + 60000);
        $input->SetTime_expire(date("YmdHis", time() + 60000));
        $input->SetGoods_tag("");
        $input->SetNotify_url(WxPayConfig::NOTIFY_URL);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order_info['id']);
        $result = $notify->GetPayUrl($input);
		//print_r($result);die;
        $url2 = $result["code_url"];
        include_once 'nativepay.html';
    }

    // 支付付款
    public function do_wxpay($order_info,$id) {
        ini_set('date.timezone', 'Asia/Shanghai');
        include_once 'lib/WxPay.JsApiPay.php';
        //①、获取用户openid
        $tools = new JsApiPay();
       // $openId = $tools->GetOpenid();
		$openId = $id;
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order_info['goods_name']);
        $input->SetAttach('');
        $input->SetOut_trade_no($order_info['order_sn']);
        $input->SetTotal_fee($order_info['order_amount']);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag('');
        $input->SetNotify_url(WxPayConfig::NOTIFY_URL);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        //生成带参数的同步放回地址
        include_once('lib/WxPay.Api.php');
        $url_arr = json_decode($jsApiParameters, TRUE);
        unset($url_arr['signType']);
        unset($url_arr['paySign']);
        $url_arr['order_sn'] = $order_info['order_sn'];
        $notify = new WxPayResults();
        $notify->FromArray($url_arr);
        $sign = $notify->SetSign();
        $url_arr['sign'] = $sign;
		 
        $return_url = WxPayConfig::RETURN_URL . '?' . http_build_query($url_arr);
        //支付页面
        $pay_url = WxPayConfig::PAY_URL . '?order_sn=' . $order_info['order_sn'];
        include_once 'weixin.html';
    }

    // 同步回调验证
    public function do_return($arr = array()) {
        include_once('lib/WxPay.Api.php');
        $notify = new WxPayResults();
        if (empty($arr)) {
            $arr = $_GET;
        }
        $notify->FromArray($arr);
        if ($notify->CheckSign() == true) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // 异步回调验证
    public function do_notify($xml) {
        include_once('lib/WxPay.Api.php');
        $notify = new WxPayResults();
        $notify->FromXml($xml);
        if ($notify->CheckSign() == true) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //xml转化成数组
    public function FromXml($xml) {
        include_once('lib/notify.php');
        $notify = new PayNotifyCallBack();
        return $notify->FromXml($xml);
    }

    /**
     * 交易查询 查询订单交易状态
     * 
     * @param  string 	$order_sn 07073订单号
     * @return [type]           [array]
     */
    public function query_order($order_sn) {
        include_once 'lib/WxPay.Api.php';

        if (isset($order_sn) && $order_sn != "") {
            $input = new WxPayOrderQuery();
            $input->SetOut_trade_no($order_sn);
            $result_arr = WxPayApi::orderQuery($input);
        }
        return $result_arr;
    }

    // 退款
    public function wx_refund($order_info) {
        require_once "lib/WxPay.Api.php";

        $input = new WxPayRefund();
        $input->SetTransaction_id($order_info['transaction_id']);
        $input->SetTotal_fee($order_info['total_fee']);
        $input->SetRefund_fee($order_info['refund_fee']);
        $input->SetOut_refund_no($order_info['batch_no']);
        $input->SetOp_user_id(WxPayConfig::MCHID);
        $res = WxPayApi::refund($input);
        return $res;
    }

    // 退款状态查询
    public function wx_refund_query($order_info) {
        require_once 'lib/WxPay.Api.php';

        $input = new WxPayRefundQuery();
        $input->SetTransaction_id($order_info['transaction_id']);
        $res = WxPayApi::refundQuery($input);

        return $res;
    }

    // 支付付款
    public function do_wappay($order_info) {
        include_once 'lib/WxPay.WapPay.php';
        // 统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order_info['goods_name']);
        $input->SetAttach("");
        $input->SetOut_trade_no($order_info['order_sn']);
        $input->SetTotal_fee($order_info['order_amount']);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("");
        $input->SetNotify_url(WxPayConfig::NOTIFY_URL);
        $input->SetTrade_type("WAP");
        $input->SetProduct_id($order_info['id']);

        $wxpay = new WapPay();
        // 预支付订单信息
        $prepay_res = $wxpay->GetPrepayInfo($input);
        var_dump($prepay_res);
        $wxpay->GetWapPayUrl($prepay_res['prepayid']);
    }

    // 微信登录
    public function wxlogin() {
        include_once 'lib/WxPay.JsApiPay.php';

        // 获取用户openid
        $tools = new JsApiPay();
        $data = $tools->GetOpenData();
        return $data;
    }

    // 获得微信用户信息
    public function wxuser($access_token, $openid) {
        include_once 'lib/WxPay.JsApiPay.php';

        // 获取用户openid
        $tools = new JsApiPay();
        $data = $tools->getUserInfo($access_token, $openid);
        return $data;
    }

}
