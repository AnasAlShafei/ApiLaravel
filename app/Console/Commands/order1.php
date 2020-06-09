<?php

namespace App\Console\Commands;

use App\Orders;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class order1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status-del';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Display Status orders of delivered ';

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
        $rows = Orders::all();
        foreach ($rows as $row) {
            if($row->status == 1){
            echo "Id Order " . $row->id . "-Number Product " . $row->product . '-Numbering of product ' . $row->numbering . " -user " . $row->user . " -status " . $row->status;
            echo "\n";
            }
        }
    }
}
