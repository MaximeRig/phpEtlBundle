<?php

namespace Oliverde8\PhpEtlBundle\Services;

use Oliverde8\PhpEtlBundle\Entity\EtlExecution;
use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    public function get(EtlExecution $execution): LoggerInterface;
}