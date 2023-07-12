<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use Aws\S3\S3Client;
use App\Services\CommonService;
use App\Services\AWSService;

use Log;


class NewMovieVideosHLS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Video:NewMovieVideosHLS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();

        $this->status                               = 'status';
        $this->message                              = 'message';
        $this->code                                 = 'status_code';
        $this->data                                 = 'data';
        $this->total                                = 'total_count';
        $this->hls_time                             = 60;
        $this->timeout                              = 7200; // Increase timeout to 3600 seconds
        
        $this->commonSer                            = new CommonService();
        $this->awsSer                               = new AWSService();
        $this->dimensions                           = 
        [
            new Dimension(640, 360),
            new Dimension(1280, 720),
            new Dimension(1920, 1080),
        ];
        
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $videoDetails                               = $this->commonSer->getVideoDetails();

        Log::info("Video Details". json_encode($videoDetails, true));


        if($videoDetails[$this->status])
        {

            $video_id                               = $videoDetails[$this->data]->id;
            $video_unique_id                        = $videoDetails[$this->data]->unique_id;
            

            $inputFile                              = config( 'constants.movie_path.input' ); 
            $outputBaseDirectory                    = config( 'constants.movie_path.output' );

            $outputFilename                         = 'output';

            Log::info("INPUT FILE NAME = ". $inputFile);
            Log::info("OUTPT FILE NAME = ". $outputBaseDirectory);

            $awsAccessKey                           = env('AWS_ACCESS_KEY_ID', 'AKIA6AQXIE5GFIC2KZSP');
            $awsSecretKey                           = env('AWS_SECRET_ACCESS_KEY', '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');
            $awsRegion                              = env('AWS_DEFAULT_REGION', 'ap-south-1');
            $awsBucket                              = env('AWS_BUCKET', 'k-max');

            $inputVideo                             = $inputFile.$video_id.'.mp4';
            Log::info("INPUT VIDEO NAME = ". $inputVideo);

            $ffmpeg                                 = FFMpeg::create([
                            'ffmpeg.binaries'       => '/usr/bin/ffmpeg',
                            'ffprobe.binaries'      => '/usr/bin/ffprobe',
                            'timeout'               => $this->timeout,
                            'ffmpeg.threads'        => 6, // Adjust based on your server capacity
            ]);
            
            $video                                  = $ffmpeg->open($inputVideo);
            Log::info("Video = ". json_encode($video, true));
            $hlsFiles                               = [];

            foreach ($this->dimensions as $index => $dimension) 
            {
                $outputDirectory                    = $outputBaseDirectory.$video_unique_id.'/'. $dimension->getHeight() . '/';

                if (!file_exists($outputDirectory)) 
                {
                    mkdir($outputDirectory, 0777, true);
                }

                $format                             = new X264('libmp3lame', 'libx264');
                $format->setAudioCodec('aac');
                $format->setVideoCodec('libx264');
                $format->setAdditionalParameters([
                    '-vf', 'scale=' . $dimension->getWidth() . ':' . $dimension->getHeight(),
                    '-hls_time', $this->hls_time,
                ]);
                $video->save($format, $outputDirectory . 'index.m3u8');
                $hlsFiles[]                         = $dimension->getHeight() . '/' . 'index.m3u8';

            }

            
            $masterPlaylistPath                     = $outputBaseDirectory.$video_unique_id.'/' . $outputFilename . '.m3u8';
            Log::info("masterPlaylistPath = ". $masterPlaylistPath);
            $this->commonSer->generateMasterPlaylist($hlsFiles, $masterPlaylistPath);

            if (file_exists($masterPlaylistPath)) 
            {

                $update                             = $this->commonSer->updateVideoIsProcessed($video_id, $video_unique_id);
                if($update[$this->status])
                {
                    echo 'HLS generated successfully.';
                }
                else
                {
                    echo "Problem While Update..";
                }

            } 
            else 
            {
                echo 'HLS generation failed.';
            }

        }
        else
        {
            echo "Video Not Available For Process...";
        }
        
    }


    
}
