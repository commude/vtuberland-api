<?php

namespace App\Utils;

class PriceUtils
{
    /**
     * Get price excluding tax.
     *
     * @param int $price
     * @return int
     */
    public static function toWithoutTax($price)
    {
        return ceil($price / (1 + (config('pricing.tax-rate') * 0.01)));
    }

    /**
     * Get tax.
     *
     * @param int $price
     * @return int
     */
    public static function toTax($price)
    {
        return $price - self::toWithoutTax($price);
    }

    /**
     * Get rental price.
     *
     * @return int
     */
    public static function rentalPrice()
    {
        return config('services.price.rental-price');
    }

    /**
     * Get rental price text.
     *
     * @return int
     */
    public static function rentalPriceText()
    {
        return number_format(self::rentalPrice());
    }

    /**
     * Get monthly rental price.
     *
     * @return int
     */
    public static function monthlyRentalPrice()
    {
        return self::rentalPrice() / 2;
    }

    /**
     * Get monthly rental price text.
     *
     * @return string
     */
    public static function monthlyRentalPriceText()
    {
        return number_format(self::monthlyRentalPrice());
    }

    /**
     * Get monthly rental price without tax.
     *
     * @return int
     */
    public static function monthlyRentalPriceWithoutTax()
    {
        return self::toWithoutTax(self::monthlyRentalPrice());
    }

    /**
     * Get monthly rental price without tax text.
     *
     * @return int
     */
    public static function monthlyRentalPriceWithoutTaxText()
    {
        return number_format(self::monthlyRentalPriceWithoutTax());
    }

    /**
     * Get monthly rental price with additional shipment text.
     *
     * @return string
     */
    public static function monthlyRentalPriceWithAdditionalShipmentText()
    {
        return number_format(self::monthlyRentalPrice() + 500);
    }
}
