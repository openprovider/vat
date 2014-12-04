<?php

namespace Openprovider\Vat\Tests;

use Openprovider\Vat\TestManager;
use Openprovider\Vat\VatCalculator;

class VatCalculatorTestCase extends \PHPUnit_Framework_TestCase
{
    public function testCalculator()
    {
        $tm = new TestManager();
        $providerJurisdiction = 'EU';
        $customerJurisdiction = 'EU';
        $customerCountry = 'NL';

        $calc = new VatCalculator();
        $calc->setProviderJurisdiction($providerJurisdiction);
        $calc->setCustomerJurisdiction($customerJurisdiction);
        $calc->setCustomerCountry($customerCountry);

        $this->assertEquals(
            $calc->calculate(),
            $tm->getVat($providerJurisdiction, $customerJurisdiction, $customerCountry)
        );
    }
}