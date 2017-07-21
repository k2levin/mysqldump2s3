<?php

namespace Lib;

use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class S3
{
    protected $file;
    protected $envs;

    public function __construct(String $file)
    {
        $this->file = $file;
        $env = new Env;
        $this->envs = $env->getEnvs()['S3'];
    }

    public function upload()
    {
        try {
            $s3 = new S3Client([
                'version'     => $this->envs['S3_VERSION'],
                'region'      => $this->envs['S3_REGION'],
                'credentials' => $this->getS3Credentials(),
            ]);

            $s3->putObject([
                'Bucket'     => $this->envs['S3_BUCKET'],
                'Key'        => $this->file,
                'SourceFile' => __DIR__.'/../storage/'.$this->file,
            ]);

            echo 'Upload success!! '.$this->file."\n";
        } catch (S3Exception $e) {
            echo $e->getMessage()."\n";
        } catch (AwsException $e) {
            echo $e->getAwsRequestId()."\n";
            echo $e->getAwsErrorType()."\n";
            echo $e->getAwsErrorCode()."\n";
        }
    }

    private function getS3Credentials()
    {
        $credentials = [
            'key'    => $this->envs['S3_KEY'],
            'secret' => $this->envs['S3_SECRET'],
        ];

        return $credentials;
    }
}
