<?php

namespace Popcorn4dinner\Command;

use Psr\Log\LoggerInterface;

abstract class AbstractAuthenticatedCommandHandler
{
    private const UNKNOWN_USER_NAME = 'somebody';

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
     * @param null $user
     * @return mixed
     * @throws \Exception
     */
    public function execute(CommandInterface $command, $user = null)
    {
        try {
            $this->log($command, $user);
            return $this->handle($command, $user);
        } catch (\Exception $e) {
            $this->logFailure($command, $user, $e);

            throw $e;
        }
    }

    /**
     * @param CommandInterface $command
     * @param null $user
     * @return mixed
     */
    abstract protected function handle(CommandInterface $command, $user = null);


    /**
     * @param CommandInterface $command
     * @param null $user
     */
    protected function log(CommandInterface $command, $user = null)
    {
        if ($this->logger !== null) {
            $user = $user ?? self::UNKNOWN_USER_NAME;
            $this->logger->info("{$user} is " .CommandConverter::toString($command));
        }
    }

    /**
     * @param CommandInterface $command
     * @param null $user
     * @param \Exception $e
     */
    protected function logFailure(CommandInterface $command, $user = null, \Exception $e)
    {
        if ($this->logger !== null) {
            $user = $user ?? self::UNKNOWN_USER_NAME;
            $this->logger->warning("Failed: {$user} tryed " . CommandConverter::toString($command), [$e->getMessage()]);
        }
    }
}
