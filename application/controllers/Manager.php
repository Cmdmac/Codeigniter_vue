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
				$this->User_Model->active($username);
			}
		}
	}

	public function list() {
		$this->load->helper('url');
		$this->load->library('session');
		if ($this->session->has_userdata('username') && $this->session->has_userdata('type')) {
			if ($this->session->username == 'admin' && $this->session->type == 0) {
				
				$list = $this->User_Model->list();
				$this->json_with_data('200', $list);
			}
		}
	}
}
?>