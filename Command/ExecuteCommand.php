<?php

namespace Oliverde8\PhpEtlBundle\Command;

use Oliverde8\PhpEtlBundle\Services\ChainProcessorsManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteCommand extends Command
{
    const ARGUMENT_NAME = "name";
    const ARGUMENT_DATA = "data";
    const ARGUMENT_PARAMS = "params";

    /** @var ChainProcessorsManager */
    protected $chainProcessorsManager;

    /**
     * ExecuteCommand constructor.
     * @param ChainProcessorsManager $chainProcessorsManager
     */
    public function __construct(ChainProcessorsManager $chainProcessorsManager)
    {
        parent::__construct();
        $this->chainProcessorsManager = $chainProcessorsManager;
    }


    protected function configure()
    {
        $this->setName("etl:execute");
        $this->addArgument(self::ARGUMENT_NAME, InputArgument::REQUIRED);
        $this->addArgument(self::ARGUMENT_DATA, InputArgument::OPTIONAL, "json with the input array");
        $this->addArgument(self::ARGUMENT_PARAMS, InputArgument::OPTIONAL, "json with all the additional parameters");
    }

    /**
     * @throws \Oliverde8\Component\PhpEtl\Exception\ChainOperationException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $chainName = $input->getArgument(self::ARGUMENT_NAME);
        $options = json_decode($input->getArgument(self::ARGUMENT_PARAMS) ?? '[]', true);
        $data = json_decode($input->getArgument(self::ARGUMENT_DATA) ?? '[]', true);

        $this->chainProcessorsManager->execute($chainName, $data, $options);
        return 0;
    }
}