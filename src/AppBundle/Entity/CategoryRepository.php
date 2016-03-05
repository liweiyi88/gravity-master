<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 25/01/2016
 * Time: 8:25 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{

    public function findAllWithProductShownNav()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c,c1,p,b FROM AppBundle:Category c
                 LEFT JOIN c.children c1
                 LEFT JOIN c.products p
                 LEFT JOIN p.brand b
                WHERE p.isShownNav = true
                ORDER BY c.priority ASC'
            );

        $result = $query->getResult();
        return $result;
    }


    public function findAll()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c,c1,p,b FROM AppBundle:Category c
                 LEFT JOIN c.children c1
                 LEFT JOIN c.products p
                 LEFT JOIN p.brand b
                ORDER BY c.priority ASC'
            );

        $result = $query->getResult();
        return $result;
    }

    public function findById($id)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Category c
                 WHERE
                 c.id = :id
                '
            );
        $query->setParameter('id',$id);

        $result = $query->getOneOrNullResult();
        return $result;
    }

}