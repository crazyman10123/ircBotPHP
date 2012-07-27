<?PHP
class guessGame implements botPlugin
{
	public $commands = "guess";

	public function onLoad() {
	}

	public function guess($sender, $command, $data, $config) {
		$num = rand(1, 10);
		if (is_numeric($command[1])) {
			if($command[1] > 10 || $command[1] <= 0) {
				$data[0]->sendMessage($sender[0], $sender[1].", guess a number between 1 and 10!");
			}
			if($command[1] == $num) {
				$data[0]->sendMessage($sender[0], $sender[1].", you win!");
			}
			if($command[1] != $num && $command[1] < 10) {
				$data[0]->sendMessage($sender[0], $sender[1].", nope, try again!");
			}
		} else {
			$data[0]->sendMessage($sender[0], $sender[1].", last time I checked, that wasn't a number...");
		}
	}
	
}
?>