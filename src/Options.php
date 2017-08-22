<?php

namespace OrckidLab\FormOptions;

/**
 * Class FormOptions
 * @package OrckidLab\FormOptions
 */
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

		return json_encode($this->options);
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
	protected function loadOptions($name = null){
		if(!$name){
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
	protected function loadJsonFile($name){
		$path = $this->getJsonPath($name);

		if(!file_exists($path)){
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
	 * @param $json
	 * @return $this
	 */
	public function update($name, $json)
	{
		file_put_contents($this->getJsonPath($name), json_encode($json, JSON_PRETTY_PRINT));

		return $this;
	}

	/**
	 * @return static
	 */
	public static function instance()
	{
		return new static;
	}

	/**
	 * @param $attribute
	 * @return null
	 */
	public function __get($attribute)
	{
		if(isset($this->{$attribute})){
			return $this->{$attribute};
		}

		return null;
	}
}