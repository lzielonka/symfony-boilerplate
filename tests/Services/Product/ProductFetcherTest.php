<?php

namespace Services\Product;

use AppBundle\Database\Propel\Model\Product;
use AppBundle\Repositories\Interfaces\ProductRepositoryInterface;
use AppBundle\Services\Product\ProductFetcher;
use PHPUnit_Framework_MockObject_MockObject;
use Propel\Runtime\Collection\ObjectCollection;
use Tests\Stubs\ObjectCollectionStub;
use Tests\Stubs\Product\ProductStub;

class ProductFetcherTest extends \PHPUnit_Framework_TestCase
{
    /** @var ProductFetcher */
    private $productFetcher;
    /** @var ProductRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
    private $productRepository;

    public function setUp()
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->productFetcher = new ProductFetcher($this->productRepository);
    }

    public function testFetchAll(): void
    {
        $oc = new ObjectCollectionStub;
        $oc->append(new ProductStub);

        $this->productRepository
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($oc);

        /** @var ObjectCollection $result */
        $result = $this->productFetcher->fetchAll();

        $this->assertInstanceOf(ObjectCollection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Product::class, $result->getFirst());
    }

    public function testFetchOneById(): void
    {
        $this->productRepository
            ->expects($this->once())
            ->method('fetchOneById')
            ->willReturn(new ProductStub);

        $result = $this->productFetcher->fetchOneById(1);

        $this->assertInstanceOf(ProductStub::class, $result);
    }

    public function testFetchLatestProducts(): void
    {
        $page = 3;
        $this->productRepository
            ->expects($this->once())
            ->method('fetchLatestProducts')
            ->with($page, ProductFetcher::DEFAULT_PAGE_SIZE);

       $this->productFetcher->fetchLatestProducts($page);
    }
}