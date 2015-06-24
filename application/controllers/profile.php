<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		$this->load->model('LogInOut','LogIn');
		$this->load->library('session'); 	
		$this->load->helper('url');		
	}
	public function index() {
		$data['loginout'] = $this->LogIn->GetButton(true);
		$owner = $this->session->userdata('AltisLifeUser');
		$LoadS = $this->db->order_by("votes", "desc"); 
		$LoadS = $this->db->get_where('servers',array('owner'=>$owner));

		//$LoadS = $this->db->query("SELECT * FROM Servers WHERE owner='$owner' ORDER BY VOTES DESC ");
		$i=0;
		if ($LoadS->num_rows() > 0) {
			foreach ($LoadS->result_array() as $row)
			{	
				if((time() - $row['lastcheck']) > 3600) {
					$json = file_get_contents('https://api.gamerlabs.net/?type=arma3&host='.$row['ip'].'&port='.$row['port']);
					$res = json_decode($json, TRUE);
					$json1 = file_get_contents('https://freegeoip.net/json/'.$row['ip']);
					$res1 = json_decode($json1, TRUE);
					if($res != "UDP Watchdog Timeout") {
						$data['servers'][$i] = array(($i + 1),$res['data']['name'],$res['data']['raw']['numplayers'].'/'.$res['data']['maxplayers'],$row['votes'],'<span class="online">ONLINE</span>',$res1["country_name"],$res['data']['raw']['game'],$row['sid'],$row['Verified'],$row['ip'],$row['port']);
						$ip = $row['ip'];
						$name = $res['data']['name'];
						$numplay = $res['data']['raw']['numplayers'];
						$maxplay = $res['data']['maxplayers'];
						$missionname= $res['data']['raw']['game'];
						$time = time();
						$country=$res1["country_name"];
						$InsertQ = $this->db->query("Update servers set lastcheck='$time',name='$name',players='$numplay',maxplayers='$maxplay',online='ONLINE',missionname='$missionname',country='$country' WHERE ip='$ip';");

					} else {
						$data['servers'][$i] = array(($i + 1),$row['ip'].':'.$row['port'],0,$row['votes'],'<span class="offline">OFFLINE</span>',$row['country'],$row['missionname'],$row['sid'],$row['Verified'],$row['ip'],$row['port']);
					}
					
				} else {
						$data['servers'][$i] = array(($i + 1),$row['name'],$row['players'].'/'.$row['maxplayers'],$row['votes'],'<span class="'.strtolower($row['Online']).'">'.$row['Online'].'</span>',$row["country"],$row['missionname'],$row['sid'],$row['Verified'],$row['ip'],$row['port']);
				}
				$i++;
			}
		} else {
			$data['servers'] = array(FALSE,'No servers added');
		}
		$data['title'] = "Profile - AltisLifeServers";
		$this->load->view('welcome_message',$data);
		$this->load->view('profile',$data);
		$this->load->view('footer',$data);
	}
	public function register() {
		$data['loginout'] = $this->LogIn->GetButton(false);
		
		if(isset($_GET['ip']) && isset($_GET['port'])) {
			if (!filter_var($_GET['ip'], FILTER_VALIDATE_IP) === false) {
				
				$ip =  $_GET['ip'];
				$port = $_GET['port'];
				$CheckQ = $this->db->query("Select * from Servers where IP='$ip' AND port='$port'");
				if ($CheckQ->num_rows() == 0) {
					$data['server']['taken'] = FALSE;

					header("Location: ".base_url()."profile/verify?ip=".$ip."&port=".$port);
				} else {
					$data['server']['taken'] = TRUE;
				}
			} else {
				header("Location: ".base_url()."profile/register");			
			}
		}
		$data['title'] = "Register a new server - AltisLifeServers";
		$this->load->view('welcome_message',$data);
		$this->load->view('newserver',$data);
		$this->load->view('footer');
	}
	public function verify() {
		$data['loginout'] = $this->LogIn->GetButton(true);
		if(isset($_GET['ip']) && isset($_GET['port'])) {
			$user = $this->session->userdata('AltisLifeUser');
			$ip =  $_GET['ip'];
			$port = $_GET['port'];
			$json = file_get_contents('https://api.gamerlabs.net/?type=arma3&host='.$ip.'&port='.$port);
			$res = json_decode($json, TRUE);
			if($res != "UDP Watchdog Timeout") {


				$CheckQ = $this->db->query("Select * from Servers where IP='$ip' AND port='$port'");
				if ($CheckQ->num_rows() == 1) {
					foreach ($CheckQ->result_array() as $row)
					{
						if($row['Verified'] == FALSE) {


							$data['server']['ip'] = $ip;
							$data['server']['port'] = $port;
							$data['server']['randomname'] = $row['VerifyName'];
							$data['server']['valid'] = true;	
							$data['server']['name'] = $res['data']['name'];
							if($data['server']['name'] == $data['server']['randomname']) {
								$data['server']['verified'] = true;
								$InsertQ = $this->db->query("Update servers set verified=true where ip='$ip' and port='$port';");
							} else {
								$data['server']['verified'] = false;
							}
						} else {
						header("Location: ../");
					}
					} 
				} else {
							$data['server']['verified'] = false;
							$randomname = "AltisLifeServers.co.uk-".rand(100000,999999);
							$data['server']['ip'] = $ip;
							$data['server']['port'] = $port;
							$data['server']['randomname'] = $randomname;
							$data['server']['valid'] = true;	
							$data['server']['name'] = $res['data']['name'];
					$InsertQ = $this->db->query("Insert into Servers (ip,port,owner,verifyname,verified) values ('$ip','$port','$user','$randomname',FALSE)");
				}
			}else {
				$data['server']['valid'] = false;			
			}
			$data['title'] = "Verify your Server - AltisLifeServers";
			$this->load->view('welcome_message',$data);
			$this->load->view('verifyserver',$data);
			$this->load->view('footer');
		} else {
			header("Location: ../");
		}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */