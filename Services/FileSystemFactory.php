<?php

namespace Oliverde8\PhpEtlBundle\Services;

use Oliverde8\Component\PhpEtl\Model\File\FileSystemInterface;
use Oliverde8\Component\PhpEtl\Model\File\LocalFileSystem;
use Oliverde8\PhpEtlBundle\Entity\EtlExecution;
use Psr\Log\LoggerInterface;

class FileSystemFactory implements FileSystemFactoryInterface
{
    private ChainWorkDirManager $chainWorkDirManager;

    /** @var LoggerInterface[] */
    private array $loggers = [];

    public function __construct(ChainWorkDirManager $chainWorkDirManager)
    {
        $this->chainWorkDirManager = $chainWorkDirManager;
    }

    public function get(EtlExecution $execution): FileSystemInterface
    {
        if (!isset($this->loggers[$execution->getId()])) {
            $this->loggers[$execution->getId()] = new LocalFileSystem($this->chainWorkDirManager->getLocalTmpWorkDir($execution));
        }

        return $this->loggers[$execution->getId()];
    }
}
