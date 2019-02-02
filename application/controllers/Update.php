<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Update extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		// $r = $this->checkPassword();
		// if ($r == false) {
		// 	$this->json_with_code_msg(401, '需要密码');
		// }
	}

	private function checkPassword() {
		// $this->input->set_cookie("username", $username, 3600);
		$this->load->helper('cookie');
		$level = $this->input->cookie('level');
		$pwd = $this->input->cookie('password_'.$level);
		if (empty($pwd)) {			
			return false;
		}
		return true;
	}

	public function add() {
		$username = $this->input->post('username');
		$this->load->model('Member_Model');
		$contact = $this->Member_Model->findFirstContact($username);
		if ($contact != null) {
			//$this->json_with_data(200, 'ok', $contact);
			//var_dump($contact);
			$this->load->model('Update_Model');
			$member = $this->Member_Model->getMember($username);
			if (!isset($member)) {
				$this->json_with_code_msg(500, '申请失败，没有这个会员');
				return;
			}

			if ($this->Update_Model->hasAdd($member->username, $member->level, $member->level + 1, $contact->username)) {
				$this->json_with_code_msg(500, '已申请过');
				return;
			}
			if ($this->Update_Model->add($member->username, $member->level, $member->level + 1, $contact->username)) {
				$this->json_with_code_msg(200, '申请成功');
			} else {
				$this->json_with_code_msg(500, '申请失败');
			}
		} else {
			//$this->json_with_code_msg(500, '没有符合条件的接点人');
			$this->json_with_code_msg(500, '申请失败，没有符合条件的接点人');
		}
	}

	public function getUpdateRecords() {
		$username = $this->input->get('username');
		$this->load->model('Update_Model');
		$records = $this->Update_Model->getValideUpdates($username);
		if (isset($records)) {
			$this->json_with_data(200, 'ok', $records);
		} else {
			$this->json_with_code_msg(500, '没有结果');
		}
	}

	public function getReviewRecords() {
		$username = $this->input->get('username');
		$this->load->model('Update_Model');
		$records = $this->Update_Model->getInValideUpdates($username);
		if (isset($records)) {
			$this->json_with_data(200, 'ok', $records);
		} else {
			$this->json_with_code_msg(500, '没有结果');
		}
	}

	/**
		审核，
	**/
	public function review() {
		$username = $this->input->post('username');
		$contact = $this->input->post('contact');
		$this->load->model('Member_Model');
		$contactFind = $this->Member_Model->findFirstContact($username);
		if ($contact != $contactFind->username) {
			$this->json_with_code_msg(500, '你不是'.$username."的审核人");
		} else {
			//审核
			// 通过时，修改会员的等级、会员的接点人
			$this->load->model('Update_Model');
			if ($this->Update_Model->review($username, $contact)) {
				$this->json_with_code_msg(200, "审核通过");
			} else {
				$this->json_with_code_msg(500, "审核失败，已审核过或者没有这个升级记录");
			}
			// 修改账号等级
		}
	}
}