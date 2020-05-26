<?php
namespace App\DTO;

use App\Entity\Rate;

/**
 * DTO с курсами валют.
 */
class Rates
{
    /** Курс USD. */
    private ?Rate $usd;

    /** Курс EUR. */
    private ?Rate $eur;

    /**
     * Конструктор.
     *
     * @param Rate $usd
     * @param Rate $eur
     */
    public function __construct(?Rate $usd, ?Rate $eur)
    {
        $this->usd = $usd;
        $this->eur = $eur;
    }

    /**
     * Получить курс USD.
     *
     * @return Rate|null
     */
    public function getUsd(): ?Rate
    {
        return $this->usd;
    }

    /**
     * Получить курс EUR.
     *
     * @return Rate|null
     */
    public function getEur(): ?Rate
    {
        return $this->eur;
    }


}