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

		$username = trim($username);

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
			$this->json_with_code_msg(500, '没有这个会员');			
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
			//var_dump($recommend);
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
						$node = array('username' => $username, /*'phone' => $phone,*/ 'recommend' => $recommend, 'contact' => $contact, 'leaf' => $leaf, 'level' => 1);
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

					$node = array('username' => $username, /*'phone' => $phone,*/ 'recommend' => 'root','contact' => 'root', 'leaf' => $leaf, 'level' => 1);
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
		$old_username = $this->input->post('old_username');
		$password = $this->input->post('password');
		$username = $this->input->post('username');
		$phone = $this->input->post('phone');		
		$wx = $this->input->post('wx');
		$alipay = $this->input->post('alipay');

		$username = trim($username);
		//更新会员，先检查有没权限，再查找当前位置的会员信息，然后赋值给新会员，在更新时，检查是否是新会员，如果是新会员要先注册账号,更新推荐人和接点人
		// has login
		$this->load->model('Member_Model');
		$member = $this->Member_Model->getMember($old_username);
		//var_dump($member);
		// 检查是不是当前会员的推荐人
		if ($this->isManager() || $member->recommend == $this->session->username) {
			// 检查会员是不是新会员
			$this->load->model('User_Model');
			$user = $this->User_Model->get($username);
			if (!isset($user)) {
				//没有注册过，注册
				$this->User_Model->register($username, $password, $phone, $wx, $alipay);
			}
			if ($this->Member_Model->updateMember($old_username, $username, $phone)) {
				$this->json_with_code_msg(200, '更新成功');
			} else {
				$this->json_with_code_msg(500, '更新失败');
			}
		} else {
			$this->json_with_code_msg(500, '会员更新失败，你不是这个会员的推荐人');				
		}
		
		/*
		if ($this->Member_Model->existsName($name)) {
			//var_dump($r);
			$this->json_with_code_msg('500', '会员已存在!');
		} else if ($this->Member_Model->existsPhone($phone)) {
			$this->json_with_code_msg('500', '电话已被注册');
		} else  {*/
			//var_dump($r);
			// $this->load->model('Member_Model');
			// $r = $this->Member_Model->updateMember($id, $name, $phone);
			// if (!empty($r)) {
			// 	$this->json_with_data(200, '更新会员成功', array('time' => $r));
			// } else {
			// 	$this->json_with_code_msg(500, '会员更新失败');
			// }
		// }	
	}

	/**
		所有团队结构，只有管理员有权限
	**/
	public function init() {
		//$this->load->helper('url');
		if (!$this->isManager()) {
			$this->json_with_code_msg(200, '你没有权限查看');
			return;
		}
		$this->load->helper('url');
		$level = $this->input->get('level');
		if (empty($level)) {
			$level = 3;
		}
		$this->load->model('Member_Model');
		$root = $this->Member_Model->getChildren('root');
		//var_dump($root);
		$r = $this->encode_children(current($root), 1, $level);
		$this->json_with_data(200, 'ok', $r);
	}

	public function getMemberTree() {
		$this->load->helper('url');
		$username = $this->input->get('username');
		$level = $this->input->get('level');
		if (empty($username)) {
			$this->json_with_code_msg(500, '参数不正确');
			return;
		}
		if (empty($level)) {
			$level = 3;
		} 
		$level = $level;
		if ($level > 8) {
			$level = 8;
		}
		// $password = $this->input-get('password');
		$this->load->model('Member_Model');
		$member = $this->Member_Model->getMember($username);
		if (!isset($member)) {
			$this->json_with_code_msg(500, '没有这个会员');
			return;
		}
		/*
		if ($level > $member->level) {
			$level = $member->level + 1;
		}
		*/
		// $level = $member->level;

		//var_dump($member->recommend);
		$root = $this->Member_Model->getChildren($member->recommend);
		//var_dump($root);
		foreach ($root as $row) {
			//var_dump($row);
			if ($row['username'] == $username) {
				$r = $this->encode_children($row, 1, $level);
				$this->json_with_data(200, 'ok', $r);
				break;
			}
		}
		
	}

	private function encode_children($node, $level, $totalLevel) {
		//var_dump($node);
		if ($node == null) {
			return array();
		}
		$children = $this->Member_Model->getChildren($node['username']);
		//var_dump($children);
		$arr = array('name' => $node['username'], 'leaf' => $node['leaf'], 'level' => $node['level']);
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
		if ($this->isManager()) {
			$count = $this->Member_Model->getMembersCount();
			//var_dump($count);
			$this->json_with_data('200', 'ok', $count);
		} else {
			$this->json_with_code_msg(500, '不是管理员');
		}
		
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
		// var_dump($contact);
		if ($contact != null) {
			$this->json_with_data(200, 'ok', $contact);
		} else {
			$this->json_with_code_msg(500, '没有符合条件的接点人，请联系管理员');
		}
	}
	/**
		查询第一个符合条件的接点人
	**/
	private function findFirstContact($username) {
		$this->load->model('Member_Model');
		return $this->Member_Model->findFirstContact($username);
	}

	public function checkPassword() {
		$level = $this->input->post('level');
		$password = $this->input->post('password');
		$arr = array('pwd1', 'pwd2', 'pwd3', 'pwd4', 'pwd5', 'pwd6', 'pwd7', 'pwd8');
		$this->load->model('Config_Model');
		// $t = $arr[$level];
		// var_dump($arr[$level - 1]);
		if ($this->Config_Model->checkPassword($arr[$level - 1], $password)) {
			$this->json_with_code_msg(200, '密码正确');
		} else {
			$this->json_with_code_msg(400, '密码错误');
		}
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