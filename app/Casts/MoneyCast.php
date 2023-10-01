<?php

namespace App\Casts;

use App\Money;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    /**
     * Get the amount in dollars for a given value.
     *
     * @param Model $model The model instance to work with.
     * @param string $key The key to retrieve the value from.
     * @param mixed $value The value to convert to dollars.
     * @param array $attributes Additional attributes to consider.
     * @return float The amount in dollars.
     * @throws Exception|MathException If there is an error during the conversion.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): float
    {
        try {
            $money = new Money($value);
            return $money->amountAsDollars();
        } catch (NumberFormatException|RoundingNecessaryException|UnknownCurrencyException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get the dollar amount from the given value.
     *
     * @throws MathException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     * @throws UnknownCurrencyException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): float
    {
        return (new Money($value))->amountAsCents();
    }
}
