<?php

class RestClient {

    public $username;
    public $password;
    public $apiurl;

    private $authorization;
    private $authorization_expires;
    private $access_token;
    private $access_token_expires;

    private $httpClient;

    const FILEPATH = __DIR__ . "/state.ini";

    public function __construct($url) {
        $this->apiurl = $url;
        $this->httpClient = new HttpClient();
        $this->httpClient->url = $this->apiurl;
    }

    public function authorization() {
        $response = $this->httpClient->call('authorize', 'POST',array('username'=>$this->username,'password'=>$this->password));
        if (isset($response->data)) {
            $this->authorization = $response->data->authorization_code;
            $this->authorization_expires = $response->data->expires_at;
        } else {
			$mess = 'Authorization fail: ';
			if(isset($response->message)){ $mess .= $response->message; }
			throw new \Exception($mess, 404);
            //return false;
        }
        return true;
    }

    public function access_token() {
        $response = $this->httpClient->call('accesstoken','POST', ['authorization_code' => $this->authorization]);
		if (isset($response->data)) {
            $this->access_token = $response->data->access_token;
            $this->access_token_expires = $response->data->expires_at;
        } else {
			$mess = 'Access fail: ';
			if(isset($response->message)){ $mess .= $response->message; }
			throw new \Exception($mess, 404);
            //return false;
        }
        return true;
    }

    public function postData($endPoint, $data=[]) {
        if($this->checkAccess()){
            $response = $this->httpClient->call($endPoint,'POST', $data, ['x-access-token: ' . $this->access_token], 'json', false);
            if (!$response) {
                return false;
            }
            return $response;
        } else {
            return false;
        }
    }

    public function fetchData($endPoint, $params=null, $offset = null) {
        if($this->checkAccess()) {
            if (is_array($params)) {
                $start = true;
                foreach ($params as $key => $param) {
                    if(is_string($param) || is_numeric($param)){
                        if($start == true){
                            $endPoint .= '?'.$key . '=' . $param;
                        } else {
                            $endPoint .= '&'.$key . '=' . $param;
                        }
                    }
                    $start = false;
                }
            }
            $response = $this->httpClient->call($endPoint,'GET', [], ['x-access-token: ' . $this->access_token], 'json', false);
            if (!$response) {
                return false;
            }

            if((!is_null($offset)) and (isset($response->$offset))){
                return $response->$offset;
            } else {
                return $response;
            }
        } else {
            return false;
        }
    }

    public static function clearAccess() {
        $iniFile = self::FILEPATH;
        if (is_file($iniFile)) {
            if(unlink($iniFile)){
                return true;
            }
        }
        return false;
    }

    public function checkAccess() {
        $iniFile = self::FILEPATH;
        if (is_file($iniFile)) {
            $data = parse_ini_file($iniFile, true);
            if(isset($data['authorization_expires'])){
                $data['authorization_expires'] = intval($data['authorization_expires']);
            } else {
                $data['authorization_expires'] = 0;
            }
            if(isset($data['access_token_expires'])){
                $data['access_token_expires'] = intval($data['access_token_expires']);
            } else {
                $data['access_token_expires'] = 0;
            }
            if($data['access_token_expires'] > time()){
                $this->access_token = $data['access_token'];
                $this->access_token_expires = $data['access_token_expires'];
                $this->authorization = $data['authorization'];
                $this->authorization_expires = $data['authorization_expires'];
            } else {
                if($data['authorization_expires'] > time()){
                    $this->authorization = $data['authorization'];
                    $this->authorization_expires = $data['authorization_expires'];
                    $this->access_token();
                } else {
                    if($this->authorization()){
                        if($this->access_token()){
                            $data['authorization'] = $this->authorization;
                            $data['authorization_expires'] = $this->authorization_expires;
                            $data['access_token'] = $this->access_token;
                            $data['access_token_expires'] = $this->access_token_expires;
                            self::write_php_ini($data,$iniFile);
                        }
                    }
                }
            }
        } else {
            $data = array();
            if($this->authorization()){
                if($this->access_token()){
                    $data['authorization'] = $this->authorization;
                    $data['authorization_expires'] = $this->authorization_expires;
                    $data['access_token'] = $this->access_token;
                    $data['access_token_expires'] = $this->access_token_expires;
                    self::write_php_ini($data,$iniFile);
                }
            }
        }
        if((!empty($this->access_token_expires)) and (!empty($this->authorization_expires))){
            if($this->access_token_expires > time()){
                return true;
            }
        }
        throw new \Exception('Rest api login Forbidden', 403);
    }

    private static function write_php_ini($array, $file) {
        $res = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $res[] = "[$key]";
                $br = 0;
                foreach ($val as $skey => $sval)
                    if (is_array($sval)) {
                        foreach ($sval as $subkey => $subvalue) {
                            $res[] = $skey . "[$subkey] = " . (is_numeric($subvalue) ? $subvalue : '"' . $subvalue . '"');
                        }
                    } else
                        $res[] = "$skey = " . (is_numeric($sval) ? $sval : '"' . $sval . '"');
            } else
                $res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
        }
        self::safeFileRewrite(implode("\r\n", $res),$file);
    }

    private static function safeFileRewrite($data, $file) {
        if ($fp = fopen($file, 'w')) {
            $startTime = microtime(TRUE);
            do {
                $canWrite = flock($fp, LOCK_EX);
                if (!$canWrite)
                    usleep(round(rand(0, 100) * 1000));
            } while ((!$canWrite) and ((microtime(TRUE) - $startTime) < 5));

            if ($canWrite) {
                fwrite($fp, $data);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        } else {
			throw new \Exception('Rest api state file not save: Permission denied', 403);
		}
    }

}
