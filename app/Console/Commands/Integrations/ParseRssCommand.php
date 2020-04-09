<?php

namespace App\Console\Commands\Integrations;

use App\Integrations\Handlers\RssHandler;
use App\Integrations\IntegrationHandlerFactory;
use App\Models\Integrations\Integration;
use App\Repositories\Integrations\IntegrationRepository;
use App\Repositories\Integrations\IntegrationTypeRepository;
use App\Services\Channels\MessageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
     * @param IntegrationTypeRepository $repository
     * @return mixed
     */
    public function handle(IntegrationTypeRepository $repository)
    {
        try{
            $integrations  = $repository->getIntegrationsByType('rss');
            $handler = new RssHandler(app()->make(MessageService::class));

            foreach($integrations as $integration){
                $handler->setIntegration($integration);

                if(!$handler->integrationHasChannels()){
                    continue;
                }

                $handler->parseRss();
            }

        }catch (\Exception $e){
            $this->error($e->getMessage().' '. $e->getTraceAsString());
            Log::info($e->getMessage().' '. $e->getTraceAsString());
        }
    }
}
