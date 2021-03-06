<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Model extends CI_Model {


	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function existsName($username) {
		$row = $this->getMember($username);
		return isset($row);
	}

	public function existsPhone($phone) {
		$q = $this->db->get_where('member', array('phone' => $phone));
		$row = $q->row();
		return isset($row);
	}

	public function addMember($node) {
		return $this->db->insert('member', $node);
	}

	public function updateMember($old_username, $username/*, $phone*/) {
		$this->db->update('member', array('recommend' => $username), array('recommend' => $old_username));
		$this->db->update('member', array('contact' => $username), array('contact' => $old_username));
		$data = array('username' => $username/*, 'phone' => $phone*/);
		if ($this->db->update('member', $data, array('username' => $old_username))) {
			return true;
		} else {
			return false;
		}
	}

	public function updateMemberLevel($username, $level) {
		if ($this->db->update('member', array('level' => $level), array('username' => $username))) {
			return true;
		} else {
			return false;
		}
	}


	public function findFirstContact($username) {
		//$username = $this->input->get('username');
		$this->load->model('User_Member_Model');
		$member = $this->User_Member_Model->get($username);
		// var_dump($username);
		if (!isset($member)) {
			// $this->json_with_code_msg(500, '会员不存在');
			return null;
		} else {
			//$this->load->model('User_Member_Model');
			// var_dump($username);
			$contactMember = $this->User_Member_Model->get($member->contact);
			if (isset($contactMember)) {
				$contactLevel = $contactMember->level;
				if ($contactLevel <= $member->level) {
					// var_dump($member->contact);
					// var_dump($contactMember->contact);
					//如果当前接点人的级别小于自己,往上查找符合条件的接点人
					if ($contactMember->contact == 'root'/*$contactMember->username*/) {
						//一般是管理员数据才会这样
						return $contactMember;
					}
					return $this->findFirstContact($contactMember->contact);
				} else {
					//$this->json_with_data(200, 'ok', $contactMember);
					return $contactMember;
				}
			} else {
				if ($member->contact == 'root') {
					return $member;
				}
				// 会员表里找不到，看是否是管理员，管理员可以注册会员
				/*$this->load->model('User_Model');
				$user = $this->User_Model->get($member->contact);
				//var_dump($user);
				if (isset($user) && $user->type == 0) {
					//管理员
					//var_dump($user);
					return array('username', $user->username, 'contact' => $user->username);
				}*/
				return null;
			}			
		}
	}
/*
	private function checkRecommend($recommend) {
		if ($this->existsName($recommend)) {}
			$q = $this->db->get_where('member', array('recommend' => $recommend));
			if ($q->num_rows() > 2) {
				return 100;
			}
		}
		return 200;
	}
*/
	public function getMembersCount() {
		//$q = $this->db->get_where('member', array('line>' => 0));
		$q = $this->db->query('select count(*) as c from member');
		//var_dump($q->row());
		return $q->row()->c;
	}

	public function getRecommendLeafCount($recommend, $leaf) {
		$q = $this->db->get_where('member', array('recommend' => $recommend, 'leaf' => $leaf));
		return $q->num_rows();
	}

	public function getMember($name) {
		$q = $this->db->get_where('member', array('username' => $name));
		return $q->row();
	}

	public function getRecommendCount($recommend) {
		$q = $this->db->get_where('member', array('recommend' => $recommend));
		return $q->num_rows();
	}

	private function getMemberById($id) {
		$q = $this->db->get_where('member', array('id' => $id));
		return $q->row();
	}

	public function getChildren($recommend) {
		$q = $this->db->get_where('member', array('recommend' => $recommend));
		return $q->result_array();
	}

	public function list($start, $end) {
		$q = $this->db->get_where('member', array('time>=' => $start, 'time<=' => $end));
		return $q->result_array();
	}	
}
?>