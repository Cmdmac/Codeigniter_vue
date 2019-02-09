<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends Auth_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->type == 0) {

			} else {
				$this->json_with_code_msg(500, '非系统管理员, 无权限');
			}
		} else {
			$this->json_with_code_msg(500, '系统管理员未登录');
		}
	}

	public function add() {
		$this->load->helper('url');
		$this->load->library('session');
		
				// supper manager
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$this->load->model('User_Model');
		if ($this->User_Model->registerWithType($username, $password, $phone, $wx, $alipay, 0)) {
			$this->json_with_code_msg(200, '注册成功');
		} else {
			$this->json_with_code_msg(1001, '注册失败，用户名已存在');
		}

	}

	public function active() {
		$this->load->helper('url');
		$this->load->library('session');
		
		$username = $this->input->post('username');
		$this->load->model('User_Model');
		if ($this->User_Model->active($username)) {
			$this->json_with_code_msg(200, '审核通过');
		} else {
			$this->json_with_code_msg(200, '审核失败');
		}

	}

	public function disable() {
		$this->load->helper('url');
		$this->load->library('session');
		
		$username = $this->input->post('username');
		$this->load->model('User_Model');
		if ($this->User_Model->disable($username)) {
			$this->json_with_code_msg(200, '已停用');
		} else {
			$this->json_with_code_msg(500, '停用失败');
		}
			
	}

	public function edit() {
		$this->load->helper('url');
		$this->load->library('session');
		
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$this->load->model('User_Model');
		if ($this->User_Model->edit($id, $username, $password, $phone, $wx, $alipay)) {
			$this->json_with_code_msg(200, '编辑成功');
		} else {
			$this->json_with_code_msg(500, '编辑失败');
		}
	
	}

	public function list() {
		$this->load->helper('url');
		$this->load->library('session');
		
		$this->load->model('User_Model');
		$list = $this->User_Model->managerLists();
		//var_dump($list);
		$this->json_with_data('200', 'ok', $list);
		
	}

	public function test() {
		$this->load->helper('url');
		echo $this->input->cookie('username');
	}

	public function getPassword() {
		$this->load->model('Config_Model');
		$r = $this->Config_Model->getPasswords();
		return $this->json_with_data(200, 'ok', $r);
	}

	public function updatePassword() {
		$pwd1 = $this->input->post('pwd1');
		$pwd2 = $this->input->post('pwd2');
		$pwd3 = $this->input->post('pwd3');
		$pwd4 = $this->input->post('pwd4');
		$pwd5 = $this->input->post('pwd5');
		$pwd6 = $this->input->post('pwd6');
		$pwd7 = $this->input->post('pwd7');
		$pwd8 = $this->input->post('pwd8');

		$this->load->model('Config_Model');
		$r = $this->Config_Model->updatePasswords($pw1, $pw2, $pwd3, $pwd4, $pwd5, $pwd6, $pwd7, $pwd8);
		$this->json_with_code_msg(200, 'ok');
	}
}
?>