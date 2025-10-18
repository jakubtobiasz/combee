<?php declare(strict_types=1);

namespace Tools\Behat\Extension\Container;

use Behat\Behat\Context\Argument\ArgumentResolver;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionClass;
use ReflectionNamedType;

final class IlluminateArgumentResolver implements ArgumentResolver
{
    public function __construct(
        private readonly IlluminateContainer $container,
    ) {
    }

    /**
     * Resolves constructor arguments for context classes using Laravel Container
     */
    public function resolveArguments(ReflectionClass $classReflection, array $arguments): array
    {
        $constructor = $classReflection->getConstructor();

        if ($constructor === null) {
            return [];
        }

        $resolvedArguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterName = $parameter->getName();

            // If an argument was explicitly provided, use it
            if (array_key_exists($parameterName, $arguments)) {
                $resolvedArguments[$parameterName] = $arguments[$parameterName];
                continue;
            }

            // Try to resolve from the container
            $type = $parameter->getType();

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $className = $type->getName();

                try {
                    $resolvedArguments[$parameterName] = $this->container->make($className);
                    continue;
                } catch (BindingResolutionException $e) {
                    // If we can't resolve it, check if parameter has a default value
                    if ($parameter->isDefaultValueAvailable()) {
                        $resolvedArguments[$parameterName] = $parameter->getDefaultValue();
                        continue;
                    }

                    // If it's optional (nullable), pass null
                    if ($parameter->allowsNull()) {
                        $resolvedArguments[$parameterName] = null;
                        continue;
                    }

                    // Otherwise, let it fail with a meaningful message
                    throw new BindingResolutionException(
                        sprintf(
                            'Unable to resolve argument "%s" of type "%s" for context class "%s"',
                            $parameterName,
                            $className,
                            $classReflection->getName()
                        )
                    );
                }
            }

            // For built-in types or parameters without type hints, check for defaults
            if ($parameter->isDefaultValueAvailable()) {
                $resolvedArguments[$parameterName] = $parameter->getDefaultValue();
            } elseif ($parameter->allowsNull()) {
                $resolvedArguments[$parameterName] = null;
            }
        }

        return $resolvedArguments;
    }
}
