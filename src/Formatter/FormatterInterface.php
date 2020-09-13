<?php

namespace Agentsquidflaps\WebScraper\Formatter;

interface FormatterInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function get(array $data);

    /**
     * @param array $data
     * @param resource $file
     * @return mixed
     */
    public function save(array $data, $file);
}
