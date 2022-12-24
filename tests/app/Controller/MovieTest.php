<?php

namespace CodeIgniter;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class MovieTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testMovieList()
    {
        $result = $this->withURI('http://localhost:8080/movie')
            ->controller(\App\Controllers\Movie::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
    }
}