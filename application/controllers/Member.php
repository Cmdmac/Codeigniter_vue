<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Member extends MY_Controller
{	
	public function __construct() {
		parent::__construct();
	}

	public function register() {
		$this->load->helper('url');
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$recommend = $this->input->post('recommend');

		$this->doRegister($name, $phone, $recommend);
	}

	private function doRegister($name, $phone, $recommend) {
		$this->load->model('Member_Model');
		//var_dump($r);
		if ($this->Member_Model->existsName($name)) {
			//var_dump($r);
			$this->json_with_code_msg('500', '会员已存在!');
		} else if ($this->Member_Model->existsPhone($phone)) {
			$this->json_with_code_msg('500', '电话已被注册');
		} else {
			//var_dump($r);
			$r = $this->Member_Model->addMember($name, $phone, $recommend);
			$this->json($r);
		}		
	}

	public function init() {
		//$this->load->helper('url');
		$this->load->model('Member_Model');
		$root = $this->Member_Model->getChildren('root');
		//var_dump($root);
		$r = $this->encode_children(current($root), 1);
		$this->json_with_data(200, 'ok', $r);
	}

	private function encode_children($node, $level) {
		//var_dump($node);
		if ($node == null) {
			return array();
		}
		$children = $this->Member_Model->getChildren($node['name']);
		//var_dump($children);
		$arr = array('name' => $node['name']);
		if ($level == 5) {
			return $arr;
		}
		foreach ($children as $item) {
			# code...
			$r = $this->encode_children($item, $level + 1);
			$arr['children'][] = $r;
		}
		return $arr;
	}

	public function getChildren() {
		$this->load->helper('url');
		$recommend = $this->input->get('recommend');
		if (empty($recommend)) {
			return $this->json_with_code_msg('500', '无效推荐人');
		}

		$this->load->model('Member_Model');

		$children = $this->Member_Model->getChildren($recommend);
		$this->json_with_data('200', 'ok', $children);
	}

	public function getMemberCount() {
		$this->load->helper('url');
		$this->load->model('Member_Model');
		$count = $this->Member_Model->getMembersCount();
		//var_dump($count);
		$this->json_with_data('200', 'ok', $count);
	}

	public function list() {
		$this->load->helper('url');
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$this->load->model('Member_Model');
		$list = $this->Member_Model->list($start, $end);
		$this->json_with_data('200', 'ok', $list);
	}

	public function init_test() {
		
		$arr = array('name' => 'A', 'phone' => '1', 'recommend' => '');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'B', 'phone' => '2', 'recommend' => 'A');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'C', 'phone' => '3', 'recommend' => 'A');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		
		
		$arr = array('name' => 'D', 'phone' => '4', 'recommend' => 'B');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		
		$arr = array('name' => 'E', 'phone' => '5', 'recommend' => 'B');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'F', 'phone' => '6', 'recommend' => 'C');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'G', 'phone' => '7', 'recommend' => 'C');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'H', 'phone' => '8', 'recommend' => 'D');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		$arr = array('name' => 'I', 'phone' => '9', 'recommend' => 'D');
		$this->doRegister($arr['name'], $arr['phone'], $arr['recommend']);
		
	}

}
?>