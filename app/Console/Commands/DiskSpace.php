<?php

namespace App\Console\Commands;

use App\Console\Notify;
use Illuminate\Console\Command;

class DiskSpace extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watch:diskSpace';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '监控磁盘空间';

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
        $command = 'df -h / |awk \'{print $5}\'';
        $spaceAlarm = 90;
        exec($command, $output, $return);
        $space  = substr($output[1], 0, -1);
        if($space > $spaceAlarm){
            $this->sendMsgToStaff(['xurenlu@glz8.com','zhuyanxia@glz8.com'], "q2服务器磁盘空间超过".$spaceAlarm."%, 请及时清理");
        }
    }
}
