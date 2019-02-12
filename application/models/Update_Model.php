<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_Model extends CI_Model {


	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function add($username, $level_from, $level_to, $contact) {
		return $this->db->insert('tbl_update', array('username' => $username, 'level_from' => $level_from, 'level_to' => $level_to, 'contact' => $contact));
	}

	public function hasAdd($username, $level_from, $level_to, $contact) {
		$r = $this->db->get_where('tbl_update', array('username' => $username, 'level_from' => $level_from, 'level_to' => $level_to, 'contact' => $contact));
		//var_dump($r->result());
		$arr = $r->result();
		return count($arr) > 0;
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
			if ($this->hasReviewed($username, $member->level, $member->level + 1, $contact)) {
				return false;
			}

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

	public function hasReviewed($username, $level_from, $level_to, $contact) {
		$r = $this->db->get_where('tbl_update', array('username' => $username, 'level_from' => $level_from, 'level_to' => $level_to, 'contact' => $contact));
		$row = $r->row();
		if (isset($row) && $row->state == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function listInvalides() {
		$r = $this->db->query('select * from tbl_update where state = 0 order by time desc limit 20');
		return $r->result_array();
	}

}