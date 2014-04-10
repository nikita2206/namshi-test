<?php

namespace Tele\ComBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Customer
{

    protected $id;

    protected $name;

    protected $phones;


    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhones()
    {
        return $this->phones;
    }

}
