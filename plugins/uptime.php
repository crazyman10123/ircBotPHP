<?PHP
class uptime implements iPlugin
{
	public $begintime;
	
	public function onLoad() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$this->begintime = $time;
	}

	public function secondsToTime($seconds) {
		// extract hours
		$hours = floor($seconds / (60 * 60));
		
		// extract minutes
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
		
		// extract the remaining seconds
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
		
		// return the final array
		$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
		);
		return $obj;
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		if ($message == $config->prefix."uptime") {	
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$endtime = $time;
			$totaltime = ($endtime - $this->begintime);
			$time = $this->secondsToTime($totaltime);
			$connection->sendMessage($sender, "I have been up for ".$time['h']." hours, ".$time['m']." minutes and ".$time['s']." seconds!");
		}
	}

}
?>
