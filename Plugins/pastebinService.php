<?PHP
class pastebinService implements botPlugin
{
        public $commands = "pastebin";
        public $url = "http://pastebin.com/";
 
        public function onLoad() {
        }
 
        public function pastebin($sender, $command, $data, $config) {
                $data[0]->sendMessage($sender[0], "Please don't paste lots of code in this channel, instead use ".$this->url);
        }
}
?>