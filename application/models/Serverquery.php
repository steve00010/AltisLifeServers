<?php
class ServerQuery extends CI_Model
{
	function __construct()
    {
       
    }
	function QueryServer($addr,$port) {
		$maxwait = 10;
		$sock = fsockopen(("udp://" . $addr),$port,$errno,$errdesc,$maxwait);
		$query = pack("c*",0xFE,0xFD,0x00,0x04,0x05,0x06,0x07,0xFF,0xFF,0xFF);
		
		fwrite($sock,$query);
		@socket_set_timeout($sock, 2);
		$reply = @fread($sock, 4096);
		echo $reply;
		  fclose($sock);
		
		if($reply != '')
		{
			$Infoarray = explode(chr(0), $reply);
			$querysuccess = true;
			$Name = $Infoarray[4];
			$Status = $Infoarray[16];
			$Numplayers = $Infoarray[10];
			$Gametype = $Infoarray[8];
			$Mission = $Infoarray[44];
			return array($Name,$status,$Numplayers,$Gametype,$Mission);
		} else {
			return false;
		}

	}
}
?>