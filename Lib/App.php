<?php

namespace Lib;

class App
{
    public function main()
    {
        // find out how many databases
        $env = new Env;
        $envs = $env->getEnvs();

        foreach ($envs['databases'] as $db_envs) {
            // backup mysql database
            $mysql = new Mysql($db_envs);
            $sql_file = $mysql->dump();

            // compress the sql file
            $tar = new Tar($sql_file);
            $tar_file = $tar->compress();

            // upload the file to S3
            $s3 = new S3($tar_file, $envs['s3']);
            $s3->upload();

            // cleanup
            exec('rm -Rf '.__DIR__.'/../storage/'.$tar_file);
            exec('rm -Rf '.__DIR__.'/../storage/backup');
        }
    }
}
