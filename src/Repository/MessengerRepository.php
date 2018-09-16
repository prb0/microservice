<?php

namespace App\Repository;

use App\Entity\Messenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Messenger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messenger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messenger[]    findAll()
 * @method Messenger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessengerRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Messenger::class);
	}

    /**
     * @return Messenger[] Returns an array of Messenger objects
     */
	public function findWhereHasSubscribers(): ?array
	{
		return $this->createQueryBuilder('m')
			->innerJoin('m.subscribers', 's')
			->andWhere('s.id > :zero')
			->setParameter('zero', 0)
			->getQuery()
			->getResult();
	}
}
