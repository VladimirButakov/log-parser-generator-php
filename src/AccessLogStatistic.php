<?php

namespace src;

use src\AccessLogStatisticValidator;
use src\AccessLogStatisticGenerator;

class AccessLogStatistic 
{
	/** @var AccessLogStatisticValidator */
	private $accessLogStatisticValidator;

	/** @var AccessLogStatisticGenerator */
	private $accessLogStatisticGenerator;

	/**
	 * AccessLogStatistic constructor.
	 * @param string $filePath
	 */
	public function __construct($filePath)
	{
		$this->accessLogStatisticValidator = new AccessLogStatisticValidator($filePath);
		$this->accessLogStatisticGenerator = new AccessLogStatisticGenerator($filePath);
	}

	/**
	 * @return string
	 */
	public function getStatistic() : string
	{
		return $this->accessLogStatisticGenerator->getStatistic();
	}

	/**
	 * @return string
	 */
	public function validation() : string
	{
		return $this->accessLogStatisticValidator->validation();
	}

}