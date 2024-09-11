<?php

namespace App\Service;

use App\Repository\WineRepository;

class WineService
{
    private WineRepository $wineRepository;

    public function __construct(WineRepository $wineRepository)
    {
        $this->wineRepository = $wineRepository;
    }

    public function fetchWinesMeasurements(): array
    {
        return $this->wineRepository->findAll();
    }
}