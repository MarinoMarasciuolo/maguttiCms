<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class InstallMaguttiDb extends Command
{

    use ConfirmableTrait;

    /**
     * /**
     * Seed the application's database.
     *
     *
     * @var string
     */
    protected $signature = 'magutticms:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the maguttiCms seed file framework_base.sql';


    protected $seed_file = "framework_base.sql";

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
     * @return int
     */
    public function handle()
    {

        if (! $this->confirmToProceed()) {
            return 1;
        }

        $seed_file = $this->getSeedPath();
        $this->info("Reading [$this->seed_file] file....");
        $this->info("");

        \DB::unprepared(file_get_contents($seed_file));

        $this->info('maguttiCms db installed successfully!');
        $this->info("");


    }

    function getSeedPath(){
        return __dir__ . '/../../../db/'.$this->seed_file;
    }
}
