<?php
declare(strict_types=1);

namespace App\Controller;


use App\Service\MarsTimezoneConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{

    public function getTime(MarsTimezoneConverter $timezoneConverter): JsonResponse
    {
        return new JsonResponse(
            [
                "MSD" => $timezoneConverter->getSolarDate(),
                "MTC" => $timezoneConverter->getCoordinatedTime()
            ],
            JsonResponse::HTTP_OK
        );
    }
}