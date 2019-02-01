<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_Model extends CI_Model {


	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function add($username, $contact) {
		return $this->db->insert('tbl_update', array('username' => $username, 'contact' => $contact));
	}

	public function getValideUpdates($username) {
		$r = $this->db->query('select * from tbl_update where state = 1 AND (username = "'.$username.'" OR contact = "'.$username.'" )');
		return $r->result_array();
	}

	//审核列表
	public function getInValideUpdates($username) {
		$r = $this->db->query('select * from tbl_update where state = 0 AND contact = "'.$username.'"');
		return $r->result_array();
	}

	public function review($username, $contact) {
		$this->load->model('Member_Model');
		$member = $this->Member_Model->getMember($username);
		if (isset($member)) {
			$member->level = $member->level + 1;
			$member->contact = $contact;

			if ($this->db->replace('member', $member)) {
				$this->load->model('User_Model');
				if ($this->User_Model->updateLevelAndState($username, $member->level, 2)) {
					$this->db->update('tbl_update', array('state' => 1), array('username' => $username, 'contact' => $contact));
					return true;
				}
			}
		} 

		return false;
		
	}
}