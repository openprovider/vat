<?php

namespace Openprovider\Vat;

use Openprovider\Vat\Config;

class VatCalculator
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

    public function calculate()
    {
        $data = Config::get();
        $vatData = $data['vat'];
        $pj = $this->getProviderJurisdiction();
        if (!array_key_exists($pj, $vatData)) {
            throw new \Exception(
                "Incorrect value '{$pj}' for provider jurisdiction"
            );
        }

        $provider = $vatData[$pj];
        $cj = $this->getCustomerJurisdiction();
        if (!array_key_exists($cj, $provider)) {
            if ($pj == 'EU') {
                return 0;
            } else {
                throw new \Exception(
                    "Incorrect value '{$cj}' for customer jurisdiction"
                );
            }
        }

        $vat = null;
        $customerVat = $provider[$cj];
        switch ($pj) {
            case 'EU':
                if ($this->getCustomerVatNumber()) {
                    // B2B deal
                    $jurisdData = $data['jurisdiction'];
                    if (!in_array($this->getProviderCountry(), $jurisdData[$pj])) {
                        throw new \Exception(
                            "Incorrect country value '{$this->getProviderCountry()}' for provider jurisdiction"
                        );
                    }
                    if ($this->getCustomerCountry() == $this->getProviderCountry()) {
                        $vat = $this->searchActiveVat($customerVat);
                    } else {
                        $vat = 0;
                    }
                } else {
                    $vat = $this->searchActiveVat($customerVat);
                }
                break;
            case 'RU':
                $vat = $this->searchActiveVat($customerVat);
                break;
            default :
                throw new \Exception(
                    "Incorrect value '{$pj}' for provider jurisdiction"
                );
        }

        return $vat;
    }

    private function searchActiveVat($customerVat)
    {
        $activeDate = $this->getActiveDate();
        if (!$activeDate) {
            $activeDate = date("Y-m-d");
        }
        if (!array_key_exists($this->getCustomerCountry(), $customerVat)) {
            throw new \Exception(
                "Incorrect value '{$this->getCustomerCountry()}' for customer country"
            );
        }
        $periods = $customerVat[$this->getCustomerCountry()]['periods'];
        $keys = array_keys($periods);
        sort($keys);
        $activePeriod = null;
        foreach ($keys as $key) {
            if ($activeDate >= $key) {
                $activePeriod = $key;
            } else {
                break;
            }
        }

        if (is_null($activePeriod)) {
            throw new \Exception("VAT is not found for the current period");
        }
        if (empty($periods[$activePeriod][$this->getTypeVat()])) {
            throw new \Exception("VAT '{$this->getTypeVat()}' is not defined");
        }

        return $periods[$activePeriod][$this->getTypeVat()];
    }
}