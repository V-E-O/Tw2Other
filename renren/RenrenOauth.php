<?php
class RenrenOauth {
	
	public function accessTokenURL() {
		return 'http://graph.renren.com/oauth/token';
	}
	
	public function authorizeURL() {
		return 'http://graph.renren.com/oauth/authorize';
	}
	
	public function getAuthorizeURL($consumer_key, $scope, $callback) {		
		return $this->authorizeURL () . "?response_type=code&scope={$scope}&client_id={$consumer_key}&redirect_uri=" . urlencode ( $callback );
	}
	
	public function getAccessToken($authorization_code, $callback) {
		$request = array (
		    "client_id"  => RENREN_API_KEY,
		    "client_secret" => RENREN_API_SECRET,
		    "redirect_uri"  => $callback,
		    "grant_type" => 'authorization_code',
		    "code" => $authorization_code
		);
		
		return $this->httpRequest ( $this->accessTokenURL (), $request, 2 );
	}
	
	public function refreshToken($refresh_token) {
		$request = array (
		    "client_id"  => RENREN_API_KEY,
		    "client_secret" => RENREN_API_SECRET,
		    "refresh_token"  => $refresh_token,
		    "grant_type" => 'refresh_token'
	   	);

		return $this->httpRequest ( $this->accessTokenURL (), $request, 2 );
	}
	
	public function httpRequest($url, $params = null, $decode = 0) {
		$curlHandle = curl_init ( $url );
		if (! empty ( $params )) {
			curl_setopt ( $curlHandle, CURLOPT_POST, true );
			if (is_array ( $params )) {
				$params = http_build_query ( $params );
			}
			
			echo $params;
			curl_setopt ( $curlHandle, CURLOPT_POSTFIELDS, $params );
		}
		
		curl_setopt ( $curlHandle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curlHandle, CURLOPT_TIMEOUT, 15 );
		curl_setopt ( $curlHandle, CURLOPT_ENCODING, 'UTF-8' );
		
		$response = curl_exec ( $curlHandle );
		curl_close ( $curlHandle );
		$response = trim ( $response );
		
		switch ($decode) {
			case 0 :
				return $response;
				break;
			case 1 :
				return json_decode ( $response );
				break;
			case 2 :
				return json_decode ( $response, true );
				break;
			default :
				return $response;
				break;
		}
	}

}
?>
