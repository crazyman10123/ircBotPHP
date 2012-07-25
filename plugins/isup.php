<?PHP
class isup implements iPlugin
{ 
	
	public function onLoad() {
	}
	
	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		if($exploded_message[0] == $config->prefix."isup") {
			array_shift($exploded_message);
			$parameters = $exploded_message[0];
			if ($this->isDomainAvailible($parameters)) {
				$connection->sendMessage($sender, $parameters." is up and running!");
			} else {
				$connection->sendMessage($sender, $parameters." is currently down. Sorry.");
			}
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
	curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
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
