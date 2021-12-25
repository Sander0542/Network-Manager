<?php

return [

    'dsn' => 'https://68668b93b0bd4bc7806e45062d3be7b6@o1098923.ingest.sentry.io/6123237',

    // capture release as git sha
    'release' => applicationVersion(null),

    // When left empty or `null` the Laravel environment will be used
    'environment' => config('app.env'),

    'server_name' => 'Network Manager',

    'breadcrumbs' => [
        // Capture Laravel logs in breadcrumbs
        'logs' => true,

        // Capture SQL queries in breadcrumbs
        'sql_queries' => true,

        // Capture bindings on SQL queries logged in breadcrumbs
        'sql_bindings' => true,

        // Capture queue job information in breadcrumbs
        'queue_info' => true,

        // Capture command information in breadcrumbs
        'command_info' => true,
    ],

    'tracing' => [
        // Trace queue jobs as their own transactions
        'queue_job_transactions' => env('SENTRY_TRACE_QUEUE_ENABLED', false),

        // Capture queue jobs as spans when executed on the sync driver
        'queue_jobs' => true,

        // Capture SQL queries as spans
        'sql_queries' => true,

        // Try to find out where the SQL query originated from and add it to the query spans
        'sql_origin' => true,

        // Capture views as spans
        'views' => true,

        // Indicates if the tracing integrations supplied by Sentry should be loaded
        'default_integrations' => true,
    ],

    // @see: https://docs.sentry.io/platforms/php/configuration/options/#send-default-pii
    'send_default_pii' => false,

    'traces_sample_rate' => (float) (env('SENTRY_TRACES_SAMPLE_RATE', 0.0)),

    'controllers_base_namespace' => env('SENTRY_CONTROLLERS_BASE_NAMESPACE', 'App\\Http\\Controllers'),

    'before_send' => function (\Sentry\Event $event): ?\Sentry\Event {
        $request = $event->getRequest();
        $event->setRequest([
            'url' => 'http://network.manager'.request()->getRequestUri(),
            'method' => $request['method'],
            'headers' => collect($request['headers'])->only([
                'connection',
                'cache-control',
                'user-agent',
                'accept',
                'accept-encoding',
                'accept-language',
            ])->toArray(),
        ]);

        return $event;
    },

];
