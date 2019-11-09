<?php


namespace App;


class ApiTokenGenerator
{
    /**
     * @var int
     */
    private $length;

    public function __construct($length = 16)
    {
        $this->length = $length;
    }

    public function generate()
    {
        return bin2hex(random_bytes($this->length));
    }
}
