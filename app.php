<?php

declare(strict_types=1);

use App\Command\SetupRedisCommand;
use App\Factory\RedisFactory;
use App\Storage\ItemStorage;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';

$application = new Application();

$redisFactory = new RedisFactory();

$itemStorage = new ItemStorage($redisFactory->getRedisClient());

$setupCommand = new SetupRedisCommand($itemStorage);

$application->add($setupCommand);

$application->run();
