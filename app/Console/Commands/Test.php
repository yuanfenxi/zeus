<?php

namespace App\Console\Commands;

use App\Console\CommandShorts;
use App\Console\Notify;
use App\Zeus\HostHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class Test extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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

        $text = '
        //testing
        q1.glz8.net
        q2.glz8.net//gogo
        hell
        
        ';
        print_r(HostHelper::parseHost($text));
//        Redis::Publish("command:as:root",CommandShorts::WHO_AM_I);
        Log::error("Testing");
//        print $this->buildUrl([
//            'xurenlu@glz8.com',
//            'qianhui@glz8.com'
//        ], '测试搜索');
    }
}
