<?php

namespace Tele\ComBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use JMS\DiExtraBundle\Annotation\FormType;

/**
 * @FormType(alias="telecom_phone_number")
 */
class PhoneNumberType extends AbstractType
{

    public function getName()
    {
        return "telecom_phone_number";
    }

    public function getParent()
    {
        return "telecom_phone_number_update";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("number", "text");
    }

}
