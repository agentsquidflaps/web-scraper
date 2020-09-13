<?php

namespace Agentsquidflaps\WebScraper\Formatter;

class ArrayFormatter implements FormatterInterface
{
    public function get(array $data)
    {
        return $data;
    }

    public function save(array $data, $file)
    {
        return (new JsonFormatter)->save($data, $file);
    }
}
