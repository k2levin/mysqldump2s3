<?php

namespace Lib;

class Tar
{
    protected $file;

    public function __construct(String $file)
    {
        $this->file = $file;
    }

    public function compress()
    {
        try {
            exec($this->getCommand());

            return $this->file;
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
            die();
        }
    }

    private function getCommand()
    {
        $zip_file = $this->file.'.tar.gz';
        $this->file = $zip_file;
        $storage_path = __DIR__.'/../storage';
        $command = "cd $storage_path && tar -czf $zip_file backup";

        return $command;
    }
}
