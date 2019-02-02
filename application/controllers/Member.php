<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Member extends Auth_Controller
{	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function register() {
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');
		$recommend = $this->input->post('recommend');
		$contact = $this->input->post('contact');
		$leaf = $this->input->post('leaf');

		$this->doRegister($username, $password, $phone, $wx, $alipay, $recommend, $contact, $leaf);
	}

	public function get() {
		$username = $this->input->get('username');
		$this->load->model("User_Member_Model");
		$member = $this->User_Member_Model->get($username);
		// echo $member;
		if (isset($member)) {
			$this->json_with_data(200, 'ok', $member);
		} else {
			$this->json_with_code_msg(500, '没有这个会员', $member);
		}
	}

	private function doRegister($username, $password, $phone, $wx, $alipay, $recommend, $contact, $leaf) {
		
		$this->load->model('Member_Model');
		//var_dump($r);

		// 查询用户表
		//$this->User_Model->get($username)

		if ($this->Member_Model->existsName($username)) {
			//var_dump($r);
			$this->json_with_code_msg(500, '会员已被注册过，请联系上级或管理员');
		} else /*if ($this->Member_Model->existsPhone($phone)) {
			$this->json_with_code_msg('500', '电话已被注册');
		} else*/ {
			//var_dump($r);
			//$this->load->library('treedatabase');
		//$this->treedatabase->init('member');
		
			// 先看推荐人是否在已有列表中，如果存在才可以注册
			$row = $this->Member_Model->getMember($recommend);
			//var_dump($row->line);
			if (isset($row)) {	

				// 看推荐人已经推荐过几个了，最多推荐2个
				$count = $this->Member_Model->getRecommendCount($recommend);
				if ($count >= 2) {
					// 推荐人满2人了
					return $this->json_with_code_msg(500, '推荐人已推荐满2个了');
				} else {
					$this->load->model('User_Model');
					$user = $this->User_Model->get($username);					
					// 检查业务方向
					$hasMemberAtLeaf = $this->Member_Model->getRecommendLeafCount($recommend, $leaf);
					if ($hasMemberAtLeaf == 0) {
						if (!isset($user)) {					
							// 用户表里没有，这个用户是第一次被注册，需要插入到用户表
							$this->User_Model->register($username, $password, $phone, $wx, $alipay);
							$user = $this->User_Model->get($username);
						}
						// 当这个业务方向还可以注册，插入到会员表
						$node = array('username' => $username, 'user_id' => $user->id,  'phone' => $phone, 'recommend' => $recommend, 'recommend_id' => $row->recommend_id, 'contact' => $contact, 'contact_id' => $user->id, 'leaf' => $leaf);
						if ($this->Member_Model->addMember($node)) {
							return $this->json_with_code_msg(200, '注册成功');
						} else {
							return $this->json_with_code_msg(500, '注册失败');
						}
					} else {
						$this->json_with_code_msg(500, '这个业务方向已经有人了');
					}
					
				}
			} else {

				if ($this->Member_Model->getMembersCount() == 0) {
					$this->load->model('User_Model');
					$user = $this->User_Model->get($username);		
					//$this->json_with_data(500, $user);
					if (!isset($user)) {					
							// 用户表里没有，这个用户是第一次被注册，需要插入到用户表
							$this->User_Model->register($username, $password, $phone, $wx, $alipay);
							$user = $this->User_Model->get($username);
					}

					$node = array('username' => $username, 'user_id' => $user->id,  'phone' => $phone, 'recommend' => $recommend, 'recommend_id' => $user->id, 'contact' => $contact, 'contact_id' => $user->id, 'leaf' => $leaf);
					//$this->json_with_data(500, $node);
					if ($this->Member_Model->addMember($node)) {
						return $this->json_with_code_msg(200, '推荐成功');
					} else {
						return $this->json_with_code_msg(500, '推荐人失败');
					}
				}
				return $this->json_with_code_msg(502, '推荐失败，不存在的推荐人');;
			}
			// $r = $this->Member_Model->addMember($name, $phone, $recommend);
			// $this->json($r);
		}		
	}

	public function update() {
		$this->load->helper('url');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');		

		/*
		if ($this->Member_Model->existsName($name)) {
			//var_dump($r);
			$this->json_with_code_msg('500', '会员已存在!');
		} else if ($this->Member_Model->existsPhone($phone)) {
			$this->json_with_code_msg('500', '电话已被注册');
		} else  {*/
			//var_dump($r);
			$this->load->model('Member_Model');
			$r = $this->Member_Model->updateMember($id, $name, $phone);
			if (!empty($r)) {
				$this->json_with_data(200, '更新会员成功', array('time' => $r));
			} else {
				$this->json_with_code_msg(500, '会员更新失败');
			}
		// }	
	}

	public function init() {
		//$this->load->helper('url');
		$this->load->model('Member_Model');
		$root = $this->Member_Model->getChildren('root');
		//var_dump($root);
		$r = $this->encode_children(current($root), 1, 3);
		$this->json_with_data(200, 'ok', $r);
	}

	private function encode_children($node, $level, $totalLevel) {
		//var_dump($node);
		if ($node == null) {
			return array();
		}
		$children = $this->Member_Model->getChildren($node['username']);
		//var_dump($children);
		$arr = array('name' => $node['username']);
		if ($level == $totalLevel) {
			return $arr;
		}
		foreach ($children as $item) {
			# code...
			$r = $this->encode_children($item, $level + 1, $totalLevel);
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

	public function getMembersByLevel($level) {
		$username = $this->input->get('username');
		$level = $this->input->get('level');

		$this->load->model('Member_Model');
		$root = $this->Member_Model->getChildren($username);
		$r = $this->encode_children(current($root), 1, $level);
		$this->json_with_data(200, 'ok', $r);
	}

	public function list() {
		$this->load->helper('url');
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$this->load->model('Member_Model');
		$list = $this->Member_Model->list($start, $end);
		$this->json_with_data('200', 'ok', $list);
	}

	public function findContact() {
		$username = $this->input->get('username');
		$contact = $this->findFirstContact($username);
		if ($contact != null) {
			$this->json_with_data(200, 'ok', $contact);
		} else {
			$this->json_with_code_msg(500, '没有符合条件的接点人');
		}
	}
	/**
		查询第一个符合条件的接点人
	**/
	private function findFirstContact($username) {
		$this->load->model('Member_Model');
		return $this->Member_Model->findFirstContact($username);
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