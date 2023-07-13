<?php

namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Exception\AwsException;
use App\Exceptions;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Log;
use Validator;



class AWSService
{

    public function __construct()
    {
        $this->status = 'status';
        $this->message = 'message';
        $this->code = 'status_code';
        $this->data = 'data';
        $this->total = 'total_count';
        
    }


    /**
     * Upload HLS files to AWS S3.
     *
     * @param array  $hlsFiles      Array of paths to the HLS files.
     * @param string $awsAccessKey  AWS access key.
     * @param string $awsSecretKey  AWS secret key.
     * @param string $awsRegion     AWS region.
     * @param string $awsBucket     AWS S3 bucket name.
     */
    function uploadToS3(array $hlsFiles, string $awsAccessKey, string $awsSecretKey, string $awsRegion, string $awsBucket)
    {

        Log::info("HLS = ". json_encode($hlsFiles, true));

        try {
            $s3 = new S3Client([
                'version' => 'latest',
                'region' => $awsRegion,
                'credentials' => [
                    'key' => $awsAccessKey,
                    'secret' => $awsSecretKey,
                ],
            ]);

            foreach ($hlsFiles as $hlsFile) {
                Log::info("HLSFile = ". json_encode($hlsFile, true));
                $filename = basename($hlsFile);
                Log::info("Filename = ". json_encode($filename, true));
                $s3->putObject([
                    'Bucket' => $awsBucket,
                    'Key' => $filename,
                    'SourceFile' => '/var/www/html/demo/HLS/'.$hlsFile,
                ]);
            }


        } 
        catch (S3Exception $e) 
        {
            echo $e->getMessage() . "\n";
        }
    }    
    
    


        
    /**
     * Upload a folder and its contents to AWS S3.
     *
     * @param string $folderPath    Path to the folder to be uploaded.
     * @param string $awsAccessKey  AWS access key.
     * @param string $awsSecretKey  AWS secret key.
     * @param string $awsRegion     AWS region.
     * @param string $awsBucket     AWS S3 bucket name.
     */
    function uploadFolderToS3(string $folderPath, string $awsAccessKey, string $awsSecretKey, string $awsRegion, string $awsBucket)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => $awsRegion,
            'credentials' => [
                'key' => $awsAccessKey,
                'secret' => $awsSecretKey,
            ],
        ]);

        $files = Storage::disk('local')->allFiles($folderPath);

        foreach ($files as $file) {
            $filePath = storage_path('app/' . $file);
            $relativePath = str_replace($folderPath, '', $file);

            $s3->putObject([
                'Bucket' => $awsBucket,
                'Key' => $relativePath,
                'SourceFile' => $filePath,
            ]);
        }
    }
        







    public function copyDirectoryContentsToS3($sourceDirectory, $s3Directory)
    {
        Log::info("source Directory = ".$sourceDirectory);
        Log::info("s3Directory = ".$s3Directory);
        $files = File::allFiles($sourceDirectory);
        $directories = File::directories($sourceDirectory);

        foreach ($files as $file) {

            try {
                Log::info("File = ".$file);
                $relativePath = $s3Directory . '/' . $file->getRelativePathname();
                Storage::disk('s3')->put($relativePath, file_get_contents($file->getPathname()));
            } catch (S3Exception $e) {
                // Handle specific S3 exception
                Log::info('S3Exception: ' . $e->getMessage());
                echo "S3Exception";
                // Additional error handling logic
            } catch (AwsException $e) {
                // Handle other AWS SDK exceptions
                Log::info('AwsException: ' . $e->getMessage());
                echo "AwsException";
                // Additional error handling logic
            } catch (\Exception $e) {
                // Handle generic exceptions
                Log::info('Exception: ' . $e->getMessage());
                echo "Exception";
                // Additional error handling logic
            }

        }

    }



    private function moveDirectoryToS3($sourceDirectory, $s3Directory)
    {
        $destinationDirectory = $s3Directory . '/' . basename($sourceDirectory);

        // Move the directory to S3
        Storage::disk('s3')->moveDirectory($sourceDirectory, $destinationDirectory);

        // Move subdirectories recursively
        $subdirectories = File::directories($sourceDirectory);
        foreach ($subdirectories as $subdirectory) {
            $this->moveDirectoryToS3($subdirectory, $destinationDirectory);
        }
    }




}
