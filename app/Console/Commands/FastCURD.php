<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Exception;
use Expand\FastCURD\CurdManager;
use Illuminate\Console\Command;


class FastCURD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:curd {table} {module} {--lang} {--alias=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fast curd';

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
    public function handle(): int
    {
        $lang = $this->option('lang');
        $alias = $this->option('alias');
        $table = $this->argument('table');
        $module = $this->argument('module');

        $manager = new CurdManager($table, $module, $lang, $alias);

        try {

            $manager->handle();

            $this->info('success');

        } catch (Exception $e) {

            $this->error('error');
        }

        return 0;
    }

}
