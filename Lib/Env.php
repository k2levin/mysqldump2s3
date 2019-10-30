<?php

namespace Lib;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Env
{
    protected $file_path;

    public function __construct()
    {
        $this->file_path = __DIR__.'/../env.yaml';
    }

    /**
     * Get environments
     * @return Array
     */
    public function getEnvs()
    {
        try {
            $envs = Yaml::parseFile($this->file_path);
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
            die();
        }

        return $envs;
    }
}
