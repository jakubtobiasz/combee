<?php declare(strict_types=1);

namespace Combee\Core\Pricing\Contract\Exception;

use Combee\Core\Shared\Exception\Exception;

class NoSupportedCalculatorException extends Exception
{
    /**
     * @throws NoSupportedCalculatorException
     */
    public static function throw(): never
    {
        throw new self('No supported calculator found.');
    }
}
