<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // Recherche un livre par le Titre
    public function searchBooks(string $query)
    {
        // Création d'une requête pour rechercher un livre par son titre
        return $this->createQueryBuilder('b')
            ->where('b.title LIKE :query') // 
            ->orWhere('b.author LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

    // Recherche un livre par le Categorie
    public function findBooksByCategory(string $category)
    {
        // Création d'une requête pour filtrer les livres par catégorie
        return $this->createQueryBuilder('b')
            ->where('b.category = :category')  // Condition pour filtrer par catégorie
            ->setParameter('category', $category)  // On lie le paramètre avec la catégorie fournie
            ->getQuery()  // On obtient la requête Doctrine
            ->getResult();  // Exécution de la requête et récupération des résultats
    }

    //    /**
    //     * @return Livre[] Returns an array of Livre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
