<?php

namespace Openprovider\Vat\Tests;

use Openprovider\Vat;

class TestManagerTestCase extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $value = 17;
        $providerJurisdiction = 'RU';
        $customerJurisdiction = 'RU';
        $customerCountry = 'RU';
        Vat\VatManager::setVat(
            $value, $providerJurisdiction, $customerJurisdiction, $customerCountry
        );

        $this->assertEquals(
            $value,
            Vat\VatManager::getVat(
                $providerJurisdiction, $customerJurisdiction, $customerCountry
            )
        );
    }

    public function testException()
    {
        $value = 17;
        $providerJurisdiction = 'RU';
        $customerJurisdiction = 'RU';
        $customerCountry = null;
        try {
            Vat\VatManager::setVat(
                $value, $providerJurisdiction, $customerJurisdiction, $customerCountry
            );
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}