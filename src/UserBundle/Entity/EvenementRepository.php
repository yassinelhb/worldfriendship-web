<?php
/**
 * Created by PhpStorm.
 * User: solta
 * Date: 18/02/2019
 * Time: 21:18
 */

namespace UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EvenementRepository extends EntityRepository
{

    public function search($data, $page = 0, $max = NULL, $getResult = true)
    {
        $qb = $this->_em->createQueryBuilder();
        $query = isset($data['query']) && $data['query']?$data['query']:null;
        $user = isset($data['user']) && $data['user']?$data['user']:null;

        $qb
            ->select('e')
            ->from('UserBundle:Evenement', 'e')
        ;
        if($user){
            $qb->where('e.idUser = :user')
                ->setParameter('user', $user);
        }
        if ($query){
            $qb
                ->andWhere('e.nom like :query')
                ->orWhere('e.type like :query')
                ->orWhere('e.typeReservation like :query')
                ->orWhere('e.duree like :query')
                ->orWhere('e.dateEvent like :query')
                ->orWhere('e.lieu like :query')
                ->orWhere('e.nombre like :query')
                ->orWhere('e.prix like :query')
                ->setParameter('query', "%".$query."%")
            ;

        }
        $qb->orderBy('e.dateEvenement', 'DESC');

        if ($max) {
            $preparedQuery = $qb->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max)
            ;
        } else {
            $preparedQuery = $qb->getQuery();
        }

        return $getResult?$preparedQuery->getResult():$preparedQuery;
    }

}