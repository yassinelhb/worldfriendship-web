<?php
/**
 * Created by PhpStorm.
 * User: selim
 * Date: 06/04/2018
 * Time: 17:31
 */

namespace UserBundle\Entity;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUsers(){
        $query=$this->getEntityManager()->createQuery("Select u from UserBundle:User u ");

        return $query->getResult();
    }

}