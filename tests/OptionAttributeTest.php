<?php

namespace Tests;

use OrckidLab\FormOptions\Options;

class OptionAttributeTest extends BaseTestCase
{
	/** @test */
	public function titles_option_contain_label()
	{
		$option = Options::load('titles')->get()[0];

		$this->assertObjectHasAttribute('label', $option);
	}

	/** @test */
	public function titles_option_contain_value()
	{
		$option = Options::load('titles')->get()[0];

		$this->assertObjectHasAttribute('value', $option);
	}

	/** @test */
	public function titles_option_contain_enable()
	{
		$option = Options::load('titles')->get()[0];

		$this->assertObjectHasAttribute('enable', $option);
	}

	/** @test */
	public function titles_option_contain_meta()
	{
		$option = Options::load('titles')->get()[0];

		$this->assertObjectHasAttribute('meta', $option);
	}
}