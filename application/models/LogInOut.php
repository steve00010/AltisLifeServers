<?php
class LogInOut extends CI_Model
{
	function __construct()
    {
       
    }
	function GetButton($logout) {
		if(!$this->session->userdata('AltisLifeUser') && $logout) {
			header("Location: ../");
		}
		if(!$this->session->userdata('AltisLifeUser') && !$logout) {
			return '<a href="'.base_url().'login"><img src="'.base_url().'assets/img/login.png"></img></a>';
		}
		else {
			return '<a class="btn btn-primary" href="'.base_url().'profile/">'.$this->session->userdata('AltisLifeUserName').'</a> <a class="btn btn-danger" href="welcome/logout">Logout</a>';
		}
	}
}
?>