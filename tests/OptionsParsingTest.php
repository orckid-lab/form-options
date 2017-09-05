<?php

namespace Tests;

use OrckidLab\FormOptions\Options;

class OptionsParsingTest extends BaseTestCase
{
	/** @test */
	public function can_format_and_accept_meta_factory()
	{
		$data = [
			[
				'label' => 'Mr',
				'value' => 1,
				'meta' => [
					'roles' => [],
				]
			],
			[
				'label' => 'Mrs',
				'value' => 2,
			],
			[
				'label' => 'Dr',
				'value' => 3,
				'meta' => [
					'roles' => [1, 2]
				]
			]
		];

		$expected = [
			[
				'label' => 'Mr',
				'value' => 1,
				'enable' => true,
				'meta' => [
					'roles' => []
				]
			],
			[
				'label' => 'Mrs',
				'value' => 2,
				'enable' => true,
				'meta' => [
					'roles' => []
				]
			],
			[
				'label' => 'Dr',
				'value' => 3,
				'enable' => true,
				'meta' => [
					'roles' => [1, 2]
				]
			]
		];

		$formatted = Options::load()->format($data, function () {
			return [
				'roles' => []
			];
		});

		$manual = json_encode($expected, JSON_PRETTY_PRINT);

		$this->assertTrue($formatted == $manual);
	}

	/** @test */
	public function can_update()
	{
		$data = [
			[
				'label' => 'Mr',
				'value' => 1,
			],
			[
				'label' => 'Mrs',
				'value' => 2,
				'meta' => [
					'roles' => [2]
				]
			],
			[
				'label' => 'Dr',
				'value' => 3,
				'enable' => true,
				'meta' => [
					'roles' => [1, 2]
				]
			]
		];

		$expected = [
			[
				'label' => 'Mr',
				'value' => 1,
				'enable' => true,
				'meta' => [
					'roles' => []
				]
			],
			[
				'label' => 'Mrs',
				'value' => 2,
				'enable' => true,
				'meta' => [
					'roles' => [2]
				]
			],
			[
				'label' => 'Dr',
				'value' => 3,
				'enable' => true,
				'meta' => [
					'roles' => [1, 2]
				]
			]
		];

		Options::load()
			->update('titles', $data, function(){
				return [
					'roles' => []
				];
			});

		$retrieved = Options::load()->json('titles');

		$this->assertTrue($retrieved == json_encode($expected, JSON_PRETTY_PRINT));
	}
}