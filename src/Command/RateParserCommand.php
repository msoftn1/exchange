<?php

namespace App\Command;

use App\Service\RateParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Команда для обновления курсов валют.
 */
class RateParserCommand extends Command
{
    /** @var string Название команды. */
    protected static $defaultName = 'app:rate-parser';

    /** Сервис парсинга курсов валют. */
    private RateParser $rateParser;

    /**
     * Конструктор.
     *
     * @param RateParser $rateParser
     */
    public function __construct(RateParser $rateParser)
    {
        $this->rateParser = $rateParser;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Парсер курсов валют.');;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->rateParser->update();

            $io->success("Курс успешно обновлен");
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }

        return 0;
    }
}
