<?php

namespace Openprovider\Vat\Tests;

use Openprovider\Vat\TestManager;

class TestManagerTestCase extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $tm = new TestManager();
        $value = 17;
        $providerJurisdiction = 'RU';
        $customerJurisdiction = 'RU';
        $customerCountry = 'RU';
        $tm->setVat($value, $providerJurisdiction, $customerJurisdiction, $customerCountry);

        $this->assertEquals($value, $tm->getVat($providerJurisdiction, $customerJurisdiction, $customerCountry));
    }

    public function testException()
    {
        $tm = new TestManager();
        $value = 17;
        $providerJurisdiction = 'RU';
        $customerJurisdiction = 'RU';
        $customerCountry = null;
        try {
            $tm->setVat($value, $providerJurisdiction, $customerJurisdiction, $customerCountry);
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}