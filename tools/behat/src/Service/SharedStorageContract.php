<?php declare(strict_types=1);

namespace Tools\Behat\Service;

interface SharedStorageContract
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $value): void;

    public function has(string $key): bool;
}