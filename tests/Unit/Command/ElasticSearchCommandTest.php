<?php

namespace Tests\Unit\Command;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Console\Commands\ElasticSearchCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElasticSearchCommandTest extends TestCase
{
    /**
     * Run elasticsearch command successfully.
     *
     * @test
     *
     * @return void
     */
    public function runElasticsearchCommandCreateSuccessfully()
    {
        $this->artisan(
            'elastic:drop-index',
            [
                'index-configurator' => ElasticSearchCommand::CONFIGS['customer'],
            ]
        );

        $this->artisan('elasticsearch --all')
            ->expectsOutput('The customers index was created!')
            ->expectsOutput('The customers_write alias for the customers index was created!');
    }

    /**
     * Run elasticsearch command successfully.
     *
     * @test
     *
     * @return void
     */
    public function runElasticsearchCommandUpdateSuccessfully()
    {
        $this->artisan('elasticsearch --all');
        $this->artisan('elasticsearch --all')
            ->expectsOutput('The index address was deleted!')
            ->expectsOutput('The address index was created!');
    }

    /**
     * Run elasticsearch command successfully.
     *
     * @test
     *
     * @return void
     */
    public function runElasticsearchCommandForSingleModelSuccessfully()
    {
        $this->artisan(
            'elastic:drop-index',
            [
                'index-configurator' => ElasticSearchCommand::CONFIGS['customer'],
            ]
        );

        $this->artisan(
            'elasticsearch',
            [
                '--config' => ElasticSearchCommand::CONFIGS['customer'],
            ]
        )->expectsOutput('The customers index was created!')
        ->expectsOutput('The customers_write alias for the customers index was created!');
    }
}
