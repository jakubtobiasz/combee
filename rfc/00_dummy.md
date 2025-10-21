# RFC 00: Dummy RFC Template

## Status
- **Status**: Draft
- **Created**: 2025-10-21
- **Author**: Example Author

## Abstract

This is a dummy RFC (Request for Comments) document that serves as a template for future RFCs in the Combee e-commerce project. It demonstrates the standard structure and format that should be followed when proposing new features, architectural changes, or significant modifications to the codebase.

## Motivation

Establishing a standardized RFC process helps maintain code quality, facilitates team collaboration, and ensures that significant changes are properly documented and reviewed before implementation. This template provides a starting point for creating well-structured technical proposals.

## Proposal

This section outlines the proposed changes or new features. For this dummy RFC, we'll demonstrate how to document a hypothetical feature: a discount system for order items.

### High-Level Design

The discount system would allow applying percentage-based or fixed-amount discounts to individual order items or entire orders. This would integrate with the existing pricing system.

### Technical Details

The implementation would involve:
1. Creating discount entities and value objects
2. Implementing discount calculation strategies
3. Integrating with the existing pricing calculator
4. Extending the order model to support discounts

## Code Examples

Below are code examples demonstrating the proposed implementation with proper PHPDoc annotations:

### Discount Value Object

```php
<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Model;

use Recode\Ecommerce\Core\Shared\DataObject\Price;

/**
 * Represents a discount that can be applied to a price.
 *
 * @author John Doe <john.doe@example.com>
 * @since 1.0.0
 */
final readonly class Discount
{
    /**
     * @param DiscountType $type The type of discount (percentage or fixed)
     * @param float $value The discount value (percentage as decimal or fixed amount)
     * @param string $code Optional discount code
     *
     * @author John Doe <john.doe@example.com>
     */
    public function __construct(
        public DiscountType $type,
        public float $value,
        public string $code = ''
    ) {
    }

    /**
     * Calculate the discounted price based on the original price.
     *
     * @param Price $originalPrice The original price before discount
     * @return Price The price after applying the discount
     *
     * @author John Doe <john.doe@example.com>
     */
    public function apply(Price $originalPrice): Price
    {
        return match ($this->type) {
            DiscountType::Percentage => $this->applyPercentage($originalPrice),
            DiscountType::Fixed => $this->applyFixed($originalPrice),
        };
    }

    /**
     * Apply a percentage-based discount.
     *
     * @param Price $price The original price
     * @return Price The discounted price
     *
     * @author John Doe <john.doe@example.com>
     */
    private function applyPercentage(Price $price): Price
    {
        $discountAmount = $price->amount * $this->value;
        return new Price(
            amount: $price->amount - $discountAmount,
            currency: $price->currency
        );
    }

    /**
     * Apply a fixed-amount discount.
     *
     * @param Price $price The original price
     * @return Price The discounted price
     *
     * @author John Doe <john.doe@example.com>
     */
    private function applyFixed(Price $price): Price
    {
        $newAmount = max(0, $price->amount - $this->value);
        return new Price(
            amount: $newAmount,
            currency: $price->currency
        );
    }
}
```

### Discount Type Enum

```php
<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Model;

/**
 * Enumeration of available discount types.
 *
 * @author Jane Smith <jane.smith@example.com>
 * @since 1.0.0
 */
enum DiscountType: string
{
    /**
     * Percentage-based discount (e.g., 0.1 for 10% off)
     *
     * @author Jane Smith <jane.smith@example.com>
     */
    case Percentage = 'percentage';

    /**
     * Fixed amount discount (e.g., 5.00 for $5 off)
     *
     * @author Jane Smith <jane.smith@example.com>
     */
    case Fixed = 'fixed';
}
```

### Discount Calculator

```php
<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Application\Calculator;

use Recode\Ecommerce\Core\Pricing\Contract\CalculatorContract;
use Recode\Ecommerce\Core\Pricing\Model\Discount;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

/**
 * Calculator that applies discounts to priceable items.
 *
 * @author Alice Johnson <alice.johnson@example.com>
 * @since 1.0.0
 */
final readonly class DiscountCalculator implements CalculatorContract
{
    /**
     * @param Discount $discount The discount to apply
     *
     * @author Alice Johnson <alice.johnson@example.com>
     */
    public function __construct(
        private Discount $discount
    ) {
    }

    /**
     * Check if this calculator supports the given priceable item.
     *
     * @param Priceable $priceable The item to check
     * @return bool True if the item can be discounted
     *
     * @author Alice Johnson <alice.johnson@example.com>
     */
    public function supports(Priceable $priceable): bool
    {
        // Example: Check if item is eligible for discount
        return $priceable->getPrice()->amount > 0;
    }

    /**
     * Calculate the discounted price for the priceable item.
     *
     * @param Priceable $priceable The item to calculate price for
     * @return Price The calculated discounted price
     *
     * @author Alice Johnson <alice.johnson@example.com>
     */
    public function calculate(Priceable $priceable): Price
    {
        $originalPrice = $priceable->getPrice();
        return $this->discount->apply($originalPrice);
    }
}
```

## Impact Analysis

### Benefits
- Provides a clear template for future RFCs
- Demonstrates proper PHPDoc annotation usage
- Shows integration with existing architecture

### Risks
- None (this is a template document)

### Alternatives Considered
- Using a different documentation format
- Not having an RFC process at all

## Implementation Plan

1. **Phase 1**: Create RFC directory structure ✓
2. **Phase 2**: Document the RFC template ✓
3. **Phase 3**: Share with team for feedback
4. **Phase 4**: Iterate based on feedback

## Open Questions

- Should we use a different format for RFCs?
- Do we need additional sections in the template?

## References

- [IETF RFC Format](https://www.rfc-editor.org/rfc/rfc7322.html)
- [PHP PSR Standards](https://www.php-fig.org/psr/)
- [PHPDoc Documentation](https://docs.phpdoc.org/)

## Appendix

### Terminology

- **RFC**: Request for Comments - a document describing a proposal
- **PHPDoc**: Documentation format for PHP code using docblock comments
- **Value Object**: An immutable object that represents a descriptive aspect of the domain

### Additional Code Examples

```php
<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Contract;

use Recode\Ecommerce\Core\Pricing\Model\Discount;

/**
 * Interface for discount providers.
 *
 * @author Bob Williams <bob.williams@example.com>
 * @since 1.0.0
 */
interface DiscountProviderContract
{
    /**
     * Get applicable discount for the given code.
     *
     * @param string $code The discount code to look up
     * @return Discount|null The discount if found, null otherwise
     *
     * @author Bob Williams <bob.williams@example.com>
     */
    public function getDiscountByCode(string $code): ?Discount;

    /**
     * Check if a discount code is valid and active.
     *
     * @param string $code The discount code to validate
     * @return bool True if the code is valid
     *
     * @author Bob Williams <bob.williams@example.com>
     */
    public function isValidCode(string $code): bool;
}
```
