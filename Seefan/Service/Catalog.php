<?php
namespace Seefan\Service;
class Catalog extends Service
{
    public function __construct($base_url, $http)
    {
        parent::__construct($base_url, $http);
        $this->name = 'catalog';
    }
}