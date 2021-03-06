<?php

namespace App\Repository;

use App\Entity\Resa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Resa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resa[]    findAll()
 * @method Resa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resa::class);
    }

    public function findTicketsByDate($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.visitDate = :val')
            ->setParameter('val', $value)
            ->join('r.tickets', 't')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
