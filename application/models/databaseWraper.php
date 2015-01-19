<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class DatabaseWraper extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		/*
			$param is an array of key value pairs, the key is the column name
			of the where condition and value is the data for selection

			$limit is a optional argument only provided when you want a limit on number of records to be fetched.
		*/
		public function selectWhere($tableName,$param='',$limit=''){
			$this->db->select("*");
			$this->db->from($tableName);
			if($param!='') $this->db->where($param);

			if($limit!='') $this->db->limit($limit);

			$query = $this->db->get();

			if($query->num_rows() >0 ){
				return $query->result();
			}
			else{
				return array();
			}
		}

		public function joiningSelect($tableName,$resultTableName,$joinCondition,$where=''){

			$this->db->select("*");
			$this->db->from($tableName);
			if($where != '') $this->db->where($where);
			$this->db->join($resultTableName,$joinCondition);

			$query = $this->db->get();

			if($query->num_rows() >0) return $query->result();
			else return array();

		}
		/*
			$param is a array of key value pairs
			the key is the column name and the value is the data to be inserted
		*/

		public function insertInto($tableName,$param){
			$this->db->trans_start();

			$this->db->insert($tableName,$param);
			$id = $this->db->insert_id();

			$this->db->trans_complete();

			$status = $this->db->trans_status() ? $id : -1;

			return $status;

		}
		/*
				$data is an array of array's each individual array has a key value pair
				the key is the column name and value is the data to be inserted
		*/
		public function insertIntoMulti($tableName,$data){
			$this->db->trans_start();

			$this->db->insert_batch($tableName,$data);

			$this->db->trans_complete();

			return $this->db->trans_status();			
		}

		/*
			$where is an array of key value pairs which helps in selecting the rows on which the update happens
			$updateContent is an array of key value pairs which indicate which columns are being updated and with what value
		*/
		public function updateTable($tableName,$where,$updateContent){

            $this->db->trans_start();


            $this->db->where($where);
            $this->db->update($tableName,$updateContent);


            $this->db->trans_complete();

            return $this->db->trans_status();
        }

		/*
			Another convineance method instead of updateTable
			$where is an array of key value pairs which helps in selecting the rows on which the update happens
			$columnName is the name of the column being updated
			$value is the new value being set for the $columnName
		*/

		public function setColumn($tableName,$where,$columnName,$value){

			$this->db->trans_start();

			$this->db->from($tableName);
			$this->db->where($where);
			$this->db->set($columnName,$value);
			$this->db->update();

			$this->db->trans_complete();

			return $this->db->trans_status();
		}

		/*
			delete rows from the table $tableName
			$where is an array of key value pairs which helps in selecting the rows that need to be deleted
		*/
		public function deleteRows($tableName,$where){

			$this->db->trans_start();

			$this->db->where($where);
			$this->db->delete($tableName);

			$this->db->trans_complete();

			return $this->db->trans_status();

		}
	}
?>