<?php
namespace App\Service;

use App\DTO\Rates;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use App\Entity\Rate as RateEntity;

/**
 * Сервис курсов валют.
 */
class Rate
{
    /** Менеджер сущностей. */
    private EntityManagerInterface $entityManager;

    /**
     * Конструктор.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Получить курсы валют.
     *
     * @return Rates
     */
    public function getCourses(): Rates
    {
        /** @var EntityRepository $repository */
        $repository = $this->entityManager
            ->getRepository(RateEntity::class);

        $usdRub = null;
        try {
            $usdRub = $repository->createQueryBuilder('r')
                ->where('r.type=:type')
                ->setParameter('type', RateEntity::TYPE_USD_RUB)
                ->orderBy('r.id', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        }
        catch (NoResultException $e) {}

        $eurRub = null;
        try {
            $eurRub = $repository->createQueryBuilder('r')
                ->where('r.type=:type')
                ->setParameter('type', RateEntity::TYPE_EUR_RUB)
                ->orderBy('r.id', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        }
        catch (NoResultException $e) {}

        return new Rates($usdRub, $eurRub);
    }
}
