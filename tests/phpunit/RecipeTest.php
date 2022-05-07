<?php

namespace MikeMadison13\BltLando\Tests;

use MikeMadison13\BltLando\Tests\TestBase;

class RecipeTest extends TestBase
{

    public function testRecipe()
    {
        $bin = realpath(__DIR__ . '/../../bin/blt');
        $output = shell_exec("$bin recipes:vm:lando");

        //Confirm that the recipe ran as expected.
        $this->assertEquals(0, $output);
    }
}
