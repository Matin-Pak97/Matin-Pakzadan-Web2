<?php

namespace App\Service;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;

class HotelServices
{
    private EntityManagerInterface $entityManager;
    private HotelRepository $hotelRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        HotelRepository $hotelRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * @param $hotelName
     *
     * @return Hotel[]
     */
    public function searchHotel($hotelName):array {
        return $this->hotelRepository->search($hotelName);
    }
}