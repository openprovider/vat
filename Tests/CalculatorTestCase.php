<?php

namespace Openprovider\Vat\Tests;

use Openprovider\Vat\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Calculator
     */
    protected $calc;

    protected function setUp()
    {
        parent::setUp();
        $vat = json_decode(file_get_contents(__DIR__ . '/../data/vat.json'), true);
        $this->calc = new Calculator($vat['rates'], '2014-12-12', ['NL', 'LU', 'DE']);
    }

    public function testNlNlB2c()
    {
        $vat = $this->calc->calculate('nl', 'nl', false);
        $this->assertEquals(21, $vat);
    }

    public function testNlNlB2b()
    {
        $vat = $this->calc->calculate('nl', 'nl', true);
        $this->assertEquals(21, $vat);
    }

    public function testNlLuB2c()
    {
        $vat = $this->calc->calculate('nl', 'lu', false);
        $this->assertEquals(15, $vat);
    }

    public function testNlLuB2b()
    {
        $vat = $this->calc->calculate('nl', 'lu', true);
        $this->assertEquals(0, $vat);
    }

    public function testRuRu()
    {
        $vat = $this->calc->calculate('ru', 'ru', true);
        $this->assertEquals(18, $vat);
    }

    public function testGrGr()
    {
        $vat = $this->calc->calculate('nl', 'gr', true);
        $this->assertEquals(0, $vat);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testOnlyRuCustomerForRuProvider()
    {
        $this->calc->calculate('ru', 'lu', true);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNotSupportedCountryForProvider()
    {
        $this->calc->calculate('us', 'nl', false);
    }

    public function testNotEuCustomer()
    {
        $vat = $this->calc->calculate('nl', 'us', false);
        $this->assertEquals(0, $vat);
    }

    public function testVatExemption()
    {
        $this->calc->setProvince('Büsingen');
        $vat = $this->calc->calculate('nl', 'de', false);
        $this->assertEquals(0, $vat);
    }
}
