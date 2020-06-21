<?php
declare(strict_types=1);

namespace App\Service;


use App\Exception\InvalidInputException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class MarsTimezoneConverter
{
    const CURRENT_LEAP_SECOND = 37;
    const SECONDS_PER_SOL = 88775.244147;
    const SECONDS_PER_DAY = 86400;


    private $_timestamp = null;
    private $_MSD = null;

    public function __construct(RequestStack $request)
    {
        $utc = rawurldecode($request->getCurrentRequest()->get('utc'));// ?? 'now';
        try{
            $this->_timestamp = (new \DateTime($utc))->getTimestamp();
        }catch (\Exception $exception){
            throw new InvalidInputException('Invalid UTC!', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        $this->_MSD = ($this->_timestamp + self::CURRENT_LEAP_SECOND) / self::SECONDS_PER_SOL + 34127.2954262;
    }

    public function getSolarDate(): int
    {
        return (int)$this->_MSD;
    }

    public function getCoordinatedTime(): string
    {
        $MTC = (int)fmod($this->_MSD * self::SECONDS_PER_DAY, self::SECONDS_PER_DAY);
        return gmdate('H:i:s', $MTC);
    }
}