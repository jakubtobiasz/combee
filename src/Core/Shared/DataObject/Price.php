<?php declare(strict_types=1);

namespace Combee\Core\Shared\DataObject;

use Combee\Core\Shared\Exception\InvalidArgumentException;
use Money\Money;

final class Price
{
    private readonly Money $backedValue;

    /** @var numeric-string */
    public string $amount {
        get => $this->backedValue->getAmount();
    }

    public bool $isZero {
        get => $this->backedValue->isZero();
    }

    public bool $isPositive {
        get => $this->backedValue->isPositive();
    }

    public bool $isNegative {
        get => $this->backedValue->isNegative();
    }

    /**
     * @param int|string $amount Amount, expressed in the smallest units of $currency (eg cents)
     * @phpstan-param int|numeric-string $amount
     *
     * @throws InvalidArgumentException If the amount is not integer(ish).
     *
     * @phpstan-pure
     */
    public function __construct(int|string $amount, public readonly Currency $currency)
    {
        try {
            $this->backedValue = new Money($amount, new \Money\Currency($currency->code));
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int|string $amount Amount, expressed in the smallest units of $currency (eg cents)
     * @phpstan-param int|numeric-string $amount
     *
     * @throws InvalidArgumentException If the amount is not integer(ish).
     *
     * @phpstan-pure
     */
    public static function new(int|string $amount, Currency $currency): self
    {
        return new self($amount, $currency);
    }

    private static function fromBackedValue(Money $backedValue): self
    {
        return new self($backedValue->getAmount(), new Currency($backedValue->getCurrency()->getCode()));
    }

    public function add(Price $other): Price
    {
        $newPrice = $this->backedValue->add($other->backedValue);

        return Price::fromBackedValue($newPrice);
    }

    public function subtract(Price $other): Price
    {
        $newPrice = $this->backedValue->subtract($other->backedValue);

        return Price::fromBackedValue($newPrice);
    }

    public function multiply(int $multiplier): Price
    {
        $newPrice = $this->backedValue->multiply($multiplier);

        return Price::fromBackedValue($newPrice);
    }

    public function divide(int $divisor): Price
    {
        $newPrice = $this->backedValue->divide($divisor);

        return Price::fromBackedValue($newPrice);
    }

    public function mod(int $divisor): Price
    {
        $newPrice = $this->backedValue->mod($divisor);

        return Price::fromBackedValue($newPrice);
    }

    public function equals(Price $other): bool
    {
        return $this->backedValue->equals($other->backedValue);
    }
}
