<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class table_model extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->model("databaseWraper");
		}

		public function getTableDetails($data){
			// $data = json_decode($data1);
			$table_size = $data['table_size'];
			$no_of_cards_per_hand = $data['no_of_cards_per_hand'];
			$no_of_decks = $data['no_of_decks'];

			$user_id = $data['player_name'];


			$tables = $this->databaseWraper->selectWhere('table_details', array('table_size'=>$table_size,'no_of_cards_per_hand'=>$no_of_cards_per_hand,'no_of_decks'=>$no_of_decks));
			
			$ret_data = $this->getData($tables, "table");
			$user_session = $this->doLogin($user_id);

			if(sizeof($ret_data) == 0)
			{
				//Create new record with user detail
				$bool_insert = $this->databaseWraper->insertInto("table_details", array('table_id' => 104 , "table_size"=> $table_size, "no_of_cards_per_hand"=> $no_of_cards_per_hand, "no_of_decks"=> $no_of_decks, "players" => $user_id, "table_status"=>0));
			

				if ($bool_insert == 0) {
					$get_table_obj = $this->databaseWraper->selectWhere('table_details', array('table_id' =>  104));

					$get_table = get_object_vars($get_table_obj[0]);

					$return_data['status'] = 1;
					$return_data['message'] = "success";
					$return_data['data'] = $get_table;

					$return_data['data']['players'] = $this->getUserDetails($get_table["players"]);
					
				}

				else
				{
					$return_data['status'] = 0;
					$return_data['message'] = "Something went wrong";
					$return_data['data'] = "";
				}
			}

			else
			{
				//Update first record with user detail
				//get_object_vars using to handle stdClass Object type
				$first_rec = get_object_vars($ret_data[0]);

				$first_rec['players'] = $first_rec['players'].":".$user_id; 

				$bool_update = $this->databaseWraper->updateTable("table_details", array('table_id' =>  $first_rec['table_id']),array('players' =>  $first_rec['players']));
			
				if($bool_update == 1)
				{
					$get_table_obj = $this->databaseWraper->selectWhere('table_details', array('table_id' =>  $first_rec['table_id']));
					
					$get_table = get_object_vars($get_table_obj[0]);

					
					$return_data['status'] = 1;
					$return_data['message'] = "success";
					$return_data['data'] = $get_table;

					$return_data['data']['players'] = $this->getUserDetails($get_table["players"]);

					
				}

				else
				{
					$return_data['status'] = 0;
					$return_data['message'] = "Something went wrong";
					$return_data['data'] = "";
				}
			}

			return $return_data;
		}


		public function getUserDetails($players){
			$player_arr = explode(":", $players);
			$player_det_arr = array();

			foreach ($player_arr as $player) {
				
				$player_det = $this->databaseWraper->selectWhere('player_details',array('player_name' => $player ));
				array_push($player_det_arr, $player_det);
			}

			return $player_det_arr;
		}


		public function doLogin($user_id){
			$_SESSION['user_id'] = $user_id;
			return $_SESSION;
		}


		public function getWaitToStartDetails(){

			$table_id = 100;
			$WaitToStartDetails = $this->databaseWraper->selectWhere('table_details',array('table_id'=>$table_id));

			$wait_to_start_details = get_object_vars($WaitToStartDetails[0]) ;
			

			$status = $wait_to_start_details['table_status'];
			
			$players = $wait_to_start_details['players'];

			$players_arr = explode(":", $players);

			if ($status == 0 && sizeof($players_arr) == $wait_to_start_details['table_size']) {
				$bool_update = $this->databaseWraper->updateTable("table_details", array('table_id' =>  $table_id),array('table_status' =>  1));
				$status = 1;
				$this->startGame($wait_to_start_details);
			}

			$ret_obj['table_status'] = $status;
			$ret_obj['players'] = $this->getUserDetails($players);

			return $ret_obj ;
			
			// return "";
		}


		public function startGame($table_details){
			$table_details['table_status'] = 1;

			$deck_count = $table_details['no_of_decks'];
			$deck = $this->constructDeck($deck_count);

			$ret_deck = $this->distributeCards($table_details,$deck);

			$remaining_deck = $ret_deck['remaining_deck'];
			$players_hands = $ret_deck['players_hands'];


			$poll_table_details = array();

			$poll_table_details['table_id'] = $table_details['table_id'];
			$poll_table_details['game_round_no'] = 1;
			$poll_table_details['round_no'] = 1;
			$poll_table_details['current_hands'] = $this->convertPlayerHandsToString($players_hands);
			$poll_table_details['current_hand_owner'] = reset(array_keys($players_hands));
			$poll_table_details['current_open_card'] = array_pop($remaining_deck);
			$poll_table_details['player_scores'] = implode(",", array_fill(0, $table_details['table_size'], 0));
			$poll_table_details['last_drops'] = "";
			$poll_table_details['show_caller_id'] = "";
			$poll_table_details['timestamp'] = time();


			$this->databaseWraper->insertInto("poll_table_details", $poll_table_details);


			$game_track_details = array();

			$game_track_details['table_id'] = $table_details['table_id'];
			$game_track_details['game_round_no'] = 1;
			$game_track_details['round_no'] = 1;
			$game_track_details['current_hands'] = $this->convertPlayerHandsToString($players_hands);
			$game_track_details['current_hand_owner'] = reset(array_keys($players_hands));
			$game_track_details['current_open_card'] = array_pop($remaining_deck);
			$game_track_details['player_scores'] = implode(",", array_fill(0, $table_details['table_size'], 0));
			$game_track_details['last_drops'] = "";
			$game_track_details['show_caller_id'] = "";
			$game_track_details['timestamp'] = time();
			$game_track_details['game_round_status'] = 0;
			$game_track_details['round_status'] = 0;
			$game_track_details['player_name'] = "";

			$this->databaseWraper->insertInto("game_track_details", $game_track_details);



			$remaining_deck_str = implode(",", $remaining_deck);

			$this->databaseWraper->insertInto('remaining_deck_details', array('table_id' => $table_details["table_id"], 'remaining_deck' => $remaining_deck_str));
			

		}

		public function constructDeck($deck_count){
			$max_num = $deck_count * 52;
			$deck_arr = range(1, $max_num);
			shuffle($deck_arr);

			return $deck_arr;
		}

		public function distributeCards($table_details,$deck){
			$players_arr = explode(":", $table_details['players']);
			$players_hands =  array();
			$ret_arr = array();


			foreach ($players_arr as $player) {
				$players_hands[$player] = [];
			}

			$table_size = $table_details['table_size'];
			$no_of_cards_per_hand = $table_details['no_of_cards_per_hand'];


			for ($i=0; $i < $no_of_cards_per_hand; $i++) { 

				foreach ($players_hands as $key => $value) {
					array_push($players_hands[$key], array_pop($deck));
				}

			
			}

			$ret_arr['remaining_deck'] = $deck;
			$ret_arr['players_hands'] = $players_hands;

			return $ret_arr;

		}

		public function convertPlayerHandsToString($players_hands){
			$hands_string = "";
			foreach ($players_hands as $key => $value) {
				$hands_string = $hands_string.implode(",", $value);
				$hands_string = $hands_string.":";
			}
			return rtrim($hands_string, ":");
		}

		public function getPlayerDetails(){
			$player_details = $this->databaseWraper->selectWhere('player_details');

			return $this->getData($player_details, "player_details");

		}

		public function getPollTableDetails(){

		}

		public function getData($data, $key){
			$res = array();
			foreach($data as $row){
				
				
				array_push($res, $row);
			}

			return $res;

		}

	}


?>