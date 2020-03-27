<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //je crée une méthode pour rechercher un mot dans le champs Biography avec une variable $word en paramètre
    public function getByWordInBiography ($word)
    {
        //je fais appel au contructeur de requêtes dans la table a
        $queryBuilder = $this->createQueryBuilder('a');
        //je crée la requête pour qui va récupérer les auteurs qui on le terme recherché
        $query = $queryBuilder->select('a')
            ->where('a.biography LIKE :word')
            //j'ajoute une ligne pour sécuriser ma requête
            ->setParameter('word', '%'.$word.'%')
            ->getQuery();

        $results = $query->getResult();

        return $results;
    }

    // /**
    //  * @return Author[] Returns an array of Author objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
