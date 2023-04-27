<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

#[Process(name: 'EmailConsumer')]
class EmailConsumer extends AbstractProcess
{
    protected string $queue = 'default';

    protected DriverInterface $driver;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): void
    {
        $this->driver = $this->container->get(DriverFactory::class)->get($this->queue);

        $this->driver->consume();
    }
}
