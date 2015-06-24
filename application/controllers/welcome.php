<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->model('ServerQuery','ServerQuery');
		$this->load->model('LogInOut','LogIn');
		$this->load->library('session'); 
		$this->load->database();
		$this->load->helper('url');	
	}
	public function index($offset =NULL)
	{
	

		$data['loginout'] = $this->LogIn->GetButton(false);
		$offset1 = 0;
		if($offset == NULL) { $offest1 =0; }
		else { $offset1 = $offset*10; };
		
		$LoadS = $this->db->order_by("votes", "desc"); 
		$LoadS = $this->db->get_where('servers',array('verified'=>1,'blacklisted'=>0),10,$offset1);
		
		$i=0;
		if ($LoadS->num_rows() > 0) {
			foreach ($LoadS->result_array() as $row)
			{	
				$sid = $row['sid']; 
				if((time() - $row['lastcheck']) > 3600) {
					$json = file_get_contents('https://api.gamerlabs.net/?type=arma3&host='.$row['ip'].'&port='.$row['port']);
					$res = json_decode($json, TRUE);
					$json1 = file_get_contents('https://freegeoip.net/json/'.$row['ip']);
					$res1 = json_decode($json1, TRUE);
					if($res != "UDP Watchdog Timeout") {
						$data['servers'][$i]['rank'] = ($i+1);
						$data['servers'][$i]['name'] = $res['data']['name'];
						$data['servers'][$i]['players'] = $res['data']['raw']['numplayers'].'/'.$res['data']['maxplayers'];
						$data['servers'][$i]['votes'] = $row['votes'];
						$data['servers'][$i]['Online'] = '<span class="online">ONLINE</span>';
						$data['servers'][$i]['country'] = $res1["country_name"];
						$data['servers'][$i]['gamemode'] = $res['data']['raw']['game'];
						$data['servers'][$i]['sid'] = $sid;
						
						
						$ip = $row['ip'];
						$name = $res['data']['name'];
						$numplay = $res['data']['raw']['numplayers'];
						$maxplay = $res['data']['maxplayers'];
						$missionname= $res['data']['raw']['game'];
						$time = time();
						$country=$res1["country_name"];
						//$InsertQ = $this->db->query("Update servers set lastcheck='$time',name='$name',players='$numplay',maxplayers='$maxplay',online='ONLINE',missionname='$missionname',country='$country' WHERE sid='$sid';");
						$data1 = array(
						   'lastcheck' => $time,
						   'name' => $name,
						   'players' => $numplay,
						   'maxplayers' => $maxplay,
						   'online' => 'ONLINE',
						   'missionname'=>$missionname,
						   'country'=>$country
						);

						$this->db->where('sid', $sid);
						$this->db->update('servers', $data1); 
					} else {
						$data['servers'][$i]['rank'] = ($i+1);
						$data['servers'][$i]['name'] = $row['ip'].':'.$row['port'];
						$data['servers'][$i]['players'] =0;
						$data['servers'][$i]['votes'] = $row['votes'];
						$data['servers'][$i]['Online'] = '<span class="offline">OFFLINE</span>';
						$data['servers'][$i]['country'] = $row['country'];
						$data['servers'][$i]['gamemode'] = $row['missionname'];
						$data['servers'][$i]['sid'] = $sid;
						$data1 = array(
						   'lastcheck' => time(),
						   'players' => 0,
						   'online' => 'OFFLINE',
						);

						$this->db->where('sid', $sid);
						$this->db->update('servers', $data1); 
					}
					
				} else {
						$data['servers'][$i]['rank'] = ($i+1);
						$data['servers'][$i]['name'] = $row['name'];
						$data['servers'][$i]['players'] = $row['players'].'/'.$row['maxplayers'];
						$data['servers'][$i]['votes'] = $row['votes'];
						$data['servers'][$i]['Online'] = '<span class="'.strtolower($row['Online']).'">'.$row['Online'].'</span>';
						$data['servers'][$i]['country'] = $row['country'];
						$data['servers'][$i]['gamemode'] = $row['missionname'];
						$data['servers'][$i]['sid'] = $sid;	
				}
				$i++;
			}
			$data['totalrows'] = $LoadS->num_rows();
			$data['offset'] = $offset;
			$data['title'] = "Home - Altis Life Servers";
			$this->load->view('welcome_message',$data);
			$this->load->view('index',$data);
			$this->load->view('footer');
		} else {
			header("Location: ".base_url());
		}

	}


	
	public function about() {
		$data['loginout'] = $this->LogIn->GetButton(false);
		$data['title'] = "About us - Altis Life Servers";
		$this->load->view('welcome_message',$data);
		$this->load->view('about',$data);
		$this->load->view('footer');
	}
	public function logout() {
		session_start();
		$this->session->unset_userdata('AltisLifeUserName');
		$this->session->unset_userdata('AltisLifeUser');
		header("Location: ".base_url());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */