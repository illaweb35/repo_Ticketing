<?php
namespace App\Tests\Repository;

use App\Entity\Resa;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResaRepositoryTest extends KernelTestCase
{
    /**
* @var \Doctrine\ORM\EntityManager
*/
    private $entityManager;

    /**
* {@inheritDoc}
*/
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindTicketsByDate()
    {
        $resa = $this->entityManager
            ->getRepository(Resa::class)
            ->createQueryBuilder('r')
            ->andWhere('r.visitDate = :val')
            ->setParameter('val', new \DateTime())
            ->join('r.tickets', 't')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();;

        $this->assertEquals(0, $resa);
    }
}
