<?php

class HttpClient
{

    public $url;

    public function call($endPoint, $request='GET', $post = null, $headers = array(), $content_type = 'json', $returnAsArray=false, $noResponse = false) {

        $options = array(
			CURLOPT_HEADER      	=> 0,
			CURLOPT_URL             => $this->url . trim($endPoint),
			CURLOPT_FRESH_CONNECT   => 1,
			CURLOPT_USERAGENT       => "API CLIENT",
			CURLOPT_CUSTOMREQUEST	=> $request,
			CURLOPT_FORBID_REUSE    => 1,
			CURLOPT_SSL_VERIFYPEER  => 0,
			CURLOPT_SSL_VERIFYHOST  => 0
		);

		if($content_type=='json') {
			$headers[] = 'content-type: application/json';
		}

		if($noResponse) {
			$options[CURLOPT_CONNECTTIMEOUT] = 1;
			$options[CURLOPT_TIMEOUT] = 1;
			$options[CURLOPT_RETURNTRANSFER] = false;
		}
		else {
			$options[CURLOPT_TIMEOUT] = 0;
			$options[CURLOPT_RETURNTRANSFER] = true;
		}

		if($post) {
			//$options[CURLOPT_POST] = 1;
			if($content_type=='json') {
			    //print_r(json_encode($post));exit;
			    $options[CURLOPT_POSTFIELDS] = json_encode($post);
			}
			else {
				$options[CURLOPT_POSTFIELDS] = http_build_query($post, '', "&");
			}
		}

		if(!empty($headers)) {
			$options[CURLOPT_HTTPHEADER] = $headers;
		}
		$curl = curl_init();
		curl_setopt_array($curl, ($options));
		if($noResponse) {
			curl_exec($curl);
			curl_close($curl);
			return true;
		} else {
			if (!$result = curl_exec($curl)) {
                var_dump('Curl error: ' . curl_error($curl));
				curl_close($curl);
				return false;
			}
			//var_dump($result);exit;

			$responseContentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
			curl_close($curl);

			if (strpos($responseContentType,'application/json')!==false || !$responseContentType) {
				$encoding = mb_detect_encoding($result);

				if(strpos($result,"}")!==false) {
					$result = trim(substr($result, 0, strrpos( $result, '}')+1));
				}
				if ($encoding == 'UTF-8') {
					//$result = preg_replace('/[^(\x20-\x7F)]*/', '', $result);
				}

				if($returnAsArray) {
					$result = json_decode($result, 1);
				}
				else {
					$result = json_decode($result);
				}

				if (!empty($result)) {
					return $result;
				} else {
					return false;
				}
			} else {
				return $result;
			}
		}
	}
}
