<?php

class Logging
{
	public $last_log, $last_time;
	protected $log_date, $username;
	private $log_file;

	public function __construct($username)
	{
		$this->username = $username;
		$this->log_date = date('d-m-y');
		$this->log_file = 'logs/' . $this->username . '_' . $this->log_date . '.log';

		$this->createLog($this->log_file);
		$this ->logAction('start logging');
	}
	
	public function logAction($content)
	{
		$this->last_log = $content;
		$this->last_time = time();
		file_put_contents($this->log_file, '[' . $this->last_time . '] - ' . $content . "\n", FILE_APPEND);
	}

	public function __wakeup() 
	{
		$this->createLog($this->log_file);
		$this->logAction('resuming log. previous entry: ' . $this->last_log);
	}

	protected function createLog($file)
	{
		if(!file_exists($file))
		{
			touch($file);
		}
	}
}
