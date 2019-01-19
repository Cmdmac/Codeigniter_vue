<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->helper('url');

		//echo "string";
		$this->checkSession();
	}

	private function checkSession() {
		$this->load->library('session');
		if ($this->session->has_userdata('username') &&  $this->session->has_userdata('last_login_time')) {
			$distance = time() - $this->session->last_login_time;
			if ($distance >= 12 * 3600 * 1000) {
				$this->json_with_code_msg('500', '登录已超时');
				exit();
			}
		}
	}

	protected function json($data) {
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://hgx830330.applinzi.com"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	protected function json_with_code_msg($code, $msg) {
		$data = array('code' => $code, 'msg' => $msg);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://hgx830330.applinzi.com"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	protected function json_with_data($code, $msg, $data) {
		$data = array('code' => $code, 'msg' => $msg, 'data' => $data);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://hgx830330.applinzi.com"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}