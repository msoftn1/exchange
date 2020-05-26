<?php
namespace App\Service;

use App\Entity\Rate;
use App\Exception\RateParserException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Сервис парсинга курсов валют.
 */
class RateParser
{
    /** Адрес по которому парсить курсы */
    const COURSES_URL = "https://finance.rambler.ru/currencies/";

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
     * Обновить курсы валют.
     *
     * @throws RateParserException
     */
    public function update(): void
    {
        try {
            $rates = $this->loadCourses();

            $rateEntityUsd = new Rate();
            $rateEntityUsd
                ->setType(Rate::TYPE_USD_RUB)
                ->setAddedAt(new \DateTime("NOW"))
                ->setBuy($rates[6])
                ->setSell($rates[7]);

            $rateEntityEur = new Rate();
            $rateEntityEur
                ->setType(Rate::TYPE_EUR_RUB)
                ->setAddedAt(new \DateTime("NOW"))
                ->setBuy($rates[8])
                ->setSell($rates[9]);

            $this->entityManager->persist($rateEntityUsd);
            $this->entityManager->persist($rateEntityEur);
            $this->entityManager->flush();
        }
        catch (\Exception $e) {
            throw new RateParserException('Ошибка обновления курсов валют', 0, $e);
        }
    }

    /**
     * Загрузить курсы валют.
     *
     * @return array
     */
    private function loadCourses(): array
    {
        $raw = $this->loadPageWithCourses();

        $rates = [];
        $crawler = new Crawler($raw);
        $crawler->filter('div.finance-exchange-rate__value')
            ->each(function (Crawler $node) use (&$rates) {
                $rate = (float)\trim($node->html());
                $rates[] = $rate;
            });

        return $rates;
    }

    /**
     * Загрузить страницу с курсами валют.
     *
     * @return string
     */
    private function loadPageWithCourses(): string
    {
        return \file_get_contents(self::COURSES_URL);
    }
}
