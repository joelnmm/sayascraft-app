<?php

/**
 * User: joelm
 * Date: 10/11/22
 * Time: 14:01
 */

namespace App\Providers\AWS;

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
Use Aws\Credentials\Credentials;
use App\Models\Parametros;

class S3 {

    public static function getS3Client(){
        $accessKey = Parametros::where('parNombre', 'accessKey')->first();
        $secretKey = Parametros::where('parNombre', 'secretKey')->first();
        
        $credentials = new Credentials($accessKey->parValor, $secretKey->parValor);

        return new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);

    }

    public static function subirArchivoS3($file,$fileName) {

        $s3Client = self::getS3Client();
        $bucketName = 'braceletsapp-images';
        $name = $fileName;
        $ext = explode('.', $name);
        $dateTime = date("Y-m-d H:i:s");
        $num_random = (string) rand(1000000, 1000000000);
        $filename = $bucketName . '_' . strtotime($dateTime) . '_' . $num_random . '.' . $name;

        $content = '';
        switch ($ext[1]) {
            case 'pdf':
                $content = 'application/pdf';
                break;
            case 'png':
                $content = 'application/image';
                break;
            case 'jpg':
                $content = 'application/image';
                break;
        }

        try {
            $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $filename,
                'Body' => fopen($file, 'r'),
                'ACL' => 'public-read',
                'ContentType' => $content,
                'StorageClass' => 'REDUCED_REDUNDANCY',
            ]);

            $url = 'https://braceletsapp-images.s3.amazonaws.com/'. $filename;
            return $url;

        } catch (S3Exception $e) {
            return json_encode($e);
        }

    }

    public static function eliminarArchivoS3($filenameUrl){
        
        $s3Client = self::getS3Client();
        $bucketName = 'braceletsapp-images';
        $file = explode('/',$filenameUrl)[3];

        try {
            $s3Client->deleteObject(array(
                'Bucket' => $bucketName,
                'Key'    => $file
            ));
            return true;

        } catch (S3Exception $e) {
            return json_encode($e);
        }
    }

}
