<?php

namespace App\Menu;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private FactoryInterface $factory;
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;

    public function __construct(
        FactoryInterface $factory,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
    )
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function mainMenu(): \Knp\Menu\ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_home']);
        $menu->addChild('About us', ['route' => 'app_about']);
        $menu->addChild('Contact us', ['route' => 'app_message_index']);
        $menu->addChild('Hotels', ['route' => 'app_hotel_index']);

        /** @var Hotel[] $hotels */
        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();

        foreach($hotels as $hotel) {
            $menu['Hotels']->addChild($hotel->getName(), [
                'route' => 'app_hotel_show',
                'routeParameters' => ['id' => $hotel->getId()]
            ]);
        }

        $menu->addChild('Login', ['route' => 'login']);
        $menu->addChild('Logout', ['route' => 'app_logout']);
        $menu->addChild('Registration', ['route' => 'app_register']);

        return $menu;
    }
}