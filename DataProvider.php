<?php

namespace Openprovider\Vat;

class DataProvider
{
    protected $providerJurisdiction = null;
    protected $providerCountry = null;
    protected $customerJurisdiction = null;
    protected $customerVatNumber = null;
    protected $customerCountry = null;
    protected $activeDate = null;
    protected $typeVat = 'standard';


    public function getProviderJurisdiction()
    {
        return $this->providerJurisdiction;
    }

    public function setProviderJurisdiction($value)
    {
        $this->providerJurisdiction = strtoupper($value);
    }

    public function getProviderCountry()
    {
        return $this->providerCountry;
    }

    public function setProviderCountry($value)
    {
        $this->providerCountry = strtoupper($value);
    }

    public function getCustomerJurisdiction()
    {
        return $this->customerJurisdiction;
    }

    public function setCustomerJurisdiction($value)
    {
        $this->customerJurisdiction = strtoupper($value);
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
        $this->customerCountry = strtoupper($value);
    }

    public function getActiveDate()
    {
        return $this->activeDate;
    }

    public function setActiveDate($value)
    {
        $this->activeDate = $value;
    }

    public function getTypeVat()
    {
        return $this->typeVat;
    }

    public function setTypeVat($value)
    {
        $this->typeVat = $value;
    }
}
