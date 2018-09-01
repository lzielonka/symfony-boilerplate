<?php

namespace AppBundle\Services\Product;

class CurrencyResolver
{
    /** @var string  */
    private $appLocale;

    /**
     * CurrencyResolver constructor.
     * @param string $appLocale
     */
    public function __construct(string $appLocale)
    {
        $this->appLocale = $appLocale;
    }

    public function resolveProductCurrency(): ?string
    {
        switch ($this->appLocale) {
            case 'pl':
                return 'PLN';
            case 'us':
                return 'USD';
            case 'en':
                return 'GBP';
            case 'nl':
            case 'it':
            case 'de':
            case 'be':
            case 'fr':
                return 'EUR';
            default:
                return '';
        }
    }
}