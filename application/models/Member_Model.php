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

	public function updateMember($id, $username, $phone) {
		$member = $this->getMemberById($id);
		if (isset($member)) {
			$data = array('id' => $id, 'username' => $name, 'phone' => $phone, 'recommend' => $member->recommend, 'time' => date('Y-m-d H:i:s', time()));
			if ($this->db->replace('member', $data)) {
				return $data['time'];
			}
		} else {
			return '';
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