<?php

use PHPUnit\Framework\TestCase;

class TarTest extends TestCase
{
    public function testCompress()
    {
        $file = 'test.txt';
        $zip_file = 'test.txt.tar.gz';
        $content1 = 'qwerty123';

        // create text file
        exec('mkdir '.__DIR__.'/../storage/backup');
        file_put_contents(__DIR__.'/../storage/backup/'.$file, $content1);

        // compress file
        $lib = new \Lib\Tar($file);
        $lib->compress();

        // decompress file
        exec("cd ".__DIR__."/../storage && tar -xzf $zip_file");

        // read text file
        $content2 = file_get_contents(__DIR__.'/../storage/backup/test.txt');

        // cleanup
        exec('rm -Rf '.__DIR__.'/../storage/backup');
        unlink(__DIR__.'/../storage/'.$zip_file);

        $this->assertEquals($content1, $content2);
    }
}
