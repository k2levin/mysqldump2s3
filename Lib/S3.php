<?php

namespace Lib;

use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class S3
{
    protected $file;
    protected $s3_envs;

    public function __construct(String $file, Array $s3_envs)
    {
        $this->file = $file;
        $env = new Env;
        $this->s3_envs = $s3_envs;
    }

    public function upload()
    {
        try {
            $s3 = new S3Client([
                'version'     => $this->s3_envs['version'],
                'region'      => $this->s3_envs['region'],
                'credentials' => $this->getS3Credentials(),
            ]);

            $s3->putObject([
                'Bucket'     => $this->s3_envs['bucket'],
                'Key'        => $this->file,
                'SourceFile' => __DIR__.'/../storage/'.$this->file,
            ]);

            echo 'Upload success!! '.$this->file."\n";
        } catch (S3Exception $e) {
            echo $e->getMessage()."\n";
            die();
        } catch (AwsException $e) {
            echo $e->getAwsRequestId()."\n";
            echo $e->getAwsErrorType()."\n";
            echo $e->getAwsErrorCode()."\n";
            die();
        }
    }

    private function getS3Credentials()
    {
        $credentials = [
            'key'    => $this->s3_envs['key'],
            'secret' => $this->s3_envs['secret'],
        ];

        return $credentials;
    }
}
