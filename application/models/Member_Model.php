<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Model extends CI_Model {


	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function existsName($name) {
		$row = $this->getMember($name);
		return isset($row);
	}

	public function existsPhone($phone) {
		$q = $this->db->get_where('member', array('phone' => $phone));
		$row = $q->row();
		return isset($row);
	}

	public function addMember($name, $phone, $recommend) {
		//$this->load->library('treedatabase');
		//$this->treedatabase->init('member');
		
		// 先看推荐人是否在已有列表中，如果存在才可以注册
		$row = $this->getMember($recommend);
		//var_dump($row->line);
		if (isset($row)) {	
			// 看推荐人已经推荐过几个了，最多推荐2个
			$q = $this->db->get_where('member', array('recommend' => $recommend));
			if ($q->num_rows() >= 2) {
				// 推荐人满2人了
				return array('code' => 100, 'msg' => '推荐人已推荐满2个了');
			} else {
				$node = array('name' => $name, 'phone' => $phone, 'recommend' => $recommend);
				
				if ($this->db->insert('member', $node)) {
					return array('code' => 200, 'msg' => '推荐成功');;
				} else {
					return array('code' => 501, 'msg' => '推荐人失败');;
				}
				
			}
		} else {
			if ($this->getMembersCount() == 0) {
				$node = array('name' => $name, 'phone' => $phone, 'recommend' => '第一个', 'level' => 1, 'line' => 1);
				if ($this->db->insert('member', $node)) {
					return array('code' => 100, 'msg' => '推荐成功，是第一个会员');;
				}
			}
			return array('code' => 502, 'msg' => '推荐失败，不存在的推荐人');;
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

	private function getMember($name) {
		$q = $this->db->get_where('member', array('name' => $name));
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