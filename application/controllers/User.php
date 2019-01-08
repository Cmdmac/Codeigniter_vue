<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function register() {
		echo "string";
	}

	public function login() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$isValideParams = $this->checkParams($username, $password);
		if ($isValideParams) {
			$this->load->library('session');
			if ($this->session->has_userdata('username') && $this->session->username == $username) {
				$username = $this->session->username;
				//$this->json();
				$r = array('code' => '200', 'msg' => $username.' has login');
				$this->json($r);
			} else {
				$data = array('username' => $username, 'last_login_time' => time());
				$this->session->set_userdata($data);
				$r = array('code' => '200', 'msg' => $username.' login success', 'last_login_time' => $data['last_login_time'], 'has_session' => $this->session->has_userdata('username'));
				//$this->json();	
				$this->json($r);
			}
		}
	}

	private function checkParams($username, $password) {
		if (empty($username) || empty($password)) {
			$data = array('code' => '1001', 'msg' => 'username or password is empty');			
			$this->json($data);
			return false;
		}
		return true;
	}

	public function test() {
		//$this->load->view('User');
		$this->load->library('session');

		if ($this->session->has_userdata('username')) {
			$this->session->set_userdata('username', 'test');
			$username  = $this->session->username;
			echo $this->session->has_userdata('username').$username.'sss';
		}
	}
}