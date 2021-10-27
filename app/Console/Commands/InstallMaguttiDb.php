<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\ConfirmableTrait;

/**
 * @property mixed db_name
 */
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
    protected $description = 'Install the maguttiCms seed from framework_base.sql file located in the db folder';


    protected string $seed_file = "framework_base.sql";


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->db_name =env('DB_DATABASE');
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

        if($this->checkIfDbIsAlreadyInstalled()){
            if (!$this->confirm($this->db_name.' db already exists, overwritten?')) {
                $this->info($this->db_name.' db not updated!');
                return;
            }
        }

        $seed_file = $this->getSeedPath();
        $this->info("Reading [$this->seed_file] file....");
        $this->info(".....");
        DB::unprepared(file_get_contents($seed_file));

        $this->info('maguttiCms db installed successfully!');

        $this->info("");


    }

    function checkIfDbIsAlreadyInstalled(){

        return \Schema::hasTable('users');
    }

    function getSeedPath(){
        return __dir__ . '/../../../db/'.$this->seed_file;
    }
}
