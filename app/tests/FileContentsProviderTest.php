<?php

declare(strict_types=1);

namespace App\Tests;

use App\Feature\File\Entity\File;
use App\Feature\File\Enum\FileContentDeliveryEnum;
use App\Feature\File\Enum\FileProviderEnum;
use App\Feature\File\Provider\FileContentsProvider;
use App\Feature\File\Repository\FileRepository;
use DataFixtures\FileFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileContentsProviderTest extends KernelTestCase
{
    private FileContentsProvider $fileContentsProvider;
    private FileRepository $fileRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->fileContentsProvider = static::getContainer()->get(FileContentsProvider::class . '.test');
        $this->fileRepository = static::getContainer()->get(FileRepository::class);

        $databaseTool->loadFixtures([
            FileFixtures::class,
        ]);
    }

    public function testGetFileContentsNotNull()
    {
        $file = $this->fileRepository->find(1);
        $contents = $this->fileContentsProvider->getFileContents($file);

        $this->assertNotNull($contents);
        $this->assertEquals(FileContentDeliveryEnum::Resource, $contents->getContentDelivery());
        $this->assertEquals('https://rickandmortyapi.com/api/character/avatar/1.jpeg', $contents->getContents());
    }

    public function testGetFileContentsNull()
    {
        $file = new File();
        $file->setProvider(FileProviderEnum::Image);
        $contents = $this->fileContentsProvider->getFileContents($file);

        $this->assertNull($contents);
    }
}
