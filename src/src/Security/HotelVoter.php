<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class HotelVoter extends Voter
{
    const CREATE = 'CREATE';
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::CREATE || $attribute === self::VIEW || $attribute === self::EDIT || $attribute === self::DELETE;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($attribute == self::VIEW) {
            return true;
        }

        $user = $token->getUser();
        if(is_null($user)) {
            return false;
        }

        if ($attribute === self::CREATE) {
            if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
                return true;
            } else if (in_array(User::ROLE_HOTEL_OWNER, $user->getRoles())) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array(User::ROLE_ADMIN, $user->getRoles()) || in_array(User::ROLE_EDITOR, $user->getRoles())) {
                return true;
            } else if (in_array(User::ROLE_HOTEL_OWNER, $user->getRoles()) && $user === $subject->getCreatedBy()) {
                return true;
            } else {
                return false;
            }
        }
    }
}