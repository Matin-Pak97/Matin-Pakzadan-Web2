<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Model\UserInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriber
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        TokenStorageInterface $tokenStorage
    )
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $user = $this->tokenStorage->getToken()->getUser();

        if($entity instanceof UserInterface){
            if($user instanceof User) {
                $entity->setCreatedBy($user);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $user = $this->tokenStorage->getToken()->getUser();

        if($entity instanceof UserInterface){
            if($user instanceof User) {
                $entity->setUpdatedBy($user);
            }
        }
    }
}
