<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
	public function setUp()
	{
		require __DIR__ . './../vendor/autoload.php';
	}
}