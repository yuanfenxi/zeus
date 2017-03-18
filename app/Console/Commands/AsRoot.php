<?php

namespace App\Console\Commands;

use App\Console\CommandShorts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class AsRoot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:root';

    static $commands = [
        CommandShorts::LS=>"ls",
        CommandShorts::RE_INIT_SEARCH=>"/home/x/bin/re-init-elastic.sh",
        CommandShorts::WHO_AM_I=>"whoami"
    ];
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从本地的redis中取回命令,并执行。';

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
        $hostname = `hostname`;
        $listName = 'command:as:root';
        $agentServer = env("AGENT_SERVER");
        while(true) {
            try {
                Log::error("redis pub/sub error... got.");
                Redis::subscribe($listName,
                    function ($v) use ($agentServer, $hostname) {
                        if (isset(AsRoot::$commands[intval($v)])) {
                            $command = AsRoot::$commands[intval($v)];
                            exec($command, $output, $result);
                            if ($result == 0) {
                                $this->info("执行command:" . $command);
                            } else {
                                $this->error("执行任务失败:" . $command);
                            }

                            file_get_contents($agentServer . '/agent/report?command=' . urlencode($command) . "&output=" . urlencode(join("\n", $output)) . "&result=" . $result . '&hostname=' . urlencode($hostname));
                        } else {
                            Log::error("命令无法解析:$v");
                        }
                    }
                );
            } catch (\Exception $e) {

            }
            sleep(1);
        }
    }
    
}
