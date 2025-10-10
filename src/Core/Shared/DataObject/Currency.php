<?php declare(strict_types=1);

namespace Combee\Core\Shared\DataObject;

use Combee\Core\Shared\Exception\InvalidArgumentException;
use Symfony\Component\Intl\Currencies;

class Currency
{
    /**
     * @phpstan-param non-empty-string $code
     *
     * @phpstan-pure
     */
    public function __construct(
        protected(set) string $code {
            get => $this->code;
            set {
                if (!Currencies::exists($value)) {
                    throw new InvalidArgumentException(sprintf('Currency "%s" does not exist.', $value));
                }

                $this->code = $value;
            }
        },
    ) {
    }

    /**
     * @phpstan-param non-empty-string $code
     *
     * @phpstan-pure
     */
    public static function new(string $code): self
    {
        return new self($code);
    }
}
