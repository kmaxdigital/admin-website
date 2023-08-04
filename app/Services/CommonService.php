<?php

namespace App\Services;

use App\Movies;
use App\Episodes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FFMpeg\Coordinate\Dimension;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Log;
use Validator;
use App\Exceptions;


class CommonService
{

    public function __construct()
    {
        $this->status                               = 'status';
        $this->message                              = 'message';
        $this->code                                 = 'status_code';
        $this->data                                 = 'data';
        $this->total                                = 'total_count';
        
        $this->dimensions                           = [
            new Dimension(640, 360),
            new Dimension(1280, 720),
            new Dimension(1920, 1080),
        ];
    }
    


    /*
        getVideoDetails()
        return result objects
        
    */
    
    public function getVideoDetails()
    {
        $results                                    = Movies::where('is_verify','inprocess')
                                                        ->where('is_processed','0')
                                                        ->where('status',1)
                                                        ->first();
        if($results)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully movie found..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = $results;
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Movie not found..';
            $return[$this->code]                    = 404;
        }

        return $return;
    }
    /*
        getVideoDetailsForS3()
        return result objects
        
    */
    
    public function getVideoDetailsForS3()
    {
        $results                                    = Movies::where('is_verify','verified')
                                                        ->where('is_processed','1')
                                                        ->where('is_upload','no')
                                                        ->where('status',1)
                                                        ->first();
        if($results)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully movie found..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = $results;
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Movie not found..';
            $return[$this->code]                    = 404;
        }

        return $return;
    }
    


    /*
        updateVideoIsProcessed()
        return result objects
        
    */
    
    public function updateVideoIsProcessed($videoId, $videoUniqueId)
    {
        $update                                     = Movies::where('id',$videoId)
                                                        ->where('unique_id',$videoUniqueId)
                                                        ->take(1)
                                                        ->update(['is_processed' => '1']);
        if($update)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully status updated..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = [];
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Oops, Problem while update..';
            $return[$this->code]                    = 201;
        }

        return $return;
    }


    

    /*
        updateVideoIsUpload()
        return result objects
        
    */
    
    public function updateVideoIsUpload($videoId, $videoUniqueId)
    {
        $update                                     = Movies::where('id',$videoId)
                                                        ->where('unique_id',$videoUniqueId)
                                                        ->take(1)
                                                        ->update(['is_upload' => 'yes']);
        if($update)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully status updated..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = [];
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Oops, Problem while update..';
            $return[$this->code]                    = 201;
        }

        return $return;
    }





    /**
     * Generate the master playlist file with references to the HLS files of different dimensions.
     *
     * @param array  $hlsFiles          Array of paths to the HLS files.
     * @param string $masterPlaylistPath Path to the master playlist file.
     */
    public function generateMasterPlaylist(array $hlsFiles, string $masterPlaylistPath)
    {
        $masterPlaylistContent                       = "#EXTM3U\n";
        $masterPlaylistContent                      .= "#EXT-X-VERSION:3\n";

        foreach ($hlsFiles as $index => $hlsFile) 
        {
            $dimension                               = $this->dimensions[$index];

            $masterPlaylistContent                  .= "#EXT-X-STREAM-INF:BANDWIDTH=800000,RESOLUTION={$dimension->getWidth()}x{$dimension->getHeight()}\n";
            $masterPlaylistContent                  .= $hlsFile . "\n";
        }

        file_put_contents($masterPlaylistPath, $masterPlaylistContent);
    }








    /*

        Episode Code

    */


    public function getEpisodeDetails()
    {
        $results                                    = Episodes::where('is_verify','inprocess')
                                                        ->where('is_processed','0')
                                                        ->where('status',1)
                                                        ->first();
        if($results)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully episode found..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = $results;
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Movie not found..';
            $return[$this->code]                    = 404;
        }

        return $return;
    }


    /*
        updateVideoIsProcessed()
        return result objects
        
    */
    
    public function updateEpisodeIsProcessed($videoId, $videoUniqueId)
    {
        $update                                     = Episodes::where('id',$videoId)
                                                        ->where('unique_id',$videoUniqueId)
                                                        ->take(1)
                                                        ->update(['is_processed' => '1']);
        if($update)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully status updated..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = [];
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Oops, Problem while update..';
            $return[$this->code]                    = 201;
        }

        return $return;
    }




    public function getEpisodeDetailsForS3()
    {
        $results                                    = Episodes::where('is_verify','verified')
                                                        ->where('is_processed','1')
                                                        ->where('is_upload','no')
                                                        ->where('status',1)
                                                        ->first();
        if($results)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully episode found..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = $results;
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Episode not found..';
            $return[$this->code]                    = 404;
        }

        return $return;
    }


     /*
        updateEpisodeIsUpload()
        return result objects
        
    */
    
    public function updateEpisodeIsUpload($videoId, $videoUniqueId)
    {
        $update                                     = Episodes::where('id',$videoId)
                                                        ->where('unique_id',$videoUniqueId)
                                                        ->take(1)
                                                        ->update(['is_upload' => 'yes']);
        if($update)
        {
            
            $return[$this->status]                  = true;
            $return[$this->message]                 = 'Successfully status updated..';
            $return[$this->code]                    = 200;
            $return[$this->data]                    = [];
        
        }
        else
        {
            $return[$this->status]                  = false;
            $return[$this->message]                 = 'Oops, Problem while update..';
            $return[$this->code]                    = 201;
        }

        return $return;
    }


}
