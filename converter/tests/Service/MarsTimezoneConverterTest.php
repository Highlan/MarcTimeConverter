<?php

namespace Tests\Service;

use App\Exception\InvalidInputException;
use App\Service\MarsTimezoneConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MarsTimezoneConverterTest extends TestCase
{
    private $_converter;


    public function testThrowExceptionOnInvalidUtc()
    {
        $this->expectException(InvalidInputException::class);

        $request = Request::create(
            '/',
            'GET',
            array('utc' => rawurlencode('some invalid data'))
        );

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $this->_converter = new MarsTimezoneConverter($requestStack);
    }

    /**
     * @dataProvider UTCDataProviderFor
     */
    public function testReturnsSolarDateAndCoordinatedTime($utc, $msd, $mtc)
    {
        $request = Request::create(
            '/',
            'GET',
            array('utc' => rawurlencode($utc))
        );

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $this->_converter = new MarsTimezoneConverter($requestStack);

        $this->assertEquals($msd, $this->_converter->getSolarDate());
        $this->assertEquals($mtc, $this->_converter->getCoordinatedTime());
    }


    public function UTCDataProviderFor()
    {
        return [
            ['16 Jun 2020, 16:26:48 UTC', 52063, '21:09:57'],
            ['Tue, 16 Jun 2020 16:26:48 GMT', 52063, '21:09:57'],
            ['16-06-2020 16:26:48 UTC', 52063, '21:09:57'],
            ['06/16/2020 16:26:48 GMT', 52063, '21:09:57']
        ];
    }
}