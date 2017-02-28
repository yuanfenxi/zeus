<?php

namespace App\Console\Commands;

use app\Console\Notify;
use Illuminate\Console\Command;

class WatchEs extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watch:es {--test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if($this->option("test")){
            $this->errorOfES("club");
        }
        $this->watch('http://q1.glz8.net:9933/_cluster/health/?level=shards', 'club');
        $this->watch('http://q2.glz8.net:9933/_cluster/health/?level=shards', 'nvwa');
    }


    private function errorOfES($index){
        $this->sendMsgToStaff('xurenlu@glz8.com', $index."的搜索出问题了。。。");
    }
    private function watch($url,$index){
        $json = file_get_contents($url);
        
        $data = json_decode($json,true);
        if(!isset($data["indices"])){
            $this->errorOfES($index);
        }
        $error = false;
        foreach($data['indices'][$index]['shards'] as $shard){
            if($shard['status']=='red'){
                $error = true;
            }
        }
        if($error){
            $this->errorOfES($index);
        }
    }
}
