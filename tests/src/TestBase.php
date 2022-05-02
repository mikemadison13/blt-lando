<?php

namespace MikeMadison13\BltLando\Tests;

use Symfony\Component\Console\Application;
use PHPUnit\Framework\TestCase;

/**
 * Class BltTestBase.
 *
 * Base class for all tests that are executed for BLT itself.
 */
abstract class TestBase extends TestCase
{

    /** @var Application */
    protected $application;

    /**
     * {@inheritdoc}
     *
     * @see https://symfony.com/doc/current/console.html#testing-commands
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->application = new Application();
    }
}
