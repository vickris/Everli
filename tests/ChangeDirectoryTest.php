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

        $path = new ChangeDirectory("/234/b/c/d");
    }

    public function testMovingOneDirectroyUp()
    {
        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('..');

        $this->assertEquals("/a/b/c", $path->current_path);
    }

    public function testMovingOneDirectroyUpThenAnotherFolder()
    {
        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('../x');

        $this->assertEquals("/a/b/c/x", $path->current_path);
    }

    public function testMovingTwoDirectoriesUp()
    {
        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('../..');

        $this->assertEquals("/a/b", $path->current_path);
    }

    public function testMovingTwoDirectriesUpThenAnotherFolder()
    {
        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('../../x');

        $this->assertEquals("/a/b/x", $path->current_path);
    }

    public function testGettingToRootFolder()
    {
        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('../../../..');

        $this->assertEquals("/", $path->current_path);
    }

    public function testInvalidCDPathSupplied()
    {
        $this->expectException(InvalidDirectoryNameException::class);

        $path = new ChangeDirectory("/a/b/c/d");
        $path->cd('../123');
    }
}
