<?php

namespace App\Console\Commands;

use App\Services\Chat\Room;
use App\Services\Chat\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ChatRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:start 
        {--host=0.0.0.0 : Host}
        {--port=9000 : Port}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $server;

    protected $host;

    protected $port;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->host = $this->option('host');
        $this->port = $this->option('port');
        $this->server = new \swoole_websocket_server($this->host, $this->port);
        $this->server->on('open', function (\swoole_websocket_server $server, $request) {
            $requestUri = $request->server['request_uri'];
            if(Str::startsWith($requestUri, '/ws/')){
                $roomId = Str::substr($requestUri, 4);
                Room::joinRoom($roomId, $request->fd);
                User::setUser($request->fd, [
                    'fd' => $request->fd,
                    'roomId' => $roomId
                ]);
            }
        });
        $this->server->on('message', function (\swoole_websocket_server $server, $frame) {
            $this->info("receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n");
            $user = User::getUser($frame->fd);
            $allFds = Room::getRoom($user['roomId']);
            foreach ($allFds as $fd){
                $this->server->push($fd, $frame->data);
            }
        });
        $this->server->on('close', function (\swoole_websocket_server $server, $fd) {
            $user = User::getUser($fd);
            Room::quitRoom($user['roomId'], $fd);
            User::removeUser($fd);
        });
        Room::clear();
        $this->server->start();
        return;
    }
}
