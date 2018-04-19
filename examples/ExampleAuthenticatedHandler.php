<?php


namespace Popcorn4dinner\Commands\Examples;

use Popcorn4dinner\Commands\AbstractAuthenticatedCommandHandler;
use Popcorn4dinner\Commands\AbstractCommandHandler;
use Popcorn4dinner\Commands\CommandInterface;

class ExampleAuthenticatedHandler extends AbstractAuthenticatedCommandHandler
{
    private const MAX_RETRIEVABLE_ITEMS = 100;
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PAGE_SIZE = 15;

    protected function handle(CommandInterface $command, $user = null)
    {

        /**
         *  Your applications flow logic goes here.
         *
         * As an Example:
         */


        $page = $command->page ?? static::DEFAULT_PAGE;
        $pageSize = $command->pageSize ?? static::DEFAULT_PAGE_SIZE;

        $offset = ($page - 1) * $pageSize;

        $tooManyItemsRequested = $pageSize - $offset > static::MAX_RETRIEVABLE_ITEMS;

        if ($tooManyUsersRequested) {
            throw new \RuntimeException("The requested set of users exceeded the limit of " . static::MAX_RETRIEVABLE_ITEMS);
        }

        // some more example logic
        // return $this->offerRepository->findByUserId($user->id, $pageSize, $offset);


        if (is_null($command->someParameter)) {
            throw new \RuntimeException('something went wrong.');
        }

        return $command->someParameter;
    }
}
