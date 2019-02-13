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

    public function getById($applicationId)
    {
        $partner = Partner::find((int)$applicationId);
        $partner->apps->toArray();
        $partner->themes->toArray();
        return $partner->toArray();
    }
}