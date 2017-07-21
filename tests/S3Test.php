<?php

use PHPUnit\Framework\TestCase;
use Lib\S3;

class S3Test extends TestCase
{
    public function testUpload()
    {
        $s3 = $this->getMockBuilder(S3::class)
                   ->setConstructorArgs(['sample.txt'])
                   ->getMock();

        $s3->expects($this->once())
           ->method('upload');

        $s3->upload();
    }
}
