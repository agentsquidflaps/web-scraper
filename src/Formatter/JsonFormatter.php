<?php

namespace Agentsquidflaps\WebScraper\Formatter;

class JsonFormatter implements FormatterInterface
{
    public function get(array $data)
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function save(array $data, $file)
    {
        return fwrite($file, $this->get($data));
    }
}
