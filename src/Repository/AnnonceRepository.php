<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }
    public function findByidOwner($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idOwner = :val')
            ->setParameter('val', $value)
            ->orderBy('c.type', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    //trouve les annonces selon le type
    public function findAnnoncesByType(string $query ,string $query1,string $query2)
    {
        $filtre = $this->createQueryBuilder('p');
       
        $filtre ->where(
                $filtre->expr()->andX(
                    $filtre->expr()->andX(
                        //$filtre->expr()->like('p.title', ':query'),
                        $filtre->expr()->like('p.type', ':query'),
                        $filtre->expr()-> like('p.domaine', ':query1'),
                        $filtre->expr()->    like('p.location', ':query2')
                  
                    ),
                   
                   // $filtre->expr()->isNotNull('p.created_at')
                )
                )
       
        
          
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('query1', '%' . $query1 . '%')
           ->setParameter('query2', '%' . $query2 . '%');
        return $filtre
            ->getQuery()
            ->getResult();
    }
     //trouve les annonces selon le type
     public function findAnnoncesByall(string $query)
     {
         $filtre = $this->createQueryBuilder('p');
         $filtre
             ->where(
                 $filtre->expr()->andX(
                     $filtre->expr()->orX(
                         $filtre->expr()->like('p.title', ':query'),
                         $filtre->expr()->like('p.type', ':query'),
                         $filtre->expr()->like('p.content', ':query'),
                         $filtre->expr()->like('p.location', ':query'),
                     ),
                   
                 )
             )
             ->setParameter('query', '%' . $query . '%')
         ;
         return $filtre
             ->getQuery()
             ->getResult();
     }

   
}
