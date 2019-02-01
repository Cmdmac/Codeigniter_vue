<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Member_Model extends CI_Model {

	public function __construct() {
		// echo 'hhh';
		parent::__construct();
		$this->load->database();
	}

	public function get($username) {
		$r = $this->db->query("select * from `user`, `member` where `user`.username = `member`.username AND `member`.username = \"".$username."\"");
		return $r->row();
	}
}