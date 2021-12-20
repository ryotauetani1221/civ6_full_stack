<?php

namespace App\Console\Commands\Scraping;

use Illuminate\Console\Command;
use App\Traits\Scraping\AreaScrapingTrait;

class AreaCommand extends Command
{
    use AreaScrapingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraping:area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        AreaScrapingTrait::init();
        return Command::SUCCESS;
    }
}
