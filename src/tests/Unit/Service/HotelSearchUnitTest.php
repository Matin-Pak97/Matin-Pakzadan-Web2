<?php

namespace App\Tests\Unit\Service;

use App\Repository\HotelRepository;
use App\Service\HotelServices;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class HotelSearchUnitTest extends TestCase
{
    public function testLowerCaseToCapitalHotelName(HotelRepository $hotelRepository, EntityManagerInterface $entityManager) {
        $hotelSearchService = new HotelServices($entityManager, $hotelRepository);

        $actual = $hotelSearchService->lowerCaseToCapitalHotelName('hotel capital');
        $this->assertEquals('HOTEL CAPITAL', $actual);

        $actual = $hotelSearchService->lowerCaseToCapitalHotelName('');
        $this->assertEquals('', $actual);
    }

    public function testLowerCaseToCapitalHotelName_inputIsNull_throwException(HotelRepository $hotelRepository, EntityManagerInterface $entityManager) {
        $hotelSearchService = new HotelServices($entityManager, $hotelRepository);

        $this->expectException(InvalidArgumentException::class);
        $actual = $hotelSearchService->lowerCaseToCapitalHotelName('hotel capital');
    }
}