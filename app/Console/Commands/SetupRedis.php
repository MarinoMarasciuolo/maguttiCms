<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Exception;

class SetupRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magutticms:setup-redis {--show : Display the key instead of modifying the file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a unique string to be used as Redis prefix.';

    /**
     * The prefix hash length.
     *
     * @var int
     */
    protected $hashLength = 44;

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
        $prefix = $this->generateRandomPrefix();

        if ($this->option('show')) {

            $this->line('<comment>' . $prefix . '</comment>');
            return;
        }

        $this->setPrefixInEnvironmentFile($prefix);

        $this->comment(PHP_EOL . 'Redis prefix successfully generated!' . PHP_EOL);
    }

    /**
     * Generate a random prefix for redis.
     *
     * @return string
     */
    protected function generateRandomPrefix()
    {
        $prefix = env('APP_NAME', 'maguttiCms');

        try {
            return $prefix . '_' . base64_encode(random_bytes($this->hashLength));
        } catch (Exception $e) {
            return $prefix . '_' . Str::random($this->hashLength);
        }
    }

    /**
     * Set redis prefix in the environment file.
     *
     * @param $prefix
     *
     * @return void
     */
    protected function setPrefixInEnvironmentFile($prefix)
    {
        file_put_contents($this->laravel->environmentFilePath(), str_replace(
            'REDIS_PREFIX=' . env('REDIS_PREFIX'),
            'REDIS_PREFIX=' . $prefix,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }
}
