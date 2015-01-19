<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->model("databaseWraper");
		$this->load->model("table_model");
		
	}

	public function getTableDetails(){
		session_start();
		$data = array(
			'table_size' => $this->input->post('table_size'),
			'no_of_cards_per_hand' =>  $this->input->post('no_of_cards_per_hand'),
			'no_of_decks' => $this->input->post('no_of_decks'),
			'player_name' => $this->input->post('player_name')
			);


		$res = $this->table_model->getTableDetails($data);

		
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	
		// echo json_encode($data);

		echo json_encode($res);
	}

	public function getWaitToStartDetails(){
		$res = $this->table_model->getWaitToStartDetails();
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function getPollTableDetails(){
		$res = $this->table_model->getPollTableDetails();
		header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function getPlayerDetails(){
		$res = $this->table_model->getPlayerDetails();
		
		header('Content-Type: application/json');
		echo json_encode($res);
	}
}


?>