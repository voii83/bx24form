<?php

class Curl
{
    public $body = "";
    public $code = 0;
    public $auto_redirect = false;
    public $method = "GET";
    public $multi_part = false;
    public $headers = array();
    public $returnHeader = false;
    public $noBody = false;

    function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($this->curl, CURLOPT_NOBODY, false);
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, ROOT . '/log/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, ROOT . '/log/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($this->curl, CURLOPT_VERBOSE, true);
    }
    public function GetCookiesFromHeader($header)
    {
        $header_params = explode("\r\n", $header);
        $cookies = array();
        foreach ($header_params as $header_param) {
            $header_param = strtolower($header_param);
            if (strpos($header_param, 'set-cookie') !== false) {
                $cookies_string = trim(str_replace("set-cookie:", "", $header_param));
                $cookies_tmp = explode(";", $cookies_string);
                foreach ($cookies_tmp as $cookie_string) {
                    $cookie_array = explode("=", $cookie_string);
                    if (!isset($cookie_array[1])) {
                        $cookies[$cookie_array[0]] = "";
                    }
                    else{
                        $cookies[$cookie_array[0]] = $cookie_array[1];
                    }
                }
            }
        }
        return $cookies;
    }
    public function GetCookiesFromString($string)
    {
        return explode(";", $string);
    }
    public function SetHeaders($headers_multi = array())
    {
        $headers = array();
        foreach ($headers_multi as $key=>$value) {
            $headers[] = $key.":".$value;
        }
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }
    public function SetCookies($cookies = array())
    {
        $cookie_string = "";
        foreach ($cookies as $key=>$value)
        {
            $cookie_string .= $key."=".$value.";";
        }
        curl_setopt($this->curl, CURLOPT_COOKIE, $cookie_string);
    }

    public function IsAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function SetUserAgent($value = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36')
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, $value);
    }

    public function ReturnTransfer($value = true)
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $value);
    }

    public function SSLVerifypeer($value = true)
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $value);
    }

    public function ReturnHeader($value = false)
    {
        curl_setopt($this->curl, CURLOPT_HEADER, $value);
    }
    public function CookieSession($value = true)
    {
        curl_setopt($this->curl, CURLOPT_COOKIESESSION, $value);
    }
    public function SetEncoding($value = "UTF8")
    {
        curl_setopt($this->curl, CURLOPT_ENCODING, $value);
    }

    public function AutoReferer($value = true)
    {
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, $value);
    }

    public function SSL_Verifypeer($value = false)
    {
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $value);
    }

    public function SetMaxRedirs($value = 15)
    {
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, $value);
    }

    public function FollowLocation($value = true)
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $value);
    }

    public function NoBody($value = false)
    {
        curl_setopt($this->curl, CURLOPT_NOBODY, $value);
    }

    public function HeaderOut($value = false)
    {
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, $value);
    }

    public function AutoRedirect($value = false)
    {
        $this->auto_redirect = $value;
    }

    public function GetHeaderOut()
    {
        return curl_getinfo($this->curl, CURLINFO_HEADER_OUT);
    }

    public function SetPost($value = false)
    {
        curl_setopt($this->curl, CURLOPT_POST, $value);
    }

    public function SetPostFields($fields = array())
    {
        if ($this->multi_part) {
            $fields = $this->GetPostFields($fields);
        } else $fields = http_build_query($fields);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields);
    }

    public function GetPostFields($multi_array)
    {
        $this->post_fileds_array = array();
        $this->post_fields_layer = 0;
        $this->GetPostFieldsProccess($multi_array);
        return $this->post_fileds_array;
    }

    public function GetPostFieldsProccess($multi_array, $path = "")
    {

        if (count($multi_array) > 0) {
            foreach ($multi_array as $key => $value) {
                $this_path = $path;
                if ($this->post_fields_layer == 0) {
                    $this_path .= $key;
                } else {
                    $type = gettype($key);
                    if (gettype($key) == "integer") $this_path .= "[" . $key . "]";
                    else $this_path .= "[" . $key . "]";

                }
                if (gettype($value) == "array") {
                    $this->post_fields_layer++;
                    $this->GetPostFieldsProccess($value, $this_path);
                } else {
                    $this->post_fileds_array[$this_path] = $value;
                }
            }
        }
    }

    public function SetCustomRequest($value = "GET")
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $value);
    }

    public function SetURL($value = '')
    {
        curl_setopt($this->curl, CURLOPT_URL, $value);
    }

    public function Redirect($body)
    {
        if ($this->auto_redirect) {
            $code = $this->GetCode();
            if ($code == 301 || $code == 302) {
                $headers = $this->ParseHeader($body);
                if (isset($headers["location"])) $this->Get($headers["location"]);
            }
            return false;
        }
    }

    public function GetCode()
    {
        $this->code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        return $this->code;
    }

    public function ParseHeader($header)
    {
        $headers = array();

        //$header_text = substr($header, 0, strpos($header, "\r\n"));
        $header_array = explode("\r\n", $header);
        foreach ($header_array as $i => $line) {
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);

                $headers[strtolower($key)] = $value;
            }
        }
        return $headers;
    }
    public function ParseUrl($url)
    {
        $url_array = array();
        $url_params = explode("?", $url);
        $url_params = $url_params[1];
        $url_array_temp = explode("&", $url_params);
        foreach ($url_array_temp as $param)
        {
            $param_array = explode("=", $param);
            $url_array[$param_array[0]] = urldecode(urldecode($param_array[1]));
        }
        return $url_array;
    }

    public function Get($url, $fields = array())
    {
        $this->method = "GET";
        $this->SetPost(false);
        $this->SetPostFields(array());
        $this->SetCustomRequest("GET");
        if (!empty($fields)) $url .= "?" . http_build_query($fields);
        $this->SetURL($url);
        $this->SetHeaders($this->headers);
        $this->ReturnHeader($this->returnHeader);
        $this->NoBody($this->noBody);
        $this->body = curl_exec($this->curl);
        $this->Redirect($this->body);
        return $this->body;
    }
    public function Post($url, $fields=array(), $multi_part = false)
    {
        $this->multi_part = $multi_part;
        $this->method = "POST";
        $this->SetPost(true);
        $this->SetPostFields($fields);
        $this->SetCustomRequest("POST");
        $this->SetURL($url);
        $this->SetHeaders($this->headers);
        $this->ReturnHeader($this->returnHeader);
        $this->NoBody($this->noBody);
        $this->body = curl_exec($this->curl);

        $this->Redirect($this->body);
        return $this->body;
    }
}

?>