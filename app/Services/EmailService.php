<?php

declare(strict_types=1);

namespace App\Services;

use App\Job\EmailJob;
use App\Model\Expense;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Di\Annotation\Inject;

class EmailService
{
    /**
     * @var string
     */
    protected string $queue = 'default';
    /**
     * @var DriverFactory
     */
    #[Inject]
    protected DriverFactory $driverFactory;
    /**
     * @var DriverInterface
     */
    protected DriverInterface $driver;

    /**
     * @param Expense $expense
     * @return bool
     */
    public function push(Expense $expense): bool
    {
        $this->driver = $this->driverFactory->get($this->queue);

        return $this->driver->push(new EmailJob($expense->toArray()));
    }
}