<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function register() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$isValideParams = $this->checkParams($username, $password);
		if ($isValideParams) {
			$this->load->model('User_Model');
			if ($this->User_Model->register($username, $password)) {
				$this->json_with_code_msg(200, '注册成功');
			} else {
				$this->json_with_code_msg(1001, '注册失败，用户名已存在');
			}
		}
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
				$this->load->model('User_Model');
				$user = $this->User_Model->login($username, $password);
				if (isset($user)) {
					//var_dump($user);
					if ($user->state == 1) {
						return $this->json_with_code_msg('500', '未审核状态');
					} elseif ($user->state > 2) {
						return $this->json_with_code_msg('500', '未知状态');
					}
					$data = array('username' => $username, 'last_login_time' => time(), 'type' => $user->type);
					$this->session->set_userdata($data);
					$r = array('code' => '200', 'msg' => $username.' login success', 'last_login_time' => $data['last_login_time'], 'has_session' => $this->session->has_userdata('username'));
					//$this->json();	
					$this->json($r);
				} else {
					$this->json_with_code_msg(1001, 'username or password is not correct');
				}		
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
		$this->load->model('User_Model');
		$node = $this->User_Model->test();
		echo json_encode($node);
	}

}