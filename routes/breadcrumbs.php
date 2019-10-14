<?php
/**
 * Breadcrumbs file
 */

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('dashboard', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->push(trans('general.dashboard'), route('dashboard'));
});


/** ============================ Channel Groups ================================ */

Breadcrumbs::register('group.index', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('dashboard');
    $crumbs->push(trans('general.groups'), route('group.index'));
});

Breadcrumbs::register('group.show', function(BreadcrumbsGenerator $crumbs, $groupId) {
    $crumbs->parent('group.index');
    $crumbs->push(trans('general.group') . ': ' . $groupId, route('group.show', $groupId));
});

Breadcrumbs::register('group.create', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('group.index');
    $crumbs->push(trans('general.create_group'), route('group.index'));
});


Breadcrumbs::register('group.edit', function(BreadcrumbsGenerator $crumbs, $groupId) {
    $crumbs->parent('group.index');
    $crumbs->push(trans('general.update') . ': ' . $groupId, route('group.edit', $groupId));
});

/** =============================================================================== */

/** ================================= Channels ==================================== */

Breadcrumbs::register('channel.index', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('dashboard');
    $crumbs->push(trans('general.channels'), route('channel.index'));
});

Breadcrumbs::register('channel.show', function(BreadcrumbsGenerator $crumbs, $channelId) {
    $crumbs->parent('channel.index');
    $crumbs->push(trans('general.channel') . ': ' . $channelId, route('channel.show', $channelId));
});

Breadcrumbs::register('channel.create', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('channel.index');
    $crumbs->push(trans('general.create_channel'), route('channel.create'));
});

Breadcrumbs::register('channel.edit', function(BreadcrumbsGenerator $crumbs, $channelId) {
    $crumbs->parent('channel.index');
    $crumbs->push(trans('general.update') . ': ' . $channelId, route('channel.edit'));
});

/** =============================================================================== */

/** ================================= Services ==================================== */

Breadcrumbs::register('service.index', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('dashboard');
    $crumbs->push(trans('general.services'), route('service.index'));
});

Breadcrumbs::register('service.show', function(BreadcrumbsGenerator $crumbs, $serviceId) {
    $crumbs->parent('service.index');
    $crumbs->push(trans('general.service') . ': ' . $serviceId, route('service.show', $serviceId));
});

Breadcrumbs::register('service.create', function(BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('service.index');
    $crumbs->push(trans('general.create_service'), route('service.create'));
});

/** =============================================================================== */

/** ================================= Integrations ================================ */

Breadcrumbs::register('integration-types.index', function(BreadcrumbsGenerator $crumbs){
    $crumbs->parent('dashboard');
    $crumbs->push(trans('general.integration_types'), route('integration-types.index'));
});

Breadcrumbs::register('integration-types.create', function(BreadcrumbsGenerator $crumbs){
    $crumbs->parent('integration-types.index');
    $crumbs->push(trans('general.create_type_integration'), route('integration-types.create'));
});

Breadcrumbs::register('integration-types.show', function (BreadcrumbsGenerator $crumbs ,$integrationType){
    $crumbs->parent('integration-types.index');
    $crumbs->push(trans('general.integration_types') . ': ' . $integrationType->id, route('integration-types.show', $integrationType));
});

Breadcrumbs::register('integration-types.edit', function (BreadcrumbsGenerator $crumbs, $id){
    $crumbs->parent('integration-types.index');
    $crumbs->push(trans('general.edit') . ': ' . $id, route('integration-types.edit', $id));
});

/** =============================================================================== */

/** ================================= Logs ================================ */

Breadcrumbs::register('logs', function(BreadcrumbsGenerator $crumbs){
    $crumbs->parent('dashboard');
    $crumbs->push(trans('general.logs'), route('logs'));
});
