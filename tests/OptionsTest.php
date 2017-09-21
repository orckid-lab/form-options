<?php

namespace Tests;

use OrckidLab\FormOptions\Option;
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
		$this->assertTrue(Options::load()->setBasePath('custom-path')->base_path === 'custom-path');
	}

	/** @test */
	public function can_select_an_option_by_value()
	{
		$find = Options::load('titles')->find(2);

		$this->assertInstanceOf(Option::class, $find);

		$this->assertTrue($find->value == 2);
	}

	/** @test */
	public function can_verify_in_meta()
	{
		$find = Options::load('titles')->find(2);

		$this->assertInstanceOf(Option::class, $find);

		$this->assertTrue($find->inMeta('roles', 2));
	}

	/** @test */
	public function can_find_match_option_by_label()
	{
		$find = Options::load('titles')->find('Mr', 'label');

		$this->assertInstanceOf(Option::class, $find);

		$this->assertTrue($find->value == 1);
	}

	/** @test */
	public function can_find_match_option_by_meta()
	{
		$options = Options::load('titles')->filterMetaIn('roles', 2);

		$this->assertTrue(count($options) === 2);

		foreach($options as $option){
			$this->assertInstanceOf(Option::class, $option);
		}
	}

	/** @test */
	public function can_find_multiple_values()
	{
		$options = Options::load('titles')->find([1, 3]);

		$this->assertTrue(count($options) === 2);

		$this->assertTrue($options[0]->value == 1);

		$this->assertTrue($options[1]->value == 3);
	}

	/** @test */
	public function can_find_option_with_specific_meta_value()
	{
		$value = 'dr.jpg';

		$option = Options::load('titles-2')->findMeta('image', $value);

		$this->assertInstanceOf(Option::class, $option);

		$this->assertTrue($option->meta->image === $value);
	}

	/** @test */
	public function can_list_all_options_files_within_a_specified_path()
	{
		$files = Options::files('storage/app/options');

		$this->assertTrue(is_array($files));

		$this->assertTrue(is_array($files[0]));

		$this->assertTrue($files[0]['name'] == 'titles-2');
	}
}