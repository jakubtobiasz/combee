<?php declare(strict_types=1);

namespace Tools\Behat\Service;

final class SharedStorage implements SharedStorageContract
{
    private array $storage = [];

    public function get(string $key): mixed
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException(sprintf('Key "%s" does not exist in shared storage.', $key));
        }

        return $this->storage[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $this->storage[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->storage);
    }
}
