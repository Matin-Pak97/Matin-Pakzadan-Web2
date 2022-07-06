<?php

namespace App\Tests\Service;

use App\Service\HotelServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class HotelSearchTest extends KernelTestCase
{

    public function testSearchHotel()
    {
        self::bootKernel();
        $container = static::getContainer();
        /* @var HotelServices $hotelService */
        $hotelService = $container->get(HotelServices::class);

        $result = $hotelService->searchHotel('There is no Hotel');
        $this->assertEmpty($result);

        $result = $hotelService->searchHotel('Grand Hotel');
        $this->assertNotEmpty($result);
    }
}
