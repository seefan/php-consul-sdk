<?php

class catalog extends service
{
    public function __construct($base_url, $http)
    {
        parent::__construct($base_url, $http);
        $this->name = 'catalog';
    }
}