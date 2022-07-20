<?php

namespace App\Tests\Integration\Service;

use App\Entity\Hotel;
use App\Service\HotelServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class HotelSearchTest extends KernelTestCase
{

    public function testSearchHotel()
    {
        self::bootKernel();
        $container = static::getContainer();
        /* @var HotelServices $hotelService */
        $hotelService = $container->get(HotelServices::class);
        /* @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $newHotel = new Hotel();
        $newHotel->setName("Grand Hotel Tehran");
        $newHotel->setAddress("Address Grand Hotel Tehran");
        $entityManager->persist($newHotel);
        $entityManager->flush();

        $result = $hotelService->searchHotel('There is no Hotel');
        $this->assertEmpty($result);

        $result = $hotelService->searchHotel('Grand Hotel');
        $this->assertNotEmpty($result);
    }
}
