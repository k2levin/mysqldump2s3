<?php

use PHPUnit\Framework\TestCase;
use Lib\Env;

class EnvTest extends TestCase
{
    public function test()
    {
        $env = new Env();
        $envs = $env->getEnvs();

        $this->assertArrayHasKey('S3', $envs);
        $this->assertArrayHasKey('DB_1', $envs);
        $this->assertArrayHasKey('DB_2', $envs);
    }
}
