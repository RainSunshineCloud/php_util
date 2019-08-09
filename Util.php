<?php

class Util 
{
	/**
	 * 获取服务器ip
	 * @return string
	 */
	public static function getServerIp() {
		return trim(shell_exec ("/sbin/ifconfig -a|grep inet|grep -v 127.0.0.1|grep -v inet6|awk '{print $2}'|tr -d 'addr:'"),"\r\n");
	}

	/**
	 * 获取客户端ip
	 * @return string
	 */
	public static function getClientIp() {
		if （$ips = getenv('HTTP_X_FORWARDED_FOR')） {
			$arr = explode(',', $ips);
			$ip = trim(array_pop($arr));
	        if ($ip && $ip != 'unknown') {
	            return $ip;
	        }
		}

		if ($ip =  trim(getenv('HTTP_CLIENT_IP'))) {
			return $ip;
		}

		if ($ip = trim(getenv('REMOTE_ADDR'))) {
			return $ip;
		}

		return '0.0.0.0';
	}

	/**
	 * 随机字符串
	 * @param  string 要随机的字符串
	 * @param  int|integer 随机次数
	 * @param  boolean     是否删除已随机的数值
	 * @return array|string 随机次数为1时为字符串，否则为数组
	 */
	function static randStr (string $str,int $num = 1,bool $unset = true) {
		if ($num == 1) {
			$len = strlen($str);
			return substr($str,mt_rand(0,$len - 1),1);
		}

		$arr = str_split($str);
		return self::randArr($arr,$num,$unset);
	}

	/**
	 * 随机数组
	 * @param  array 要随机的数组
	 * @param  int|integer 随机次数
	 * @param  boolean     是否删除已随机的数值
	 * @return array|string 随机次数为1时为字符串，否则为数组
	 */
	public static function randArr (array $arr, int $num = 1, bool $unset = true) {
		if ($num < 1 ) {
			return [];
		}

		if ($num == 1) {
			return $arr[array_rand($arr)];
		}

		$res = [];
		$array_num = count($arr);
		if ($unset && $array_num < $num) {
			$num = $array_num;
		}

		while ($num > 0) {
			$rand_key = array_rand($arr);
			array_push($res,$arr[$rand_key]);
			if ($unset) {
				unset($arr[$rand_key]);
			}
			$num--;
		}

		return $res;
	}

}
