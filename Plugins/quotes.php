<?PHP
class quotes implements botPlugin
{

	public $commands = "quote";
	public $quotes = null;

	public function onLoad() {
		if (!file_exists("quotes.txt")) {
			die("quotes.txt not found!\n");
		}
		$quotes = file_get_contents("quotes.txt");
		$this->quotes = explode("\n", $quotes);
	}
	
	public function quote($sender, $command, $data, $config) {
		$random = rand(100,1000);
		$i = 0;
		while ($i <= $random) {
			shuffle($this->quotes);
			$i++;
		}
		$quote_key = array_rand($this->quotes);
		$data[0]->sendMessage($sender[0], $this->quotes[$quote_key]);
	}
}
?>
