<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function register() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$isValideParams = $this->checkParams($username, $password);
		if ($isValideParams) {
			$this->load->model('User_Model');
			if ($this->User_Model->register($username, $password, $phone, $wx, $alipay)) {
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
			
			if ($this->hasLogin($username)) {
				$username = $this->session->username;
				$type = $this->session->type;
				//$this->json();
				$r = array('code' => '200', 'msg' => $username.' has login', 'username' => $username, 'type' => $type, 'token' => $this->session->token);
				$this->json($r);
			} else {
				$this->load->model('User_Model');
				$user = $this->User_Model->login($username, $password);
				if (isset($user)) {
					//var_dump($user);
					/*
					if ($user->state == 1) {
						return $this->json_with_code_msg('500', '未审核状态');
					} elseif ($user->state > 2) {
						return $this->json_with_code_msg('500', '未知状态');
					}
					*/
					$data = array('username' => $username, 'token' => time(), 'type' => $user->type);
					$this->session->set_userdata($data);
					 $this->input->set_cookie("username", $username, 3600);
					$r = array('code' => '200', 'msg' => $username.' login success', 'username' => $user->username, 'type' => $user->type, 'token' => $data['token'], 'has_session' => $this->session->has_userdata('username'));
					//$this->json();	
					$this->json($r);
				} else {
					$this->json_with_code_msg(1001, '用户名或密码错误');
				}		
			}
		}
	}

	private function hasLogin($username) {
		$this->load->library('session');
		//var_dump($this->session->has_userdata('username') && $this->session->username == $username && (time() - $this->session->token < 3600));
		return $this->session->has_userdata('username') && $this->session->username == $username && (time() - $this->session->token < 3600);
	}

	public function loginByToken() {
		$username = $this->input->post('username');
		$token = $this->input->post('token');

		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->username == $username) {
			if ($this->session->has_userdata('token') && (time() - $this->session->token > 3600)) {
				$this->json_with_code_msg(401, '登录过期');
			} else {
				$this->json_with_code_msg(200, '已登录');
			}
		} else {
			$this->json_with_code_msg(401, '未登录');
		}
	}

	public function logout() {
		$username = $this->input->post('username');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->username == $username) {
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('token');
			$this->session->unset_userdata('type');
			$this->json_with_code_msg(200, '已退出');
		} else {
			$this->json_with_code_msg(401, '未登录'.$username);
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

	public function get() {
		$username = $this->input->get('username');
		if ($this->hasLogin($username)) {
			$this->load->model('User_Member_Model');
			$user = $this->User_Member_Model->get($username);
			if (isset($user)) {
				$this->json_with_data(200, 'ok', $user);
			} else {
				$this->load->model('User_Model');
				$user = $this->User_Model->get($username);
				// var_dump($user);
				if (isset($user)) {
					$this->json_with_data(201, '没有在团队中', $user);
				} else {
					$this->json_with_code_msg(500, '没有这个会员');
				}
			}
		} else {
			$this->json_with_code_msg(401, '未登录 ');
		}
	}

	//管理员修改
	public function update() {
		$old_username = $this->input->post('old_username');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$this->load->model('User_Model');
		$user = $this->User_Model->get($old_username);
		if (isset($user)) {
			//管理员
			if ($this->isManager()) {
				//$this->json_with_data(200, 'ok', $user);
				if (!$this->User_Model->updateUserName($old_username, $username, $password, $level, $phone, $wx, $alipay)) {
					$this->json_with_code_msg(500, '更新失败');
				} else {
					// 更新了用户表，还需要更新会员表，否则信息对不上
					$this->load->model('Member_Model');
					$member = $this->Member_Model->getMember($old_username);
					if (isset($member)) {
						$this->Member_Model->updateMember($old_username, $username);
					} else {

					}
					$this->json_with_code_msg(200, '更新成功');
				}
			} else {
				$this->json_with_code_msg(500, '不是管理员');
			}
		} else {
			$this->json_with_code_msg(500, '没有这个用户');
		}
	}

	//自己修改
	public function modify() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$new_password = $this->input->post('new_password');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$this->load->model('User_Model');
		$user = $this->User_Model->get($username);
		if (isset($user)) {
			if ($password != $user->password) {
				$this->json_with_code_msg(500, '旧密码不正确');
				return;
			}
			//$this->json_with_data(200, 'ok', $user);
			if (!$this->User_Model->update($username, $new_password, $phone, $wx, $alipay)) {
				$this->json_with_code_msg(500, '更新失败');
			} else {
				$this->json_with_code_msg(200, '更新成功');
			}
		} else {
			$this->json_with_code_msg(500, '没有这个用户');
		}
	}

	public function test() {
		//$this->load->view('User');
		//$sessionpath = session_save_path();
			$this->load->library('session');;

		echo $this->session->username;
	}

}