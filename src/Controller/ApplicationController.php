<?php

namespace App\Controller;

use App\Service\Application;
use App\Service\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Класс контроллера для создания заявки.
 */
class ApplicationController extends AbstractController
{
    /** Сервис курсов валют. */
    private Rate $rateService;

    /** Сервис заявок. */
    private Application $applicationService;

    /**
     * Конструктор.
     *
     * @param Rate $rateService
     * @param Application $applicationService
     */
    public function __construct(Rate $rateService, Application $applicationService)
    {
        $this->rateService = $rateService;
        $this->applicationService = $applicationService;
    }

    /**
     * Главная страница
     *
     * @Route("/", name="application_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rates = $this->rateService->getCourses();

        return $this->render(
            'application/index.html.twig', [
                'rates' => $rates
            ]
        );
    }

    /**
     * Валидирует и сохраняет заявку.
     *
     * @param Request $request
     *
     * @Route("/save", name="application_save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        $amount = (float)$request->get('amount');
        $type = (int)$request->get('type');
        $wallet = $request->get('wallet');

        $res = $this->applicationService->add($amount, $type, $wallet);
        $ret = ['status' => ($res->isSuccess() ? 'success' : 'error'), 'reason' => $res->getReason()];

        $response = new Response(\json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
