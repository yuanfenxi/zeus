<?php

namespace App\Console\Commands;

use App\Node;
use Illuminate\Console\Command;

class AddNode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:node {ip : ip of the new node} {colo : colo of the new node }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '添加节点';

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
        $ip = $this->argument("ip");
        if (!$ip) {
            $this->error("必须指定IP");
        }
        $colo = $this->argument("colo");
        $node = new Node();
        $node->minPort = 10000;
        $node->maxPort = 20000;
        $node->ip = $ip;
        $node->colo = $colo;
        $node->status = "online";
        $node->save();
        $node->afterCreate();

    }
}
