<?php
class Sendmachine
{
	private $api_host = 'https://api.sendmachine.com';
	private $curl;
	private $username;
	private $password;
	private $debug = true;
	function __construct($date)
	{
		$this->username = $date['username'];
		$this->password = $date['password'];
		
		$this->curl = curl_init();
	}
	public function lists(){
		//$this->request('/sender/list', 'GET');
		$this->request('/account/package', 'GET');
	}
	public function recipients($list_id, $limit = 25, $offset = 0, $filter = 'all', $order_by = 'email', $segment_id = 0){
		$params = ['limit' => $limit, 'offset' => $offset, 'filter' => $filter, 'orderby' => $order_by, 'sid' => $segment_id];
		
		return $this->request('/list/' . $list_id, 'GET', $params);
	}
	public function manage_contacts($list_id, $emails = "", $action = 'subscribe', $list_name = null) {
		$params = ['contacts' => $emails, 'action' => $action, 'name' => $list_name];
		return $this->request('/list/' . $list_id, 'POST', $params);
	}
	public function request($url, $method, $params = array()) {
		$ch = $this->curl;
		
		switch (strtoupper($method)) {
			case 'GET':
				if (count($params)) {
					$url .= "?" . http_build_query($params);
				}
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				break;
			case 'PUT':
			case 'POST':
				$params = json_encode($params);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($params)]);
				break;
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
				break;
		}
		
		$final_url = $this->api_host . $url;
		
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $final_url);
		curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
		
		if ($this->debug) {
			$start = microtime(true);
			$this->log('URL: ' . $this->api_host . $url . (is_string($params) ? ", params: " . $params : ""));
		}
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($this->debug) {
			$time = microtime(true) - $start;
			$this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
			$this->log('Response: ' . $response);
		}
		if (curl_error($ch)) {
			throw new Http_Error("API call to $this->api_host$url failed.Reason: " . curl_error($ch));
		}
		$result = json_decode($response, true);
		if ($response && !$result)
			$result = $response;
		if ($info['http_code'] >= 400) {
			$this->set_error($result);
		}
		return $result;
	}
	
	public function log($msg) {
		error_log($msg);
	}
	public function set_error($result) {
		if (is_array($result)) {
			if (empty($result['error_reason'])) {
				if (!empty($result['status']))
					$result['error_reason'] = $result['status'];
				else
					$result['error_reason'] = "Unexpected error";
			}
			//throw new Sendmachine_Error($result['error_reason'], $result['status']);
		}
	}
	
}