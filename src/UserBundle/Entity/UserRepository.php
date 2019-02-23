<?php
/**
 * Created by PhpStorm.
 * User: selim
 * Date: 06/04/2018
 * Time: 17:31
 */

namespace UserBundle\Entity;


use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Evenement;

class UserRepository extends EntityRepository
{
    public function getUsers(){
        $query=$this->getEntityManager()->createQuery("Select u from UserBundle:User u ");

        return $query->getResult();
    }

    public function getNomUtilisateur(){
        $query=$this->getEntityManager()->createQuery("select u.username from  UserBundle:User u  INNER JOIN UserBundle:Evenement e WITH u.id = e.idUser");
        return $query->getResult();


    }
}