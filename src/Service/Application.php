<?php

namespace App\Service;

use App\DTO\ApplicationResult;
use App\Util\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Application as ApplicationEntity;

/**
 * Сервис создания заявок.
 */
class Application
{
    /** Менеджер сущностей. */
    private EntityManagerInterface $entityManager;

    /** Валидатор. */
    private ValidatorInterface $validator;

    /**
     * Конструктор.
     *
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * Добавить заявку.
     *
     * @param float $amount
     * @param int $type
     * @param string $wallet
     *
     * @return ApplicationResult
     */
    public function add(float $amount, int $type, string $wallet): ApplicationResult
    {
        $success = true;
        $reason = '';

        $application = new ApplicationEntity();
        $application->setAmount($amount)
            ->setType($type)
            ->setWallet($wallet)
            ->setStatus(ApplicationEntity::STATUS_NEW);

        $errors = $this->validator->validate($application);

        if (\count($errors)) {
            $success = false;
            $reason = \sprintf("%s: %s", $errors[0]->getPropertyPath(), $errors[0]->getMessage());
        } else {
            if ($type === ApplicationEntity::TYPE_BITCOINT) {

                if (!Validator::validateBitcoin($wallet)) {
                    $success = false;
                    $reason = 'Bitcoin кошелк указан в неправильном формате';
                }
            } elseif ($type === ApplicationEntity::TYPE_WMZ) {
                if (!Validator::validateWMZ($wallet)) {
                    $success = false;
                    $reason = 'WMZ кошелк указан в неправильном формате';
                }
            }
        }

        if ($success) {
            $this->entityManager->persist($application);
            $this->entityManager->flush();
        }

        return new ApplicationResult($success, $reason);
    }
}