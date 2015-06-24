<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct()
	{
		parent::__construct();
		$this->load->model('LightOpenID','OpenID');
		$this->load->database();
		$this->load->library('session'); 
		$this->OpenID->Load("altislifeservers.co.uk");
		$this->OpenID->identity = 'http://steamcommunity.com/openid';
		
	}
	public function index() {
		if(!$this->OpenID->mode) {	
			$this->OpenID->identity = "http://steamcommunity.com/openid";
			header("Location: {$this->OpenID->authUrl()}");
	

		}elseif($this->OpenID->mode == "cancel") {
			echo "canceled";
		}else {
			if(!($this->session->userdata('AltisLifeUser'))) {
			
			 $check1 = $this->OpenID->validate() ? $this->OpenID->identity : null;
			 $check1 = str_replace("http://steamcommunity.com/openid/id/", "", $check1);
		
			$this->session->set_userdata('AltisLifeUser',$check1);
			
			$this->session->set_userdata('LOGGED_IN',true);
			 if($this->session->userdata('AltisLifeUser') !== false) {

				$Steam64 = str_replace("http://steamcommunity.com/openid/id", "", $this->session->userdata('AltisLifeUser'));
				$profile = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=7616EC6D94FD3531B469121D1E4B3371&steamids={$Steam64}"; 
				$json_object= file_get_contents($profile);
				$json_decoded = json_decode($json_object);
				 foreach ($json_decoded->response->players as $player)
                {
					
					$checkQ = $this->db->get_where('users',array('SteamID'=>$player->steamid));
					if($checkQ->num_rows()==0) {
						$data = array(
						   'steamID' => $player->steamid,
						   'name' => $player->personaname 
						);
						$this->db->insert('users', $data); 
					}
					$this->session->set_userdata('AltisLifeUserName',htmlspecialchars($player->personaname));
				}
				header("Location: ../");
			  }
			  header("Location: ../");
		 }

		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */