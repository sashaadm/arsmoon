<?php


namespace App\Models;


abstract class BaseModel
{
    public $fields;

    public function __construct(array $fields = [])
    {
        if(count($fields)){
            $this->fields = $fields;
        }

    }


    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if(isset($this->fields[$name])){
            return $this->fields[$name];

        }
        return null;
    }

}