<?php

namespace Popcorn4dinner\Command;

use Popcorn4dinner\StringFormat\StringFormat;
use Symfony\Component\HttpFoundation\Request;

class CommandPopulator
{

    /**
     * @param CommandInterface $command
     * @param Request $request
     * @return CommandInterface
     */
    public function populate(CommandInterface $command, Request $request): CommandInterface
    {
        $refl = new \ReflectionClass($command);

        foreach (get_object_vars($command) as $propertyToSet => $value) {
            $property = $refl->getProperty($propertyToSet);

            if ($property instanceof \ReflectionProperty) {
                $value = $this->getPropertyFromRequest($request, $propertyToSet);
                $property->setValue($command, $value);
            }
        }

        return $command;
    }

    /**
     * @param Request $request
     * @param string $propertyName
     * @return mixed
     */
    private function getPropertyFromRequest(Request $request, string $propertyName)
    {
        $requestPropertyName = StringFormat::toSnakeCase($propertyName);
        $value = ($request->files->has($requestPropertyName))
            ? $request->files->get($requestPropertyName)
            : $request->get($requestPropertyName);

        return is_array($value)? $value : json_decode($value, true) ?? $value;
    }
}
