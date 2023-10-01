<?php

namespace App;

use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money as BrickMoney;

class Money
{
    protected \Brick\Money\Money $money;

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function __construct(string|float|null $value, string $currency = "JMD") {
        if(is_null($value)) {
            $this->money = BrickMoney::zero($currency);
            return null;
        }
        $this->money = BrickMoney::of($value, $currency);
    }

    public function __toString(): string {
        return $this->money->getAmount()->toFloat();
    }

    /**
     * @throws MathException
     */
    public function amountAsCents(): int {
        return $this->money->getMinorAmount()->toInt();
    }

    /**
     * @throws RoundingNecessaryException
     * @throws MathException
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     */
    public function amountAsDollars(): float {
        return BrickMoney::ofMinor($this->money->getAmount()->toInt(), $this->money->getCurrency()->getNumericCode())->getAmount()->toFloat();
    }
}
