<?php

use PHPUnit\Framework\TestCase;
use Lib\Env;

class EnvTest extends TestCase
{
    public function test()
    {
        $env = new Env();
        $envs = $env->getEnvs();

        $this->assertArrayHasKey('s3', $envs);
        $this->assertArrayHasKey('databases', $envs);
    }
}
