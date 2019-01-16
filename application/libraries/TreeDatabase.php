<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class TreeDatabase 
{
	
	private $tableName;
	private $db;

	public function __construct() {
		$CI =& get_instance(); // to access CI resources, use $CI instead of $this
		$this->db =& $CI->db;
	}

	public function init($tableName) {
		$this->tableName = $tableName; 
	}

	public function getChildren($line, $level) {
		$sql = 'select * from '.$this->tableName.' where line > '.$line.' and line < (select min(line) from '.$this->tableName.' where line > '.$line.' and level <= '.$level.')';
		return $this->db->query($sql)->result_array();
		//return $sql;
	}

	public function getChildrenCount($line, $level) {
		$sql = 'select count(*) from '.$this->tableName.' where line > '.$line.' and line < (select min(line) from '.$this->tableName.' where line > '.$line.' and level <= '.$level.')';
		return $this->db->query($sql)->num_rows();
		//return $sql;
	}

	public function getChildrenAndSelf($line, $level) {
		$sql = 'select * from '.$this->tableName.' where line >= '.$line.' and line < (select min(line) from '.$this->tableName.' where line > '.$line.' and level <= '.$level.')';
		return $this->db->query($sql)->result_array();
	}

	public function insertNode($recommend, $node) {
		/*
		$q = $this->db->get_where($this->tableName, array('line' => $line));
		if ($q->num_rows() == 0) {
			//没有这个id，看总表有多少行
			$q = $this->db->get_where($this->tableName, array('level>' => 0));
			if ($q->num_rows() == 0) {
				// 也没有数据
				// 插入
				$node['line'] = 1;
				$node["level"] = 1;
				return $this->db->insert($this->tableName, $node);
			} else {
				return false;
			}
			//插入
		} else {		
			$row = $q->row();
			//$this->db->insert($this->tableName, $node);
			$sql = 'update '.$this->tableName.' set line = line + 1 where line >= (select min(line) where recommend = "'.$row->name.'"")';
			$this->db->simple_query($sql);
			$node['line'] = $row->line + 1;
			$node['level'] = $row->level + 1;
			var_dump($sql);
			if ($this->db->insert($this->tableName, $node)) {
				return true;
			} else {
				//$this->db->simple_query('update '.$this->tableName.' set line = line - 1 where line >= '.$row->line + 1);
				return false;
			}
		}
		//$this->db->simple_query('update '.$this->$tableName.' set line = line + 1 where line >= '.$line);
		//$this->db->insert($this->tableName, $node);
		*/

		$sql = 'select line from '.$this->tableName.' where line > '.$recommend->line.' and line < (select min(line) from '.$this->tableName.' where line > '.$recommend->line.' and level <= '.$recommend->level.')';
		var_dump($sql);
		$q = $this->db->query($sql);
		var_dump($q->row());
	}

	
}

?>