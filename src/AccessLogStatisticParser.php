<?php

namespace src;

class AccessLogStatisticParser
{
	const TRAFFIC_COUNTING_STATUS = 200;
	const VIEWS = 'views';
	const URLS = 'urls';
	const TRAFFIC = 'traffic';
	const CRAWLERS = 'crawlers';
	const STATUS_CODES = 'statusCodes';
	const GOOLE_CRAWLER = 'Google';
	const BING_CRAWLER = 'Bing';
	const BAIDU_CRAWLER = 'Baidu';
	const YANDEX_CRAWLER = 'Yandex';


	private $urls = [];
	private $lineParts = [];
	private $statistic = [
		self::VIEWS        => 0,
		self::URLS         => 0,
		self::TRAFFIC      => 0,
		self::CRAWLERS     => [
			self::GOOLE_CRAWLER => 0,
			self::BING_CRAWLER => 0,
			self::BAIDU_CRAWLER => 0,
			self::YANDEX_CRAWLER => 0,
		],
		self::STATUS_CODES => [],
	];

	/**
	 * @param string $row
	 * @return void
	 */
	public function parse(string $row)
	{
		preg_match(
			'/"\w+ (?<url>[\S]+).+" (?<statusCode>\d+) (?<contentLength>\d*)(.+".*" "(?<userAgent>.*)")?/',
			$row,
			$this->lineParts
		);

		if (!empty($this->lineParts['url'])) {
			$this->statistic[self::VIEWS]++;

			if (!array_key_exists($this->lineParts['url'], $this->urls)) {
				$this->urls[$this->lineParts['url']] = true;
				$this->statistic[self::URLS]++;
			}
		}

		if (!empty($this->lineParts['contentLength']) && $this->lineParts['statusCode'] == self::TRAFFIC_COUNTING_STATUS) {
			$this->statistic[self::TRAFFIC] += $this->lineParts['contentLength'];
		}

		if (!empty($this->lineParts['userAgent'])) {
			$this->crawlerCounter($this->lineParts['userAgent']);
		}

		if (!empty($this->lineParts['statusCode'])) {

			if (!array_key_exists($this->lineParts['statusCode'], $this->statistic[self::STATUS_CODES])) {
				$this->statistic[self::STATUS_CODES][$this->lineParts['statusCode']] = 0;
			}
			$this->statistic[self::STATUS_CODES][$this->lineParts['statusCode']]++;
		}
	}

	/**
	 * @return array
	 */
	public function getStatistic() : array
	{
		return $this->statistic;
	}

	/**
	 * @param string $userAgent
	 * @return void
	 */
	private function crawlerCounter(string $userAgent) 
	{
        foreach ($this->statistic[self::CRAWLERS] as $crawler => $count) {
            if(preg_match('(' . $crawler .')', $userAgent)) {
				$this->statistic[self::CRAWLERS][$crawler]++;
            }
        }
	}
}