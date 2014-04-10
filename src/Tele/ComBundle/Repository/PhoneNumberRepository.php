<?php

namespace Tele\ComBundle\Repository;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Tele\ComBundle\Entity\PhoneNumber;

use JMS\DiExtraBundle\Annotation as Di;

class PhoneNumberRepository extends EntityRepository
{

    /**
     * @param $id
     * @return PhoneNumber
     * @throws EntityNotFoundException
     */
    public function get($id)
    {
        $phoneNumber = $this->find($id);

        if (null === $phoneNumber) {
            throw new EntityNotFoundException();
        }

        return $phoneNumber;
    }

    public function updatePhoneNumber(PhoneNumber $phoneNumber)
    {
        $this->getEntityManager()->flush();
    }

}
