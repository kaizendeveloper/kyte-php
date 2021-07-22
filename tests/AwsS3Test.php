<?php
namespace Kyte\Test;

use PHPUnit\Framework\TestCase;

class AwsS3Test extends TestCase
{

    public function testCreateBucket() {
        $credential = new \Kyte\Aws\Credentials('us-east-1');
        $this->assertIsObject($credential);

        // create s3 client for private bucket
        $s3 = new \Kyte\Aws\S3($credential, AWS_PRIVATE_BUCKET_NAME);
        $this->assertIsObject($s3);

        $this->assertTrue($s3->createBucket());

        return $s3;
    }

    // add file

    // remove file

    public function testDeleteBucket() {
        $credential = new \Kyte\Aws\Credentials('us-east-1');
        $this->assertIsObject($credential);
        
        // create s3 client for private bucket
        $s3 = new \Kyte\Aws\S3($credential, AWS_PRIVATE_BUCKET_NAME);
        $this->assertIsObject($s3);

        $this->assertTrue($s3->deleteBucket());
    }
}

?>  