<?php

namespace OrckidLab\FormOptions;

/**
 * Class Option
 * @package OrckidLab\FormOptions
 */
class Option
{
	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $value;

	/**
	 * @var bool
	 */
	protected $enable = true;

	/**
	 * @var null|\stdClass
	 */
	protected $meta = null;

	/**
	 * Option constructor.
	 * @param string $label
	 * @param string $value
	 * @param bool $enable
	 * @param null $meta
	 */
	public function __construct($label = '', $value = '', $enable = true, $meta = null)
	{
		$this->label = $label;

		$this->value = $value;

		$this->enable = $enable;

		$this->meta = $meta ? $meta : new \stdClass();
	}

	/**
	 * @param $object
	 * @return static
	 */
	public static function parse($object)
	{
		return new static($object->label, $object->value, $object->enable, $object->meta);
	}

	/**
	 * @param $attribute
	 * @param $value
	 * @return bool
	 */
	public function inMeta($attribute, $value)
	{
		return in_array($value, $this->meta->{$attribute});
	}

	/**
	 * @param $attribute
	 * @return null
	 */
	public function __get($attribute)
	{
		return isset($this->{$attribute}) ? $this->{$attribute} : null;
	}
}