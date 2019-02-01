<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check extends Auth_Controller {
	public function checkPassword() {
		$this->load->helper('url');
		$level = $this->input->post('level');
		$password = $this->input->post('password');
	}
}