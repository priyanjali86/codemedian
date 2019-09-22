<?php

if(!defined('BASEPATH'))

	exit('No direct script access allowed');

class Basic_model extends CI_Model

{

	public function __construct()

	{

		// Call the Model constructor

		parent::__construct();

	}

	public function insertIntoTable($tableName, $insertArr){

		$ret = false;

		if($tableName == '')

			return $ret;

		if($insertArr && is_array($insertArr)) {

			$this->db->insert($tableName, $insertArr);

			$ret = $this->db->insert_id();

		}

		return $ret;

	}

	public function recordInsert($tableName, $data = array()){

		$fields = "";

		if(is_array($data) && count($data) > 0) {

			foreach($data as $k => $v) {

				$fields .= $k . ' = "' . $v . '", ';

			}

			$fields = substr($fields, 0, strlen($fields) - 2);

		}

		$sql = "INSERT INTO " . $tableName . " SET " . $fields;

		$rs  = $this->db->query($sql);

		$rec = false;

		if($this->db->insert_id()) {

			$rec = $this->db->insert_id();

		}

		return $rec;

	}

	public function recordUpdate($tableName, $data = array(), $condition){

		$fields = "";

		if(is_array($data) && count($data) > 0) {

			foreach($data as $k => $v) {

				$fields .= $k . ' = "' . $v . '", ';

			}

			$fields = substr($fields, 0, strlen($fields) - 2);

		}

		$sql = "UPDATE " . $tableName . " SET " . $fields . " WHERE " . $condition;

		$rec = false;

		if($this->db->query($sql)) {

			$rec = true;

		}

		return $rec;

	}

	public function getValues_conditions($TableName, $FieldNames, $AliasFieldName = '', $Condition = '', $OrderBy = '', $OrderType = '', $Limit = 0){

		if($Condition == "")

			$Condition = "";

		else

			$Condition = " WHERE " . $Condition;

		$select = '*';

		if($FieldNames && is_array($FieldNames))

			$select = implode(",", $FieldNames);

		$sql = "SELECT " . $select . " FROM " . $TableName . $Condition;

		if($OrderBy != '') {

			$sql .= " ORDER BY `" . $OrderBy . "` " . $OrderType;

		}

		if($Limit) {

			$sql .= " LIMIT  $Limit";

		}

		//echo '<br>'.$sql;//exit;

		$rec = FALSE;

		$rs  = $this->db->query($sql);

		if($rs->num_rows()) {

			$rec = $rs->result_array();

		} else {

			$rec = FALSE;

		}

		return $rec;

	}

	public function isRecordExist($tableName = '', $condition = '', $idField = '', $idValue = ''){

		if($condition == '')

			$condition = 1;

		$sql = "SELECT COUNT(*) as CNT FROM " . $tableName . " WHERE " . $condition . "";

		if($idValue > 0 && $idValue <> '') {

			$sql .= " AND " . $idField . " <> '" . $idValue . "'";

		}

		$rs  = $this->db->query($sql);

		$rec = $rs->row();

		$cnt = $rec->CNT;

		return $cnt;

	}



}