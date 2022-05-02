<?php

namespace MikeMadison13\BltLando\Tests;

use MikeMadison13\BltLando\Tests\TestBase;

class LoadTest extends TestBase
{
  /**
   * Tests to Ensure that the Recipe is Loaded by BLT.
   *
   * @dataProvider getValueProvider
   */
    public function testRecipeAutoloading($expected)
    {
        $bin = realpath(__DIR__ . '/../../bin/blt');
        $output = shell_exec("$bin blt");
        $this->assertStringContainsString($expected, $output);
    }

    public function getValueProvider()
    {
        return [
        ["recipes:vm:lando"],
        ];
    }
}
