<?php

namespace App\Model;

interface UserInterface
{
    public function getCreatedBy();
    public function setCreatedBy($user);
    public function getUpdatedBy();
    public function setUpdatedBy($user);
}