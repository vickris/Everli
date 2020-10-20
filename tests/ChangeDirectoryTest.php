<?php

namespace Everli\Test;

use Everli\ChangeDirectory;
use PHPUnit\Framework\TestCase;
use Everli\Exceptions\InvalidDirectoryNameException;

class ChangeDirectoryTest extends TestCase
{
    public function testInvalidInitialPathSupplied()
    {
        $this->expectException(InvalidDirectoryNameException::class);

        $path = new ChangeDirectory('/234/b/c/d');
    }

    public function testMovingOneDirectroyUp()
    {
        $path->cd('../../../../d');
        echo $path->current_path;
    }

    public function testMovingOneDirectroyUpThenAnotherFolder()
    {
        # code...
    }

    public function testMovingTwoDirectoriesUp()
    {
        # code...
    }

    public function testMovingTwoDirectriesUpThenAnotherFolder()
    {
        # code...
    }

    public function testGettingToRootFolder()
    {
        # code...
    }

    public function testInvalidCDPathSupplied()
    {
        # code...
    }
}
