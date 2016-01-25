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
    public function findAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Category c ORDER BY c.priority ASC'
            )
            ->getResult();
    }

}