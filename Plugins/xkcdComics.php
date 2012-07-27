<?PHP
class xkcdComics implements botPlugin
{ 

	public $commands = "xkcd";
	
	public function onLoad() {
	}
	
	public function GetURL($URL) {
		$ch = curl_init($URL);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		return $code;
	}
	
	function xkcd($sender, $command, $data, $config){
		$data[0]->sendMessage($sender[0], $sender[1].", ".$this->GetURL("http://dynamic.xkcd.com/random/comic/"));
	}
}
?>
