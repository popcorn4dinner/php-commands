<?php

namespace Popcorn4dinner\Commands;

class CommandConverter
{
    static public function toString(CommandInterface $command): string
    {
        $commandName = (new \ReflectionClass($command))->getShortName();

        $output = "executing {$commandName} with ";

        $properties = [];
        foreach(get_object_vars($command) as $propertyToSet => $value) {
            $value = json_encode($value);
            $properties[]= "{$propertyToSet}={$value}";
        }

        return $output . join(", ", $properties);
    }
}