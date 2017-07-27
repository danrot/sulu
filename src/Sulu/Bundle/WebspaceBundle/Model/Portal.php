<?php

namespace Sulu\Bundle\WebspaceBundle\Model;

class Portal
{
    private $urls;

    public function __construct($urls)
    {
        $this->urls = $urls;
    }
}
