<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Member_Model extends CI_Model {

	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function get($username) {
		$r = $this->db->query("select user.id as uid, user.username as username, user.type as type, user.state as state, member.level as level, user.phone as phone, user.wx as wx, user.alipay as alipay, member.recommend as recommend, member.contact as contact, member.leaf as leaf from `user`, `member` where `user`.username = `member`.username AND `member`.username = \"".$username."\"");
		return $r->row();
	}
}