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
     * @var mixed
     */
    private mixed $app_name;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->db_name = env('DB_DATABASE');
        $this->app_name = env('APP_NAME');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $seed_file_path = $this->getSeedPath();

        if (! $this->confirmToProceed()) {
            return 1;
        }

        if (!file_exists($seed_file_path)) {
            $this->line('');
            $this->error($this->seed_file . ' file non found');
            $this->line('');
            return 1;
        }

        if($this->checkIfDbIsAlreadyInstalled()){
            if (!$this->confirm($this->db_name.' db already exists, overwritten?')) {
                $this->info($this->db_name.' db not updated!');
                return;
            }
        }

        $this->info("Reading [$this->seed_file] file....");
        //import db
        DB::unprepared(file_get_contents($seed_file_path));

        $this->line("");
        $this->warn($this->app_name . ' db installed successfully!');
        return 1;

    }

    /**
     * @return bool
     */
    function checkIfDbIsAlreadyInstalled(): bool{

        return \Schema::hasTable('users');
    }

    function getSeedPath(): string
    {
        return __dir__ . '/../../../db/'.$this->seed_file;
    }
}
