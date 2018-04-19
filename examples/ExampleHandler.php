<?php


namespace Popcorn4dinner\Commands\Examples;


use Popcorn4dinner\Commands\AbstractCommandHandler;
use Popcorn4dinner\Commands\CommandInterface;

class ExampleHandler extends AbstractCommandHandler
{

    protected function handle(CommandInterface $command, $user = null)
    {

        /**
         *  Your applications flow logic goes here.
         *
         * As an Example:


            $page = $command->page ?? static::DEFAULT_PAGE;
            $pageSize = $command->pageSize ?? static::DEFAULT_PAGE_SIZE;

            $offset = ($page - 1) * $pageSize;

            $tooManyUsersRequested = $pageSize - $offset > static::MAX_RETRIEVABLE_OFFERS;

            if($tooManyUsersRequested){
                throw new \RuntimeException("The requested set of users exceeded the limit of " . static::MAX_RETRIEVABLE_OFFERS);
            }

            return $this->offerRepository->findAll($pageSize, $offset);

        */


        if(is_null($command->someParameter)){
            throw new \RuntimeException('something went wrong.');
        }

        return $command->someParameter;
    }


}
