<?php

namespace Tests;

use OrckidLab\FormOptions\Options;

class OptionsTest extends BaseTestCase
{
	/** @test */
	public function can_be_created()
	{
		$this->assertInstanceOf(Options::class, Options::load());
	}

	/** @test */
	public function get_returns_an_array()
	{
		$this->assertTrue(is_array(Options::load()->get()));
	}

	/** @test */
	public function load_accept_file_name()
	{
		$this->assertInstanceOf(Options::class, Options::load('titles'));
	}

	/** @expectedException \Exception */
	public function throws_error_if_file_doesnt_exist()
	{
		$this->expectException(Options::load('titles2'));
	}

	/** @test */
	public function can_return_json()
	{
		$this->assertJson(Options::load()->json('titles'));
	}

	/** @test */
	public function can_overide_base_path()
	{
		$this->assertTrue((new Options)->setBasePath('custom-path')->base_path === 'custom-path');
	}

	/** @test */
	public function can_select_an_option_by_value()
	{
		$this->assertTrue(Options::load('titles')->select(2)->value == 2);
	}

	/** @test */
	public function can_verify_in_meta()
	{
		$this->assertTrue(Options::load('titles')->select(2)->inMeta('roles', 2));
	}
}