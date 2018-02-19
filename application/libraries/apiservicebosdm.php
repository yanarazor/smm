<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Apiservicebosdm
{
		//var $user="196308031984121001";
		//var $secretkey="elbaite921";
		var $urlgetdatapegawai ="https://api.lipi.go.id/index.php/hris/pegawai/list";
		//var $token = "0c4d00336d84eea83950c2e760c06118";
		
		var $CI;
	function Apiservicesas()
	{
		$this->CI =& get_instance();   
	}
 
 	private function searchdatasdm($parameters,$user,$password,$token)
	{
		
		return $this->eventsearch($parameters,$this->urlgetdatapegawai,$user,$password,$token);
	}
	 
	function  eventsearch($params,$url,$user,$password,$token)
	{	 
		$ci =& get_instance();

		$ci->load->library('emulator');
		$emulator = new emu();
		$cookie = "";
		$host = $url;
		$canonicalized_query = array();
	 
		foreach ($params as $param=>$value)
		{
			$param = str_replace("%7E", "~", rawurlencode($param));
			$value = str_replace("%7E", "~", rawurlencode($value));
			$canonicalized_query[] = $param."=".$value;
		}
		$canonicalized_query = implode("&", $canonicalized_query);
		$string_to_sign = $host."\n".$canonicalized_query;
		$request = $host."?".$canonicalized_query;
		
		$response = $emulator->getUrl($request, $user, $user,$password);
		//print_r($response);
		//die($request);
		/* If cURL doesn't work for you, then use the 'file_get_contents'
		   function as given below.
		*/
		if ($response[0] === False)
		{
			return False;
		}
		else
		{
			return $response[0];
		}
	}
	public function getdatapegawai($start,$limit,$user,$password,$token)
	{
		$parameters = array("Username"=> $user,
						"password"=> $password,
							"X-API-KEY"=> $token,
							"start"=> $start,
							"limit"=> $limit);
		$json_response = $this->searchdatasdm($parameters,$user,$password,$token);
		return $json_response;
	}
	 
}
?>