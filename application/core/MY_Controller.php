<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->helper('url');	
	}
	
	protected function json($data) {
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.43.177:8080"); 
		header('Content-Type: application/json');
		exit(json_encode($data));
	}

	protected function json_with_code_msg($code, $msg) {
		$data = array('code' => $code, 'msg' => $msg);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.43.177:8080"); 
		header('Content-Type: application/json');
		exit(json_encode($data));
	}

	protected function json_with_data($code, $msg, $data) {
		$data = array('code' => $code, 'msg' => $msg, 'data' => $data);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.43.177:8080"); 
		header('Content-Type: application/json');
		exit(json_encode($data));
	}
}

class Auth_Controller extends MY_Controller {

	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		//echo "string";
		$this->checkSession();
	}

	private function checkSession() {
		$this->load->library('session');
		if ($this->session->has_userdata('username') &&  $this->session->has_userdata('token')) {
			$distance = time() - $this->session->token;
			if ($distance >= 3600) {
				$this->json_with_code_msg('401', '登录已超时');
				exit();
			}
		} else {
			$this->json_with_code_msg('401', '未登录');
			exit();
		}
	}

}