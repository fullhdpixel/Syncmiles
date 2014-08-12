<?php

class Litepaid {

	private $key;
	private $value;
	private $description;
	private $url;
	private $test;


	public function __construct($key) {
		$this->key = $key;
	}

	public function checkPayment($id) {

		$url = 'http://litepaid.com/api?id='.urlencode($id).'&key='.urlencode($this->key);

		$call = $this->request($url);

		if($call !== false) {

			$response = json_decode($call);

			if(strstr($response[0], 'success')) {
				return true;
			} else {
				return $response[1];
			}
		} else {
			echo 'API CALL FAILED';
			exit;
		}
	}

	public function newInvoice() {
		$url = 'https://litepaid.com/api?value='.urlencode($this->value).'&key='.urlencode($this->key).'&return_url='.urlencode($this->url).'&description='.urlencode($this->description).'&test='.urlencode($this->test);

		$call = $this->request($url);

		if($call !== false) {
			$response = json_decode($call);

			if($response[0] == 'success') {
				$this->redirect('https://www.litepaid.com/invoice?invoice='.$response[1]);
				return true;

			} else {
				return $response[1];
			}
		} else {
			echo 'API CALL FAILED';
			exit;
		}
	}

	private function request($url) {

		$result = file_get_contents($url);

		if($result === false) {
			return false;
		}
		return $result;
	}


	public function setValue($value) {
		$this->value = $value;
	}

	public function setReturnURL($url) {
		$this->url = $url;
	}

	public function setTest($test) {
		$this->test = $test;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function redirect($url) {
		ob_start();
		header('Location: '.$url);
		ob_end_flush();
		exit;	
	}
}