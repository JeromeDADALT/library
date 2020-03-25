<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getByWordInResume ($word)
    {
        //$word = 'jeunesse';

        $queryBuilder = $this->createQueryBuilder('b');
        $query = $queryBuilder->select('b')
            ->where('b.resume LIKE :word')
            ->setParameter('word', '%'.$word.'%')
            ->getQuery();

        $results = $query->getResult();

        return $results;
    }

}