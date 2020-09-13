<?php

namespace Agentsquidflaps\WebScraper;

use Agentsquidflaps\WebScraper\Formatter\ArrayFormatter;
use Agentsquidflaps\WebScraper\Formatter\CsvFormatter;
use Agentsquidflaps\WebScraper\Formatter\FormatterInterface;
use Agentsquidflaps\WebScraper\Formatter\JsonFormatter;

/**
 * Class WebScraper
 * @package Agentsquidflaps\WebScraper
 */
class WebScraper
{
    /** @var array */
    private $sitemaps = [];

    /** @var string */
    private $format = self::FORMAT_JSON;

    /** @var array */
    private $elements = [];

    /** @var string | null */
    private $fileLocation;

    /** @var bool */
    private $verifyPeerEnabled = true;

    /** @var Fetcher */
    private $fetcher;

    const FORMAT_JSON = 'json';
    const FORMAT_CSV = 'csv';
    const FORMAT_ARRAY = 'array';

    public function __construct()
    {
        $this->fetcher = new Fetcher($this);
    }

    /**
     * @return array
     */
    public function getSitemaps(): array
    {
        return $this->sitemaps;
    }

    /**
     * @param array $sitemaps
     * @return WebScraper
     */
    public function setSitemaps(array $sitemaps): WebScraper
    {
        $this->sitemaps = $sitemaps;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return WebScraper
     */
    public function setFormat(string $format): WebScraper
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param array $elements
     * @return WebScraper
     */
    public function setElements(array $elements): WebScraper
    {
        $this->elements = $elements;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileLocation(): ?string
    {
        return $this->fileLocation;
    }

    /**
     * @param string|null $fileLocation
     * @return WebScraper
     */
    public function setFileLocation(?string $fileLocation): WebScraper
    {
        $this->fileLocation = $fileLocation;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVerifyPeerEnabled(): bool
    {
        return $this->verifyPeerEnabled;
    }

    /**
     * @param bool $verifyPeerEnabled
     * @return WebScraper
     */
    public function setVerifyPeerEnabled(bool $verifyPeerEnabled): WebScraper
    {
        $this->verifyPeerEnabled = $verifyPeerEnabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->getFormatter()->get($this->getFetcher()->fetchData());
    }

    /**
     * @throws \Exception
     */
    public function saveData()
    {
        if (!$this->getFileLocation()) {
            throw new \Exception('Cannot save to file: File location has not been set');
        }

        $file = fopen($this->getFileLocation(), "w+");

        $formatter = $this->getFormatter();

        $formatter->save($this->getFetcher()->fetchData(), $file);

        fclose($file);
    }

    /**
     * @return Fetcher
     */
    private function getFetcher()
    {
        return $this->fetcher;
    }

    /**
     * @return FormatterInterface
     */
    private function getFormatter()
    {
        switch ($this->getFormat()) {
            case self::FORMAT_CSV:
                return new CsvFormatter();
                break;
            case self::FORMAT_JSON:
                return new JsonFormatter();
                break;
            default:
                return new ArrayFormatter();
        }
    }
}
