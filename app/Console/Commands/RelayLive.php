<?php

namespace App\Console\Commands;

use App\Models\LiveRelay;
use App\Models\Room;
use App\Services\Relay\RelayCancel;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Process\Process;

class RelayLive extends Command implements ShouldQueue
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live:relay {relay_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $config;

    /**
     * @var Process
     */
    protected $process;

    protected $expired_at;

    protected $relay_id;

    protected $from_room_id;

    protected $to_room_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = config('ffmpeg.ffmpeg');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->relay_id = $this->argument('relay_id');
        $relayLive = LiveRelay::where('id', $this->relay_id)->first();
        if(!$relayLive){
            return;
        }
        $this->expired_at = strtotime($relayLive->expired_at);
        if(time() >= $this->expired_at){
            return;
        }

        $this->from_room_id = $relayLive->from_room;
        $this->to_room_id = $relayLive->to_room;

        $from_room = Room::where('id', $this->from_room_id)->first();
        $to_room = Room::where('id', $this->to_room_id)->first();

        if($from_room && $to_room){
            $from_stream_name = $from_room->streams_name;
            $to_stream_name = $to_room->streams_name;
            $from_live_status = liveStatus($from_stream_name);
            $to_live_status = liveStatus($to_stream_name);
            if(!isset($from_live_status['status']) && isset($to_live_status['status'])){
                // 转播的直播正在播放并且to直播没有播放才能转播
                $playUrl = playUrl($from_stream_name);
                $publishUrl = publishUrl($to_stream_name);
                $this->setRelayRoom($this->from_room_id);
                $commandLine = $this->buildCommandLine($playUrl, $publishUrl);
                $this->process = new Process($commandLine);
                $this->process->setTimeout(0);
                try{
                    $this->process->run(function ($type, $data){
                        $this->info($data);
                        if($this->expired_at <= time() || RelayCancel::cancelAble($this->to_room_id)){
                            $this->setRelayRoom(null);
                            RelayCancel::removeCancel($this->to_room_id);
                            $this->process->stop();
                        }
                    });
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                    RelayCancel::removeCancel($this->to_room_id);
                    $this->process->stop();
                    $this->setRelayRoom(null);
                }
            }
        }
    }

    function setRelayRoom($relay_room_id){
        return Room::where('id', $this->to_room_id)->update([
            'relay_room_id' => $relay_room_id
        ]);
    }


    protected function buildCommandLine($playUrl, $publishUrl){
        $ffmpegBinary = $this->config['binary'];
        return "{$ffmpegBinary} -re -i {$playUrl} -c:v copy -c:a copy -f flv '{$publishUrl}'";
    }

}
