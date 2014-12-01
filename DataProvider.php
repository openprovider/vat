<?php

namespace Openprovider\Vat;

class DataProvider
{
    protected $providerJurisdiction = null;
    protected $providerCountry = null;
    protected $customerJurisdiction = null;
    protected $customerVatNumber = null;
    protected $customerCountry = null;
    protected $activeDate = '0000-01-01';


    public function getProviderJurisdiction()
    {
        return $this->providerJurisdiction;
    }

    public function setProviderJurisdiction($value)
    {
        $this->providerJurisdiction = $value;
    }

    public function getProviderCountry()
    {
        return $this->providerCountry;
    }

    public function setProviderCountry($value)
    {
        $this->providerCountry = $value;
    }

    public function getCustomerJurisdiction()
    {
        return $this->customerJurisdiction;
    }

    public function setCustomerJurisdiction($value)
    {
        $this->customerJurisdiction = $value;
    }

    public function getCustomerVatNumber()
    {
        return $this->customerVatNumber;
    }

    public function setCustomerVatNumber($value)
    {
        $this->customerVatNumber = $value;
    }

    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    public function setCustomerCountry($value)
    {
        $this->customerCountry = $value;
    }

    public function getActiveDate()
    {
        return $this->activeDate;
    }

    public function setActiveDate($value)
    {
        $this->activeDate = $value;
    }
}
