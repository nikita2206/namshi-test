<?php

namespace Tele\ComBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use JMS\DiExtraBundle\Annotation\FormType;

/**
 * @FormType(alias="telecom_customer")
 */
class CustomerType extends AbstractType
{

    public function getName()
    {
        return "telecom_customer";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", "text");
    }

}
