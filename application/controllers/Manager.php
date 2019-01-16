<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MY_Controller {

	public function add() {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				// supper manager
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$this->load->model('User_Model');
				if ($this->User_Model->register($username, $password)) {
					$this->json_with_code_msg(200, 'register success');
				} else {
					$this->json_with_code_msg(1001, 'register failure, user already exitst!');
				}
			}
		}
	}

	public function active() {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				$username = $this->input->post('username');
				$this->load->model('User_Model');
				if ($this->User_Model->active($username)) {
					$this->json_with_code_msg(200, '审核通过');
				} else {
					$this->json_with_code_msg(200, '审核失败');
				}
			} else {
				$this->json_with_code_msg(500, '非系统管理员, 无权限');
			}
		} else {
			$this->json_with_code_msg(500, '系统管理员未登录');
		}
	}

	public function disable() {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				$username = $this->input->post('username');
				$this->load->model('User_Model');
				if ($this->User_Model->disable($username)) {
					$this->json_with_code_msg(200, '已停用');
				} else {
					$this->json_with_code_msg(500, '停用失败');
				}
			} else {
				$this->json_with_code_msg(500, '非系统管理员, 无权限');
			}
		} else {
			$this->json_with_code_msg(500, '系统管理员未登录');
		}		
	}

	public function edit($username) {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				$id = $this->input->post('id');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$this->load->model('User_Model');
				if ($this->User_Model->edit($id, $username, $password)) {
					$this->json_with_code_msg(200, '编辑成功');
				} else {
					$this->json_with_code_msg(500, '编辑失败');
				}
			} else {
				$this->json_with_code_msg(500, '非系统管理员, 无权限');
			}
		} else {
			$this->json_with_code_msg(500, '系统管理员未登录');
		}
	}

	public function list() {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				$this->load->model('User_Model');
				$list = $this->User_Model->list();
				//var_dump($list);
				$this->json_with_data('200', 'ok', $list);
			}
		} else {
			$this->json_with_code_msg('500', '未登录');
		}
	}
}
?>