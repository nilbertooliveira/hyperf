<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;

class EmailJob extends Job
{
    public array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        var_dump($this->params);
    }
}
