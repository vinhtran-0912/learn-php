<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ElasticSearchCommand extends Command
{
    const MASTER_CONFIGS = [
        'user' => 'App\\ElasticSearch\\AddressIndexConfigurator',
    ];

    const MASTER_MODELS = [
        'user' => 'App\\Address',
    ];

    const CONFIGS = [
        'user' => 'App\\ElasticSearch\\UserIndexConfigurator',
    ];

    const MODELS = [
        'user' => 'App\\Models\\User',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch
                            {--all : Apply for all index.}
                            {--config= : Config for create or update index.}
                            {--master : Apply for master index.}
                            {--import : Import exists data.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create index & update mapping';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($config = $this->option('config')) {
            $this->createOrUpdateIndex($config);

            $configs = array_merge(self::MASTER_CONFIGS, self::CONFIGS);
            $models = array_merge(self::MASTER_MODELS, self::MODELS);

            $configKey = array_keys($configs, $config)[0];
            $model = $models[$configKey];
            $this->updateMapping($model);

            if ($this->option('import')) {
                $this->importData($model);
            }
        } else {
            $configs = self::CONFIGS;
            $models = self::MODELS;

            if ($this->option('all')) {
                $configs = array_merge(self::MASTER_CONFIGS, $configs);
                $models = array_merge(self::MASTER_MODELS, $models);
            } elseif ($this->option('master')) {
                $configs = self::MASTER_CONFIGS;
                $models = self::MASTER_MODELS;
            }

            foreach ($configs as $config) {
                $this->createOrUpdateIndex($config);
            }

            foreach ($models as $model) {
                $this->updateMapping($model);

                if ($this->option('import')) {
                    $this->importData($model);
                }
            }
        }
    }

    /**
     * Create or update index configurator
     *
     * @param  mixed $config
     *
     * @return void
     */
    public function createOrUpdateIndex($config)
    {
        try {
            $this->call('elastic:create-index', ['index-configurator' => $config]);
        } catch (\Exception $e) {
            $this->call('elastic:drop-index', ['index-configurator' => $config]);
            $this->call('elastic:create-index', ['index-configurator' => $config]);
        }
    }

    /**
     * Update model mapping
     *
     * @param  mixed $model
     *
     * @return void
     */
    public function updateMapping($model)
    {
        try {
            $this->call('elastic:update-mapping', ['model' => $model]);
        } catch (\Exception $e) {
            $modelKey = array_keys(self::MODELS, $model)[0];
            $config = self::CONFIGS[$modelKey];
            $this->call('elastic:drop-index', ['index-configurator' => $config]);
            $this->call('elastic:create-index', ['index-configurator' => $config]);
            report($e);
        }
    }

    /**
     * Import data from db to elasticsearch
     *
     * @param  mixed $model
     *
     * @return void
     */
    public function importData($model)
    {
        $this->call('scout:import', ['model' => $model]);
    }
}
