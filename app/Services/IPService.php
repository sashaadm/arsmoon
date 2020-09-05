<?php


namespace App\Services;

use Sujip\Ipstack\Ipstack;

class IPService
{
    private $ipstack;


    /**
     * IPService constructor.
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $config = require 'config.php';

        $this->ipstack = new Ipstack($ip, $config['ipstackKey']);
    }

    /**
     * @return string
     */
    public function getContinentCode(){

        return $this->ipstack->continentCode();
    }

    /**
     * @return string
     */
    public function getCallingCode(){

        return $this->ipstack->resolve('location')['calling_code'];
    }
}