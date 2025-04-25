<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use App\Utils\CarBrandUtils;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CarBrandUtilsTest extends TestCase
{
    private CarBrandUtils $carBrandUtils;

    protected function setUp(): void
    {
        parent::setUp();
        $this->carBrandUtils = new CarBrandUtils();
    }

    public function testGetCarThumbnailWithValidBrandName()
    {
        // Mock the File::exists and File::get methods
        File::shouldReceive('exists')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(true);

        File::shouldReceive('get')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(json_encode([
                [
                    "name" => "ABT",
                    "slug" => "abt",
                    "image" => [
                        "thumb" => "https://raw.githubusercontent.com/filippofilip95/car-logos-dataset/master/logos/thumb/abt.png"
                    ]
                ]
            ]));

        // Test with a valid brand name
        $thumbnail = $this->carBrandUtils->getCarThumbnail('ABT');
        $this->assertEquals("https://raw.githubusercontent.com/filippofilip95/car-logos-dataset/master/logos/thumb/abt.png", $thumbnail);
    }

    public function testGetCarThumbnailWithInvalidBrandName()
    {
        // Mock the File::exists and File::get methods
        File::shouldReceive('exists')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(true);

        File::shouldReceive('get')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(json_encode([
                [
                    "name" => "ABT",
                    "slug" => "abt",
                    "image" => [
                        "thumb" => "https://raw.githubusercontent.com/filippofilip95/car-logos-dataset/master/logos/thumb/abt.png"
                    ]
                ]
            ]));

        // Test with an invalid brand name
        $thumbnail = $this->carBrandUtils->getCarThumbnail('NonExistentBrand');
        $this->assertEquals("Thumbnail not found", $thumbnail);
    }

    public function testGetCarThumbnailFileNotFound()
    {
        // Mock the File::exists method to return false
        File::shouldReceive('exists')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(false);

        $this->expectException(FileNotFoundException::class);

        $this->carBrandUtils->getCarThumbnail('ABT');
    }

    public function testGetCarThumbnailInvalidJsonFormat()
    {
        // Mock the File::exists and File::get methods
        File::shouldReceive('exists')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn(true);

        File::shouldReceive('get')
            ->once()
            ->with(public_path('assets/json/car-data.json'))
            ->andReturn('invalid json');

        $this->expectException(\RuntimeException::class);

        $this->carBrandUtils->getCarThumbnail('ABT');
    }
}
