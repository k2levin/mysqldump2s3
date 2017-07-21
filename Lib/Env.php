<?php

namespace Lib;

use Exception;

class Env
{
    protected $file_path;

    public function __construct()
    {
        if (!isset($_ENV['ENV'])) {
            $this->file_path = __DIR__.'/../.env';
        } else if (isset($_ENV['ENV']) && $_ENV['ENV'] === 'testing') {
            $this->file_path = __DIR__.'/../.env.example';
        } else {
            $this->file_path = '';
        }
    }

    /**
     * Get environments
     * @return Array
     */
    public function getEnvs()
    {
        $envs = parse_ini_file($this->file_path);

        if (!$envs) {
            throw new Exception('Invalid environment in file .env');
        }

        $all_envs = $this->getAllEnvs($envs);

        return $all_envs;
    }

    private function getAllEnvs($envs)
    {
        $all_envs = [];

        // limit number of database to 5
        for ($i = 1; $i <= 5; $i++) {
            $results = array_filter(
                $envs,
                function ($key) use($i) {
                    $search = 'DB_'.$i.'_';
                    return preg_match("/^$search/", $key);
                },
                ARRAY_FILTER_USE_KEY
            );
            $new_results = [];
            foreach ($results as $key => $result) {
                $new_results[substr($key, 5, strlen($key)-4+1)] = $result;
            }
            $all_envs['DB_'.$i] = $new_results;
        }

        $all_envs['S3'] = array_filter(
            $envs,
            function ($key) {
                return preg_match('/^S3_/', $key);
            },
            ARRAY_FILTER_USE_KEY
        );

        return $all_envs;
    }
}
