<?php
namespace Seefan\Service;
class Checks extends Service
{
    public function __construct($base_url, $http)
    {
        parent::__construct($base_url, $http);
        $this->name = 'checks';
    }
}