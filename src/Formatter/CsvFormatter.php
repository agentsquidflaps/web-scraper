<?php

namespace Agentsquidflaps\WebScraper\Formatter;

class CsvFormatter implements FormatterInterface
{
    public function get(array $data)
    {
        $rows = [];

        if ($this->hasElements($data)) {
            $rows = [
                ['url', 'element', 'content']
            ];

            foreach ($data as $url => $elements) {
                foreach ($elements as $element => $contents) {
                    foreach ($contents as $content) {
                        $rows[] =  [(string) $url, (string) $element, (string) $content];
                    }
                }
            }
        } else {
            $rows = [
                ["url", "content"]
            ];

            foreach ($data as $url => $content) {
                $rows[] = [$url, $content];
            }
        }

        return $rows;
    }

    public function save(array $data, $file)
    {
        foreach ($this->get($data) as $row) {
            fputcsv($file, $row);
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    private function hasElements(array $data)
    {
        $first = current($data);
        return is_array($first);
    }
}
