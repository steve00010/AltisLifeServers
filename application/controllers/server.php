<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server extends CI_Controller {

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
		$this->load->database();
		$this->load->library('session'); 
		$this->load->helper('url');	
		$this->load->model('LogInOut','LogIn');		
	}
	public function index($server_id = NULL,$voted = NULL) {
		
		$data['loginout'] = $this->LogIn->GetButton(false);
		if($voted != NULL) { 
			if($voted == 1) {
				$data['voted'] = true;
			}else {
				$data['voted'] = false;
				$data['votetime'] = $voted;
				
			}
		}
		if(isset($server_id)) {
			$sid = $server_id;
			$LoadQ = $this->db->get_where('servers',array('sid'=>$server_id));
			if ($LoadQ->num_rows() == 1) {
				foreach ($LoadQ->result_array() as $row)
				{
					if((time() - $row['lastcheck']) > 3600) {
						$json = file_get_contents('https://api.gamerlabs.net/?type=arma3&host='.$row['ip'].'&port='.$row['port']);
						$res = json_decode($json, TRUE);
						if($res != "UDP Watchdog Timeout") {
							$name = $res['data']['name'];
							$players = $res['data']['raw']['numplayers'].'/'.$res['data']['maxplayers'];
							$votes = $row['votes'];
							$desc = $row['description'];
							$gamemode = $res['data']['raw']['game'];
							$data['info']['sid'] = $row['sid'];
							$data['info']['ip'] = $row['ip'];
							$data['info']['url'] = $row['url'];
							$data['info']['port'] = $row['port'];
							$data['info']['name'] = $name;
							$data['info']['players'] = $players;
							$data['info']['votes'] = $votes;
							$data['info']['desc'] = $desc;
							$data['info']['gamemode'] = $gamemode;
							$numplay = $res['data']['raw']['numplayers'];
							$maxplay = $res['data']['maxplayers'];
							$time = time();
							$array = array(
								'lastcheck'=>$time,
								'name'=>$name,
								'players'=>$numplay,
								'maxplayers'=>$maxplay,
								'online'=>'ONLINE',
								'missionname'=>$gamemode
							);
							$this->db->where('sid',$sid);
							$this->db->update('servers',$array);

						} else {
							$name = $row['name'];
							$players = $row['players'].'/'.$row['maxplayers'];
							$votes = $row['votes'];
							$desc = $row['description'];
							$gamemode = $row['missionname'];
							$data['info']['sid'] = $row['sid'];
							$data['info']['ip'] = $row['ip'];
							$data['info']['url'] = $row['url'];
							$data['info']['port'] = $row['port'];
							$data['info']['name'] = $name;
							$data['info']['players'] = $players;
							$data['info']['votes'] = $votes;
							$data['info']['desc'] = $desc;
							$data['info']['gamemode'] = $gamemode;
						}
					}else {
							$name = $row['name'];
							$players = $row['players'].'/'.$row['maxplayers'];
							$votes = $row['votes'];
							$desc = $row['description'];
							$gamemode = $row['missionname'];
							$data['info']['sid'] = $row['sid'];
							$data['info']['ip'] = $row['ip'];
							$data['info']['url'] = $row['url'];
							$data['info']['port'] = $row['port'];
							$data['info']['name'] = $name;
							$data['info']['players'] = $players;
							$data['info']['votes'] = $votes;
							$data['info']['desc'] = $desc;
							$data['info']['gamemode'] = $gamemode;
						}
				}
				$data['title'] = "Server info - AltisLifeServers";					
				$this->load->view('welcome_message',$data);
				$this->load->view('viewserver',$data);
				$this->load->view('footer');				
			}	else {
				header("Location: ../");
			}			
		}
		
	}
	public function vote($server_id = NULL, $vote = NULL) {
		$user = $this->session->userdata('AltisLifeUser');
		$LoadQ1 = $this->db->get_where('users',array('SteamId'=>$user),1,0);
		if ($LoadQ1->num_rows() == 1) {
			
			foreach ($LoadQ1->result_array() as $row)
			{
				if((time() - $row['lastvotetime']) > 86400) {
					$LoadQ = $this->db->get_where('servers',array('sid'=>$server_id),1,0);
					if ($LoadQ->num_rows() == 1) {
						foreach ($LoadQ->result_array() as $row1)
						{
							$votes = $row1['votes'];
							
						}
						$data = array(
						   'lastvotetime' => time()
						);
						$this->db->where('Steamid', $this->session->userdata('AltisLifeUser'));
						$this->db->update('users', $data); 
						if($vote == 0) {
							$data1 = array(
							   'votes' => $votes+1
							);
						} else if($vote == 1) { 
							$data1 = array(
							   'votes' => $votes-1
							);
						}
						$this->db->where('sid', $server_id);
						$this->db->update('servers', $data1); 
						header("Location: ".base_url().'server/index/'.$server_id.'/1');
						
					}
				} else {
					header("Location: ".base_url().'server/index/'.$server_id.'/'.$row['lastvotetime']);
				}
			}
		} else {
			header("Location: ../");
		}
		
		
	}
	public function edit($server_id = NULL) {
		$data['loginout'] = $this->LogIn->GetButton(true);
		$LoadQ = $this->db->get_where('servers',array('sid'=>$server_id),1,0);
		if ($LoadQ->num_rows() == 1) {
			foreach ($LoadQ->result_array() as $row)
			{
				$owner = $row['owner'];
				$name = $row['name'];
				$desc = $row['description'];
				$url = $row['url'];
			}
		}
		if($this->session->userdata('AltisLifeUser') != $owner) {
			header("Location: ".base_url());
		}
		if(!isset($_POST['url']) && !isset($_POST['desc'])) {
			$data['server']['name'] = $name;
			$data['server']['url'] = $url;
			$data['server']['desc'] = strip_tags($desc);
			$data['title'] = "Edit your server";
			$this->load->view('welcome_message',$data);
			$this->load->view('serveredit',$data);
			$this->load->view('footer');
		} else {
			$url = $this->input->post('url', TRUE);
			$desc = $this->input->post('desc', TRUE);
			$array = array(
				'url'=>$url,
				'description'=>nl2br(htmlspecialchars($desc))
				);
			$this->db->where('sid',$server_id);
			$this->db->update('servers',$array);
			header("Location: ".base_url()."server/index/".$server_id);
		}
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */