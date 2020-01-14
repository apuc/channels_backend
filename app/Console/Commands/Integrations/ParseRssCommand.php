<?php

namespace App\Console\Commands\Integrations;

use App\Models\Integrations\Integration;
use Illuminate\Console\Command;

class ParseRssCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrations:parse-rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получает обновления для rss интеграций';

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
        try{
            $integrations  = Integration::whereRaw('fields -> "$.rss" = true')->get();
            var_dump($integrations->first()->name);
        }catch (\Exception $e){
          var_dump($e->getMessage());
        }
    }
}
