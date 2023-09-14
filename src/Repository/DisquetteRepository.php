<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Disquette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Disquette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disquette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disquette[] findAll()
 * @method Disquette[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisquetteRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disquette::class);
    }
}