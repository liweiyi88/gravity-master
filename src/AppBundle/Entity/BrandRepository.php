<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 31/01/2016
 * Time: 8:54 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;


class BrandRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT b,p FROM AppBundle:Brand b
                LEFT JOIN b.products p'
            )
            ->getResult();
    }

    public function findById($id)
    {

        return $this->getEntityManager()
            ->createQuery(
                'SELECT b FROM AppBundle:Brand b
                 WHERE
                 b.id = :id
                '
            )
            ->setParameter('id',$id)
            ->getOneOrNullResult();
    }

}