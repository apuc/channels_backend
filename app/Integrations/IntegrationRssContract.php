<?php
namespace App\Integrations;

use SimplePie_Item;

interface IntegrationRssContract
{
    public function parseAttachments(SimplePie_Item $item);
}
