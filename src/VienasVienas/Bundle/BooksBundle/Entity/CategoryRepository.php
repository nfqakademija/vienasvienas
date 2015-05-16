<?php

namespace VienasVienas\Bundle\BooksBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Category Repository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Finds category id by its name.
     *
     * @param string $categoryName
     *
     * @return int
     */
    public function getCategoryId($categoryName)
    {
        $dq = $this->createQueryBuilder('c')
            ->select('c.id')
            ->where('c.categoryName = :categoryName')
            ->setParameter('categoryName', $categoryName)
            ->getQuery();

        $categoryId = $dq->getSingleScalarResult();

        return $categoryId;
    }
}