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
		header("Access-Control-Allow-Origin: http://localhost:8080"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}