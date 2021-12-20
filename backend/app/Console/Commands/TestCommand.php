<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\TestTrait;


class TestCommand extends Command
{
    use TestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command description';

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
        TestTrait::testFunc();

        return Command::SUCCESS;
    }

    // private function Scraping()
    // {
    // }
}
