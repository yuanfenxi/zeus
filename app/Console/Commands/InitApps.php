<?php

namespace App\Console\Commands;

use App\Model\App;
use Illuminate\Console\Command;

class InitApps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:apps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化所有的App';

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
        $templates = [
            "nginx",
            "portman",
            "proxy",
            "ws"
        ];
        foreach ($templates as $template) {
            $app = new App();
            $app->name = $template;
            $app->language = $template;
            $app->git_repo = "";
            $app->save();
        }
    }
}
