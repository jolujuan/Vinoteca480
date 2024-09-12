<?php

namespace App\Tests\Service;

use App\Service\WineService;
use App\Repository\WineRepository;
use PHPUnit\Framework\TestCase;

class WineServiceTest extends TestCase
{
    private WineService $wineService;
    private WineRepository $wineRepository;

    protected function setUp(): void
    {
        $this->wineRepository = $this->createMock(WineRepository::class);

        $this->wineService = new WineService($this->wineRepository);
    }

    public function testFetchWinesMeasurements()
    {
        $wineData = [
            ['id' => 1, 'name' => 'Chardonnay', 'year' => 2020],
            ['id' => 2, 'name' => 'Merlot', 'year' => 2019]
        ];

        $this->wineRepository->method('findAll')->willReturn($wineData);

        $result = $this->wineService->fetchWinesMeasurements();
        $this->assertEquals($wineData, $result);
    }
}
