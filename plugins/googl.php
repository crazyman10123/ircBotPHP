<?PHP
class googl implements iPlugin {	
	public function onLoad() {
		define('GOOGLE_API_KEY', 'AIzaSyCw74og5BsE67_Nx9x-pji9GdUSHYOBYM0');
		define('GOOGLE_ENDPOINT', 'https://www.googleapis.com/urlshortener/v1');
	}
	
	public function shortenUrl($longUrl) {
		// initialize the cURL connection
		$ch = curl_init(
			sprintf('%s/url?key=%s', GOOGLE_ENDPOINT, GOOGLE_API_KEY)
		);
		
		// tell cURL to return the data rather than outputting it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// create the data to be encoded into JSON
		$requestData = array(
			'longUrl' => $longUrl
		);
		
		// change the request type to POST
		curl_setopt($ch, CURLOPT_POST, true);
		
		// set the form content type for JSON data
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		
		// set the post body to encoded JSON data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
		
		// perform the request
		$result = curl_exec($ch);
		curl_close($ch);
		
		// decode and return the JSON response
		return json_decode($result, true);
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		if ($exploded_message[0] == $config->prefix."shorten") {
			array_shift($exploded_message);
			$parameters = implode(" ", $exploded_message);
			if (empty($parameters)) {
				$connection->sendMessage($sender, "I can't just shorten nothing!");
			} else {
				$short = $this->shortenUrl($parameters);
				$connection->sendMessage($sender, $short['id']);
			}
		}
	}
}
?>