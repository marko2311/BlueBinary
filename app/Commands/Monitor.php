<?php

namespace App\Commands;

use App\Factories\CoasterStatusDTOFactory;
use App\Factories\StatusReportDTOFactory;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use React\EventLoop\Factory as LoopFactory;
use Clue\React\Redis\Factory as RedisFactory;
use App\Services\MonitorService;
use App\Services\Status\CoasterStatusProvider;
use App\Services\Status\StatusAnalyzer;
use App\Services\Renderer\StatisticsRenderer;
use App\Services\Logger\ProblemLogger;
use App\Repositories\CoasterRepository;
use App\Repositories\WagonRepository;
use App\Services\RedisClientService;
use App\Serializers\Coaster\CoasterSerializerResolver;
use App\Serializers\Wagon\RegisterWagonJsonSerializer;

class Monitor extends BaseCommand
{
    protected $group       = 'monitor';
    protected $name        = 'monitor:run';
    protected $description = 'Start the mountain coaster system monitor';

    public function run(array $params)
    {
        CLI::write('Starting mountain coaster monitor...', 'green');

        $loop = LoopFactory::create();
        $redisFactory = new RedisFactory($loop);
        $redis = $redisFactory->createLazyClient('redis://redis:6379');

        // Sync dependencies
        $redisSync = new RedisClientService();
        $coasterRepo = new CoasterRepository(new CoasterSerializerResolver(), $redisSync);
        $wagonRepo = new WagonRepository(new RegisterWagonJsonSerializer(), $redisSync);

        // Factories and services
        $coasterStatusFactory = new CoasterStatusDTOFactory();
        $statusReportFactory = new StatusReportDTOFactory();

        $statusProvider = new CoasterStatusProvider($coasterRepo, $wagonRepo, $coasterStatusFactory);
        $statusAnalyzer = new StatusAnalyzer($statusReportFactory);
        $renderer = new StatisticsRenderer();
        $logger = new ProblemLogger(WRITEPATH . 'logs/monitor.log');

        $monitor = new MonitorService($loop, $statusProvider, $statusAnalyzer, $renderer, $logger);
        $monitor->run();

        $loop->run();
    }
}
