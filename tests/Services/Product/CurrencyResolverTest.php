<?php

namespace Services\Product;

use AppBundle\Services\Product\CurrencyResolver;
use Tests\PrivateAccessTestCase;

class CurrencyResolverTest extends PrivateAccessTestCase
{
    /** @var CurrencyResolver */
    private $accountFetcher;

    public function setUp()
    {
        $this->accountFetcher = new CurrencyResolver('');
    }

    /**
     * @param $locale
     * @param $expected
     * @dataProvider localeProvider
     *
     * @throws \ReflectionException
     */
    public function testResolveProductCurrency(string $locale, string $expected): void
    {
        static::setPrivatePropertyValue($this->accountFetcher, 'appLocale', $locale);
        $result = $this->accountFetcher->resolveProductCurrency();

        $this->assertEquals($expected, $result);
    }

    public function localeProvider(): array
    {
        return [
            ['', ''],
            ['abc', ''],
            ['pl', 'PLN'],
            ['us', 'USD'],
            ['en', 'GBP'],
            ['nl', 'EUR'],
            ['it', 'EUR'],
            ['de', 'EUR'],
            ['be', 'EUR'],
            ['fr', 'EUR'],
        ];
    }
}