<?php
namespace App\Services;

class View
{
	public $template = '';
	public $args = [];

    /**
     * View constructor.
     * @param $template
     * @param array $args
     */
    public function __construct($template, $args=[])
	{
        $this->args = $args;
		$this->template = $_SERVER['DOCUMENT_ROOT'].'/resource/views/'.$template.'.php';
	}

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value):void
	{
		$this->args[$name] = $value;
	}

    /**
     * @return string
     */
    public function display():string
    {
		extract($this->args);

		return require $this->template;
	}
}