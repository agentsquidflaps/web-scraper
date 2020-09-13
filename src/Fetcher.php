<?php

namespace Agentsquidflaps\WebScraper;

use Symfony\Component\DomCrawler\Crawler;

class Fetcher
{
    private $webScraper;

    public function __construct(WebScraper $webScraper)
    {
        $this->setWebScraper($webScraper);
    }

    /**
     * @return WebScraper
     */
    private function getWebScraper(): WebScraper
    {
        return $this->webScraper;
    }

    /**
     * @param WebScraper $webScraper
     * @return Fetcher
     */
    private function setWebScraper(WebScraper $webScraper): Fetcher
    {
        $this->webScraper = $webScraper;
        return $this;
    }


    /**
     * @return array
     */
    public function fetchData()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 300);
        $data = [];

        foreach ($this->getWebScraper()->getSitemaps() as $sitemap) {
            $xml = $this->fetchSitemapXml($sitemap);

            foreach ($xml->url as $urlNode) {
                $url = (string)$urlNode->loc;
                $urlContent = $this->fetchContentFromUrl($url);

                if (count($this->getWebScraper()->getElements())) {
                    $page = new Crawler($urlContent);

                    foreach ($this->getWebScraper()->getElements() as $element) {
                        $results = $page->filter($element);

                        if (count($results)) {
                            if (!isset($data[$url])) {
                                $data[$url] = [];
                            }

                            $data[$url][$element] = [];

                            $results->each(function (Crawler $node) use (&$data, $url, $element) {
                                array_push($data[$url][$element], $node->outerHtml());
                            });
                        }
                    }
                } else {
                    $data[$url] = $urlContent;
                }
            }
        }

        return $data;
    }

    /**
     * @param string $url
     * @return \SimpleXMLElement
     */
    private function fetchSitemapXml(string $url)
    {
        $xmlContent = $this->fetchContentFromUrl($url);
        return simplexml_load_string($xmlContent);
    }

    /**
     * @param string $url
     * @return false|string
     */
    private function fetchContentFromUrl(string $url)
    {
        return file_get_contents($url, false, stream_context_create([
            'ssl' => [
                'verify_peer' => $this->getWebScraper()->isVerifyPeerEnabled(),
                'verify_peer_name' => $this->getWebScraper()->isVerifyPeerEnabled()
            ]
        ]));
    }
}
