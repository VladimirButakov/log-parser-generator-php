<?php

namespace src;

use src\AccessLogStatisticParser;

class AccessLogStatisticGenerator
{
	private $filePath;
	/** @var AccessLogStatisticParser */
	private $accessLogStatisticParser;

	/**
	 * AccessLogStatisticParser constructor.
	 * @param string $filePath
	 */
	public function __construct(string $filePath)
	{
		
		$this->filePath = $filePath;
		$this->accessLogStatisticParser = new AccessLogStatisticParser();
	}

	/**
	 * @return array
	 */
	private function parse() : array
	{	
		if (!$this->filePath) return [];
		$rows = $this->getRows();
		
		foreach ($rows as $row) {
			$this->accessLogStatisticParser->parse($row);
		}

		return $this->accessLogStatisticParser->getStatistic();
	}

	/**
	 * @return Generator
	 */
	private function getRows()
	{
		$accessLog = new \SplFileObject($this->filePath);
		while(!$accessLog->eof()) {
			yield  $accessLog->fgets(); 
		}
	}

	/**
	 * @return string
	 */
	public function getStatistic() : string
	{
		return json_encode($this->parse());
	}

}