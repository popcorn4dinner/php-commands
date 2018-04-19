<?php

namespace Popcorn4dinner\Command;

use Psr\Log\LoggerInterface;

abstract class AbstractCommandHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AbstractCommandHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }


    /**
     * @param CommandInterface $command
     * @return mixed
     * @throws \Exception
     */
    public function execute(CommandInterface $command)
    {
        try {
            $this->log($command);
            return $this->handle($command);
        } catch (\Exception $e) {
            $this->logFailure($command, $e);

            throw $e;
        }
    }

    /**
     * @param CommandInterface $command
     * @return mixed
     */
    abstract protected function handle(CommandInterface $command);


    /**
     * @param CommandInterface $command
     */
    protected function log(CommandInterface $command)
    {
        if ($this->logger !== null) {
            $this->logger->info(CommandConverter::toString($command));
        }
    }

    /**
     * @param CommandInterface $command
     * @param \Exception $e
     */
    protected function logFailure(CommandInterface $command, \Exception $e)
    {
        if ($this->logger !== null) {
            $this->logger->warning("Failed: " . CommandConverter::toString($command), [$e->getMessage()]);
        }
    }
}
