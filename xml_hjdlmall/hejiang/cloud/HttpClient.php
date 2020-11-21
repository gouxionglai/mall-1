<?php
/**
 * @copyright ©2018 浙江禾匠信息科技
 * @author Lu Wei
 * @link http://www.zjhejiang.com/
 * Created by IntelliJ IDEA
 * Date Time: 2018/10/15 19:27
 */


namespace app\hejiang\cloud;


use Curl\Curl;

class HttpClient
{
    public static $urlEncodeQueryString = true;
    public static $curlTimeout = 30;

    public static function get($url, $params = [])
    {
        $url = self::getUrl($url);
        $curl = self::getCulr();
        $curl->get($url, $params);
        if ($curl->error) {
            if ($curl->response) {
                return $curl->response;
            } else {
                throw new CloudException($curl->http_error_message, $curl->http_status_code);
            }
        }
        return $curl->response;
    }

    public static function post($url, $data = [], $params = [])
    {
        $url = self::getUrl($url);
        $url = self::appendParams($url, $params);
        $curl = self::getCulr();
        $curl->post($url, $data);
        if ($curl->error) {
            if ($curl->response) {
                return $curl->response;
            } else {
                throw new CloudException($curl->error_message, $curl->error_code);
            }
        }
        return $curl->response;
    }

    private static function getUrl($url)
    {
        if (mb_stripos($url, 'http') === 0) {
            return $url;
        }
        $url = mb_stripos($url, '/') === 0 ? mb_substr($url, 1) : $url;
        $baseUrl = Config::BASE_URL;
        $baseUrl = mb_stripos($baseUrl, '/') === (mb_strlen($baseUrl) - 1) ? $baseUrl : $baseUrl . '/';
        return $baseUrl . $url;
    }

    private static function appendParams($url, $params = [])
    {
        if (!is_array($params)) {
            return $url;
        }
        if (!count($params)) {
            return $url;
        }
        $url = trim($url, '?');
        $url = trim($url, '&');
        $queryString = static::paramsToQueryString($params);
        if (mb_stripos($url, '?')) {
            return $url . '&' . $queryString;
        } else {
            return $url . '?' . $queryString;
        }
    }

    private static function paramsToQueryString($params = [])
    {
        if (!is_array($params)) {
            return '';
        }
        if (!count($params)) {
            return '';
        }
        $str = '';
        foreach ($params as $k => $v) {
            if (static::$urlEncodeQueryString) {
                $v = urlencode($v);
            }
            $str .= "{$k}={$v}&";
        }
        return trim($str, '&');
    }

    private static function getCulr()
    {
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setOpt(CURLOPT_TIMEOUT, static::$curlTimeout);
        $curl->setHeader('DOMAIN', static::getDomain());
        $curl->setHeader('REQUEST-INFO', Cloud::getRequestInfo());
        return $curl;
    }

    private static function getDomain()
    {
        $localAuthInfo = Cloud::getLocalAuthInfo();
        if ($localAuthInfo && !empty($localAuthInfo['domain'])) {
            return $localAuthInfo['domain'];
        } else {
            return \Yii::$app->request->getHostName();
        }
    }
}
