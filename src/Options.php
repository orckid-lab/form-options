<?php

namespace OrckidLab\FormOptions;

/**
 * Class Options
 * @package OrckidLab\FormOptions
 */
/**
 * Class Options
 * @package OrckidLab\FormOptions
 */
class Options
{
	/**
	 * @var string
	 */
	protected $base_path = 'storage/app/options';

	/**
	 * @var array
	 */
	protected $options = [];

	/**
	 * Set base path where to fetch the file.
	 *
	 * @param $path
	 * @return $this
	 */
	public function setBasePath($path)
	{
		$this->base_path = $path;

		return $this;
	}

	/**
	 * Returns array of options Object.
	 *
	 * @param null $name
	 * @return array
	 */
	public function get($name = null)
	{
		$this->loadOptions($name);

		return $this->options;
	}

	/**
	 * Returns JSON of $options.
	 *
	 * @param null $name
	 * @return string
	 */
	public function json($name = null)
	{
		$this->loadOptions($name);

		return json_encode($this->options, JSON_PRETTY_PRINT);
	}

	/**
	 * Load options.
	 *
	 * @param null $name
	 * @return mixed
	 */
	public static function load($name = null)
	{
		$instance = self::getInstance();

		return $instance->loadOptions($name);
	}

	/**
	 * Determine how to load the options.
	 *
	 * @param null $name
	 * @return $this
	 */
	protected function loadOptions($name = null)
	{
		if (!$name) {
			return $this;
		}

		$this->loadJsonFile($name);

		return $this;
	}

	/**
	 * Load JSON file relative to the $name.
	 *
	 * @param $name
	 * @return $this
	 * @throws \Exception
	 */
	protected function loadJsonFile($name)
	{
		$path = $this->getJsonPath($name);

		if (!file_exists($path)) {
			throw new \Exception('The file ' . $path . ' doest not exist.');
		}

		$this->options = json_decode(file_get_contents($path));

		return $this;
	}

	/**
	 * @return static
	 */
	protected static function getInstance()
	{
		return new static;
	}

	/**
	 * Guess the location of the JSON to load.
	 *
	 * @param $name
	 * @return string
	 */
	protected function getJsonPath($name)
	{
		return $this->base_path . '/' . $name . '.json';
	}

	/**
	 * Update the JSON file.
	 *
	 * @param $name
	 * @param $data
	 * @param null $meta_factory
	 * @return $this
	 */
	public function update($name, $data, $meta_factory = null)
	{
		file_put_contents($this->getJsonPath($name), $this->format($data, $meta_factory));

		return $this;
	}

	/**
	 * @param $value
	 * @param string $attribute
	 * @return array|Option
	 */
	public function find($value, $attribute = 'value')
	{
		if (is_array($value)) {
			return $this->filter($value, $attribute);
		}

		$match = null;

		foreach ($this->options as $option) {
			if ($option->{$attribute} != $value) {
				continue;
			}

			$match = $option;

			break;
		}

		return $match ? Option::parse($match) : $match;
	}

	/**
	 * @param $value
	 * @param string $attribute
	 * @return array
	 */
	public function filter($value, $attribute = 'value')
	{
		$is_array = is_array($value);

		return array_values(
			array_filter(
				array_map(function ($option) use ($attribute, $value, $is_array) {
					if (
						($is_array && in_array($option->value, $value))
						|| $option->{$attribute} == $value
					) {
						return Option::parse($option);
					}

					return null;
				}, $this->options)
			)
		);
	}

	/**
	 * @param $attribute
	 * @param $value
	 * @return array
	 */
	public function filterMetaIn($attribute, $value)
	{
		return array_values(
			array_filter(
				array_map(function ($option) use ($attribute, $value) {
					if (in_array($value, $option->meta->{$attribute})) {
						return Option::parse($option);
					}

					return null;
				}, $this->options)
			)
		);
	}

	/**
	 * @param $attribute
	 * @param $value
	 * @return mixed|null|static
	 */
	public function findMeta($attribute, $value)
	{
		$match = null;

		foreach ($this->options as $option) {
			if ($option->meta->{$attribute} != $value) {
				continue;
			}

			$match = $option;

			break;
		}

		return $match ? Option::parse($match) : $match;
	}

	/**
	 * @param $array
	 * @param $meta_factory
	 * @return string
	 */
	public function format($array, $meta_factory)
	{
		$options = array_map(function ($item) use ($meta_factory) {
			return Option::parse($item, $meta_factory)->toArray();
		}, $array);

		return json_encode($options, JSON_PRETTY_PRINT);
	}

	/**
	 * @param $attribute
	 * @return null
	 */
	public function __get($attribute)
	{
		if (isset($this->{$attribute})) {
			return $this->{$attribute};
		}

		return null;
	}
}