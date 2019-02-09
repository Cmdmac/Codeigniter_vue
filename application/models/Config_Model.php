<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_Model extends CI_Model {
	public function getPasswords() {
		$this->load->database();
		$q = $this->db->get('config');
		return $q->result_array();
	}

	public function updatePasswords($pwd1, $pwd2, $pwd3, $pwd4, $pwd5, $pwd6, $pwd7, $pwd8) {
		$this->load->database();
		// $this->db->update('config', array('pwd1' => $pwd1, 'pwd2' => $pwd2, 'pwd3' => $pwd3, 'pwd4' => $pwd4,
		// 	'pwd5' => $pwd5, 'pwd6' => $pwd6, 'pwd7' => $pwd7, 'pwd8' => $pwd8));
		$this->db->update('config', array('value' => $pwd1), array('_key' => 'pwd1'));
		$this->db->update('config', array('value' => $pwd2), array('_key' => 'pwd2'));
		$this->db->update('config', array('value' => $pwd3), array('_key' => 'pwd3'));
		$this->db->update('config', array('value' => $pwd4), array('_key' => 'pwd4'));
		$this->db->update('config', array('value' => $pwd5), array('_key' => 'pwd5'));
		$this->db->update('config', array('value' => $pwd6), array('_key' => 'pwd6'));
		$this->db->update('config', array('value' => $pwd7), array('_key' => 'pwd7'));
		$this->db->update('config', array('value' => $pwd8), array('_key' => 'pwd8'));
	}

	public function checkPassword($key, $password) {
		$this->load->database();
		$q = $this->db->get_where('config', array('_key'=>$key, 'value'=>$password));
		$r = $q->row();
		if (isset($r)) {
			return true;
		} else {
			return false;
		}
	}
}