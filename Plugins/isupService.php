<?PHP
class isupService implements botPlugin
{ 

	public $commands = "isup";
	
	public function onLoad() {
	}
	
	public function isup($sender, $command, $data, $config) {
		if ($this->isDomainAvailible($command[1])) {
			$data[0]->sendMessage($sender[0], $sender[1].", ".$command[1]." is up and running!");
		} else {
			$data[0]->sendMessage($sender[0], $sender[1].", ".$command[1]." is currently down. Sorry!");
		}
	}
	
	//returns true, if domain is availible, false if not
	public function isDomainAvailible($domain)
	{
	//check, if a valid url is provided
	if(!filter_var($domain, FILTER_VALIDATE_URL) && !filter_var("http://".$domain, FILTER_VALIDATE_URL))
	{
		return false;
	}
	
	//initialize curl
	$curlInit = curl_init($domain);
	curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,5);
	curl_setopt($curlInit,CURLOPT_HEADER,true);
	curl_setopt($curlInit,CURLOPT_NOBODY,true);
	curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
	
	//get answer
	$response = curl_exec($curlInit);
	
	curl_close($curlInit);
	
	if ($response) return true;
	
	return false;
	}
}
?>
