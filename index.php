<?php

declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;

use Schnell\Container;
use Schnell\Kernel;
use Schnell\Bridge\Doctrine\DoctrineBridge;
use Schnell\Bridge\Mapper\MapperBridge;
use Schnell\Config\ConfigFactory;
use Schnell\Controller\ControllerPool;
use Schnell\Controller\ControllerResolver;
use Schnell\Middleware\HttpErrorMiddleware;

use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

$configFactory = new ConfigFactory();
$configFactory->importBulk([
    './config/controller.conf',
    './config/database.conf',
    './config/bridge/doctrine.conf'
]);

$config = $configFactory->getConfig();
$container = new Container();
$request = ServerRequestCreatorFactory::create()
    ->createServerRequestFromGlobals();
$controllerPool = new ControllerPool(
    $container,
    $configFactory->getConfig(),
    new SplObjectStorage()
);

$controllerPool->collect();

AppFactory::setContainer($container);

$app = AppFactory::create();

$controllerResolver = new ControllerResolver($controllerPool, $app);
$controllerResolver->addBodyParsingMiddleware();
$controllerResolver->addRoutingMiddleware();
$controllerResolver->add(new HttpErrorMiddleware($controllerPool));
$controllerResolver->resolve($request);

registerShutdownHandler($request, shutdownHandlerCallback($request));

$kernel = new Kernel($config, $container, $controllerResolver);
$kernel->addExtension(new DoctrineBridge(), getcwd());
$kernel->addExtension(new MapperBridge(), getcwd());
$kernel->load();
$kernel->handle($request);
