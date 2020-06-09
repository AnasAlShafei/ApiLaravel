<?php

namespace App\Console\Commands;

use App\Orders;
use Illuminate\Console\Command;

class order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status-can';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Change Status orders to canceled ';

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
        //
        $rows = Orders::all();
        foreach($rows as $row) {
            $row->status = 2;
            $row->save();
        }
        
        foreach ($rows as $row) {
            echo "Id Order " . $row->id . "-Number Product " . $row->product . '-Numbering of product ' . $row->numbering . " -user " . $row->user . " -status " . $row->status;
            echo "\n";
        }

    }
}
