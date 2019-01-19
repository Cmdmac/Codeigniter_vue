<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	protected function json($data) {
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.31.8:8080"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	protected function json_with_code_msg($code, $msg) {
		$data = array('code' => $code, 'msg' => $msg);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.31.8:8080"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	protected function json_with_data($code, $msg, $data) {
		$data = array('code' => $code, 'msg' => $msg, 'data' => $data);
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Origin: http://192.168.31.8:8080"); 
		header('Content-Type: application/json');
		echo json_encode($data);
	}

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
				$type = $this->session->type;
				//$this->json();
				$r = array('code' => '200', 'msg' => $username.' has login', 'username' => $username, 'type' => $type);
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
					 $this->input->set_cookie("username", $username, 3600);
					$r = array('code' => '200', 'msg' => $username.' login success', 'username' => $user->username, 'type' => $user->type, 'last_login_time' => $data['last_login_time'], 'has_session' => $this->session->has_userdata('username'));
					//$this->json();	
					$this->json($r);
				} else {
					$this->json_with_code_msg(1001, '用户名或密码错误');
				}		
			}
		}
	}

	public function logout() {
		$username = $this->input->post('username');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->username == $username) {
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('last_login_time');
			$this->session->unset_userdata('type');
			$this->json_with_code_msg(200, '已退出');
		} else {
			$this->json_with_code_msg(200, '未登录');
		}
	}

	private function checkParams($username, $password) {
		if (empty($username) || empty($password)) {
			$data = array('code' => '1001', 'msg' => '用户名或密码不能为空');			
			$this->json($data);
			return false;
		}
		return true;
	}



	public function test() {
		//$this->load->view('User');
		$sessionpath = session_save_path();

		echo $sessionpath;
	}

}