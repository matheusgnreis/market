<?php
namespace Market\Controller;
use Market\Model\Partner;
use Market\Services\Database;

class PartnerController
{
    public function __construct()
    {
        new Database();
    }

    public function getById($partnerId)
    {
        $partner = Partner::find((int)$partnerId);
        $partner->applications->toArray();
        $partner->themes->toArray();
        return $partner->toArray();
    }
}