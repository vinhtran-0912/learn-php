<?php

namespace App\ElasticSearch;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

/**
 * class UserIndexConfigurator
 */
class UserIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $name = 'user';
}
