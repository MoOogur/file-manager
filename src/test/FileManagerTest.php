<?php

use FileManager\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    public function testUniqueness()
    {
        $firstCall = FileManager::getInstance('/profiles/m/mo/moo/moogur/test-app.zzz.com.ua');
        $secondCall = FileManager::getInstance('/profiles/m/mo/moo/moogur/test-app.zzz.com.ua');

        $this->assertInstanceOf(FileManager::class, $firstCall);
        $this->assertSame($firstCall, $secondCall);
    }
}

