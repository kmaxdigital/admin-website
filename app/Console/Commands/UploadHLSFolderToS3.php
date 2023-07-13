<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CommonService;
use App\Services\AWSService;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Log;

class UploadHLSFolderToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature                            = 'Video:UploadFolderToS3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description                          = 'This Command will send all the folder to S3 bucket...';


    public function __construct()
    {
        parent::__construct();
        $this->status                               = 'status';
        $this->message                              = 'message';
        $this->code                                 = 'status_code';
        $this->data                                 = 'data';
        $this->total                                = 'total_count';
        $this->commonSer                            = new CommonService();
        $this->awsSer                               = new AWSService();

        
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $videoDetails                               = $this->commonSer->getVideoDetailsForS3();

        if($videoDetails[$this->status])
        {

            $environment                            = env('APP_ENV');
        
            $s3Directory                            = ($environment !== 'production') ? 'stage/' : 'video-files/';

            $video_id                               = $videoDetails[$this->data]->id;
            $video_unique_id                        = $videoDetails[$this->data]->unique_id;
            $directory                              = config( 'constants.movie_path.output' ).$video_unique_id;

            
            Log::info("PATH = ". $directory);
            Log::info("S3PATH = ". $s3Directory);




            // Ensure the directory exists
            if (File::isDirectory($directory)) {
                
                $this->awsSer->copyDirectoryContentsToS3($directory, $s3Directory.$video_unique_id);

                Log::info("uploadToS3 Success");
                echo "uploaded to s3";

                sleep(30);
                File::deleteDirectory($directory);

                $isUplaod                          = $this->commonSer->updateVideoIsUpload($video_id,$video_unique_id);


                if($isUplaod[$this->status])
                {
                    Log::info("Updated....");
                    echo "Updated...";
                }
                else
                {
                    Log::info("problem while Update....");
                    echo "problem while Update...";
                }

            } else {
                Log::info("Dir not exists");
                echo "Dir not exists";
            }

        }
        else
        {
            echo "Video Not Available For Process...";
        }

    }



}
