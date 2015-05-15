<?php

namespace VienasVienas\Bundle\BooksBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookRepository extends EntityRepository
{
    /**
     * @param int $categoryId
     *
     * @return array
     */
    public function getAllBooksByCategory($categoryId)
    {
        $dq = $this->createQueryBuilder('b')
            ->join('b.categories', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $categoryId)
            ->getQuery();

        $books = $dq->getResult();

        return $books;
    }

    /**
     * @return array
     */
    public function getMostPopularBooks()
    {
        $dq = $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.timesRead', 'DESC')
            ->setMaxResults(3)
            ->getQuery();

        $books = $dq->getResult();

        return $books;
    }
}
