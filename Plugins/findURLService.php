<?PHP
class findURLService implements botPlugin
{
	public $commands = "";
	
	public function onLoad() {
	}
	
	public function getTitle($Url){
		$str = file_get_contents($Url);
		if(strlen($str)>0){
			preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
			return $title[1];
		}
	}
	
	public function onSpeak($sender, $command, $data, $config) {
		if(!strstr(strtolower($command[2]), strtolower($config->prefix."shorten"))) {
			$exploded = explode(" ", $command[2]);
			foreach($exploded as &$url) {
				if(filter_var($url, FILTER_VALIDATE_URL) && filter_var("http://".$url, FILTER_VALIDATE_URL)) {
					$data[0]->sendMessage($sender[0], $this->getTitle($url));
				}
			}
		}
	}
}
?>