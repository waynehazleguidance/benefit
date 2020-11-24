<?php

declare(strict_types=1);

return [

    'development' => [
//        'fail-fast'  => true,
//        'website'    => 'US',
        'debug'      => true,
        'colors'     => true,
        'steps'      => true,
        'html'       => 'result.html',
        'verbosity'  => \Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG,
    ],

    'staging' => [
//        'website'    => 'US',
        'debug'      => true,
        'fail-fast'  => true,
        'colors'     => true,
        'steps'      => true,
        'html'       => 'result.html',
        'verbosity'  => \Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG,
    ],

    'production' => [
//        'website'   => 'US',
        'debug'     => true,
        'colors'    => true,
        'steps'     => true,
        'html'      => 'result.html',
        'verbosity' => \Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE,
    ]
];
