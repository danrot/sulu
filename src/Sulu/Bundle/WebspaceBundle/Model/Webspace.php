<?php

namespace Sulu\Bundle\WebspaceBundle\Model;

class Webspace
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Portal[]
     */
    private $portals;

    public function __construct($name, $portals)
    {
        $this->name = $name;
        $this->portals = $portals; // TODO order in a way that they can be simply iterated for the matching
    }
}
