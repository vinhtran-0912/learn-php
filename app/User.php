<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use ScoutElastic\Searchable;
use App\ElasticSearch\UserSearchRule;
use App\ElasticSearch\UserIndexConfigurator;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Searchable;

    protected $indexConfigurator = UserIndexConfigurator::class;

    /**
     * Search rule array
     *
     * @var array
     */
    protected $searchRules = [
        UserSearchRule::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mapping array
     *
     * @var array
     */
    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'long',
            ],
            'email' => [
                'type' => 'text',
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy/MM/dd',
            ],
        ],
    ];

    /**
     * Add field for search array
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => Carbon::parse($this->created_at)->format('Y/m/d'),
        ];

        return $array;
    }
}
