<?php

class Coffee
{
    const COFFEE_PRICE_EUR = 2.00;

    /**
     * Get coffee price
     * @return float
     */
    public function getPrice(): float
    {
        return self::COFFEE_PRICE_EUR;
    }
}

class Decorator
{
    protected $ingredient;

    /**
     * Decorator constructor.
     * @param object $ingredient
     */
    public function __construct(object $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    /**
     * Get ingredient cost
     * @return float
     */
    public function getCurrentPrice(): float
    {
        return $this->getIngredient()->getPrice();
    }

    /**
     * Get ingredient object
     * @return object
     */
    protected function getIngredient(): object
    {
        return $this->ingredient;
    }
}

class Cup extends Decorator
{
    const MILK_PRICE_EUR = 0.50;

    /**
     * Add milk to the cup
     * @param int $amount
     * @return float
     */
    public function addMilk(int $amount = 1): float
    {
        /*
         * Two solutions for calculating money:
         * 1) EUR & bcmath, because 0.1 + 0.2 != 0.3, but bcadd(0.1, 0.2, 2) == 0.3
         * 2) cents & easy +/-, because 10 cents + 20 cents == 30 cents
         */
        $cost = bcmul(self::MILK_PRICE_EUR, $amount, 2);
        return bcadd(parent::getCurrentPrice(), $cost, 2);
    }
}

$coffee = new Coffee;
$cup = new Cup($coffee);
echo $cup->addMilk();