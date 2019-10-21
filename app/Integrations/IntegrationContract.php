<?php
namespace App\Integrations;


use Illuminate\Http\Request;

interface IntegrationContract
{
    public function acceptHook(Request $request);
    public function confirmServer(Request $request);
    public function parseAttachments(Request $request);
}
