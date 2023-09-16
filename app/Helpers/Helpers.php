<?php

use App\Lib\ClientInfo;
use Illuminate\Support\Facades\DB;

function format_amount($amount) {
	$arr = array();
	$cr = DB::table('currency_rates')->where('id', 1)->first();
    $info = json_decode(json_encode(getIpInfo()), true);
    $mobileCode = @implode(',', $info['code']);
    if($mobileCode == 'GB') {
        $arr['icon'] = 'fa-gbp';
		$arr['amount'] = number_format($amount, 2);
        return $arr;
    } else {
		
		$arr['icon'] = 'fa-dollar-sign';
		$arr['amount'] = number_format($amount * $cr->usd, 2);
        return $arr;
    }
}
function currency() {
    $info = json_decode(json_encode(getIpInfo()), true);
    $mobileCode = @implode(',', $info['code']);
    if($mobileCode == 'GB') {
        return 'GBP';
    } else {

        return 'USD';
    }
}

function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}

function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }

    return $ip;
}