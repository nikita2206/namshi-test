<?php

namespace Tele\ComBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tele\ComBundle\Entity\Customer;
use Tele\ComBundle\Exception\EntityNotFoundException;

use JMS\DiExtraBundle\Annotation as Di;

class CustomerRepository extends EntityRepository
{

    public function addCustomer(Customer $customer)
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }

    public function updateCustomer(Customer $customer)
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param $id
     * @return Customer
     * @throws EntityNotFoundException
     */
    public function get($id)
    {
        $customer = $this->find($id);

        if (null === $customer) {
            throw new EntityNotFoundException();
        }

        return $customer;
    }

}
