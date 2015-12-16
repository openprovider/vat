<?php
/**
 * Copyright 2015 Openprovider Authors. All rights reserved.
 * Use of this source code is governed by a license
 * that can be found in the LICENSE file.
 */

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
        $this->calc = new Calculator('2014-12-12', ['NL', 'LU', 'DE']);
    }

    public function testNlNlB2c()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('nl');
        $this->calc->setIsB2b(false);
        $vat = $this->calc->calculate();
        $this->assertEquals(21, $vat);
    }

    public function testNlNlB2b()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('nl');
        $this->calc->setIsB2b(TRUE);
        $vat = $this->calc->calculate();
        $this->assertEquals(21, $vat);
    }

    public function testNlLuB2c()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('lu');
        $this->calc->setIsB2b(false);
        $vat = $this->calc->calculate();
        $this->assertEquals(15, $vat);
    }

    public function testNlLuB2b()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('lu');
        $this->calc->setIsB2b(true);
        $vat = $this->calc->calculate();
        $this->assertEquals(0, $vat);
    }

    public function testRuRu()
    {
        $this->calc->setProviderCountry('ru');
        $this->calc->setCustomerCountry('ru');
        $this->calc->setIsB2b(true);
        $vat = $this->calc->calculate();
        $this->assertEquals(18, $vat);
    }

    public function testGrGr()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('gr');
        $this->calc->setIsB2b(true);
        $vat = $this->calc->calculate();
        $this->assertEquals(0, $vat);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testOnlyRuCustomerForRuProvider()
    {
        $this->calc->setProviderCountry('ru');
        $this->calc->setCustomerCountry('lu');
        $this->calc->setIsB2b(true);
        $this->calc->calculate();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNotSupportedCountryForProvider()
    {
        $this->calc->setProviderCountry('us');
        $this->calc->setCustomerCountry('nl');
        $this->calc->setIsB2b(false);
        $this->calc->calculate();
    }

    public function testNotEuCustomer()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('us');
        $this->calc->setIsB2b(false);
        $vat = $this->calc->calculate();
        $this->assertEquals(0, $vat);
    }

    public function testVatExemption()
    {
        $this->calc->setProviderCountry('nl');
        $this->calc->setCustomerCountry('de');
        $this->calc->setIsB2b(false);
        $this->calc->setProvince('Büsingen');
        $vat = $this->calc->calculate();
        $this->assertEquals(0, $vat);
    }
}
