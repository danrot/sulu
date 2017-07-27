<?php

namespace Sulu\Bundle\WebspaceBundle\Model;

// TODO think about a better name (what we are modelling here is not really a URL)
class Url
{
    private $pattern;

    private $host;

    public function __construct($pattern, $host)
    {
        $this->pattern = $pattern;
        $this->host = $host;
    }
}
