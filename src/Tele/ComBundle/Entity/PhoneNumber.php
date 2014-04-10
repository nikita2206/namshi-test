<?php

namespace Tele\ComBundle\Entity;

class PhoneNumber
{

    protected $id;

    protected $active;

    protected $number;

    protected $customer;


    public function __construct($number, $isActive, Customer $customer)
    {
        $this->number   = $number;
        $this->active   = (bool)$isActive;
        $this->customer = $customer;

        $customer->getPhones()->add($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($isActive)
    {
        $this->active = (bool)$isActive;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

}
