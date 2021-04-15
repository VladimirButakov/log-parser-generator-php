<?php

namespace src;

class AccessLogStatisticValidator
{
	private $filePath;

	/**
	 * AccessLogStatisticValidator constructor.
	 * @param string $filePath
	 */
	public function __construct(string $filePath)
	{
		$this->filePath = $filePath;
	}

	/**
	 * @return string
	 */
	public function validation() : string
	{
		$error = '';
		$filePath = $this->filePath;
		if (!isset($filePath)) {
			$error = 'Не указано место нахождение файла';
		}
	
		
		if (!file_exists($filePath)) {
			$error = str_replace('%s%', $filePath,'По пути "%s%" файл не найден');
		}

		return $error . PHP_EOL;
	}

}