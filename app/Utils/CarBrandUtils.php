<?php

namespace App\Utils;

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use RuntimeException;

class CarBrandUtils
{
    private string $jsonPath;
    protected static CarBrandUtils $carBrandUtils;

    public function __construct()
    {
        $this->jsonPath = public_path('assets/json/car-data.json');
    }

    public static function getInstance(): CarBrandUtils
    {
        return self::$carBrandUtils;
    }

    /**
     * @param string $brandName brand name should be in lowercase
     * @return string|null returns logo url
     * @throws FileNotFoundException
     */
    public function getCarThumbnail(string $brandName): ?string
    {
        if (!File::exists($this->jsonPath)) {
            throw new FileNotFoundException('File not found');
        }

        $jsonContent = File::get($this->jsonPath);
        $carData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON format');
        }

        $filteredCarData = array_filter($carData, fn($car) => strtolower($car['slug'] === strtolower($brandName)));

        $car = array_values($filteredCarData)[0] ?? null;

        return $car['image']['thumb'] ?? null;
    }
}
