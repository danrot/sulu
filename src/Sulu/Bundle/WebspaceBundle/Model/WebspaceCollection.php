<?php

namespace Sulu\Bundle\WebspaceBundle\Model;

class WebspaceCollection
{
    /**
     * @var Webspace[]
     */
    private $webspaces;

    public function __construct(array $webspaces)
    {
        $this->webspaces = $webspaces;
    }

    public function get($key)
    {
        // TODO throw exception if key does not exist
        return $this->webspaces[$key];
    }
}
