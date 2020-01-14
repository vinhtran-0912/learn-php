<?php

namespace App\ElasticSearch;

use DateTime;
use ScoutElastic\SearchRule;
use Illuminate\Support\Facades\Auth;

/**
 * class UserSearchRule
 */
class UserSearchRule extends SearchRule
{
    protected $rules = [];

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        if (isset($this->builder->query['email'])) {
            $this->handleByEmail();
        }

        return $this->rules;
    }

    /**
     * Handle by title
     *
     * @return array
     */
    public function handleByTitle()
    {
        $tmpRule['must'][]['match_phrase'] = [
            'email' => $this->builder->query['email'],
        ];

        $this->rules = array_merge_recursive($this->rules, $tmpRule);
    }
}
