<?php
/**
 * 
 */
class User_Model extends CI_Model {
	

	function login($username, $password) {
		$this->load->database();
		$query = $this->db->get_where('user', array('username' => $username, 'password' => $password));
		//$result = $query->result();
		return $query->row();
	}

	function get($username) {
		$this->load->database();
		$query = $this->db->get_where('user', array('username' => $username));
		//$result = $query->result();
		return $query->row();
	}

	function register($username, $password, $phone, $wx, $alipay) {
		$this->load->database();
		if (isset($this->get($username)) {
			// 已存在，不插入
			return false;
		} else {
			/**
				1	-	未审核
				2	-	已审核 
				4	-	其他状态
			**/
			return $this->db->insert('user', array('username' => $username, 'password' => $password, 'phone' => $phone, 'wx' => $wx, 'alipay' => $alipay, 'type' => 1));
			//return true;
		}
	}

	public function active($username) {
		$this->load->database();
		$query = $this->db->get_where('user', array('username' => $username));
		//$result = $query->result();
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			$row = $query->row();
			return $this->db->update('user', array('state' => 2), array('username = ' => $row->username));
		}
	}

	public function disable($username) {
		$this->load->database();
		$query = $this->db->get_where('user', array('username' => $username));
		//$result = $query->result();
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			$row = $query->row();
			return $this->db->update('user', array('state' => 1), array('username = ' => $row->username));
		}
	}

	public function edit($id, $username, $password) {
		$this->load->database();
		$query = $this->db->get_where('user', array('id' => $id));
		//$result = $query->result();
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $this->db->update('user', array('username' => $username, 'password' => $password), array('id' => $id));
		}
	}

	public function list() {
		$this->load->database();
		$q = $this->db->get_where('user', array('type' => 1));
		return $q->result_array();
	}

	function add($id, $node) {
		$this->load->database();
		$this->load->library('treedatabase');
		$this->treedatabase->init('test1');
		// $this->nested_set->initialiseRoot();
		//$parent =  $this->nested_set->getNodesWhere('name="parent"');
		$node = array('comments' => 'child1');
		//return $this->nested_set->appendNewChild($parent, $node);
		//return $this->treedatabase->getChildrenCount(7, 2);
		return $this->treedatabase->insertNode($id = 1, $node);
	}
}