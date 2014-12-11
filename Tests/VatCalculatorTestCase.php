<?php

namespace Openprovider\Vat\Tests;

use Openprovider\Vat\VatCalculator;
use Openprovider\Vat\VatManager;

class VatCalculatorTestCase extends \PHPUnit_Framework_TestCase
{
    public function testCalculator()
    {
        $providerJurisdiction = 'EU';
        $customerJurisdiction = 'EU';
        $customerCountry = 'NL';

        $calc = new VatCalculator();
        $calc->setProviderJurisdiction($providerJurisdiction);
        $calc->setCustomerJurisdiction($customerJurisdiction);
        $calc->setCustomerCountry($customerCountry);

        $this->assertEquals(
            $calc->calculate(),
            VatManager::getVat(
                $providerJurisdiction, $customerJurisdiction, $customerCountry
            )
        );
    }
}