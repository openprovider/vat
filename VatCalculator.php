<?php

namespace Openprovider\Vat;

use Openprovider\Vat\Config;
use Openprovider\Vat\DataProvider;

class VatCalculator
{
    public function calculate(DataProvider $dataProvider, $typeVat = 'standard')
    {
        $data = Config::get();
        $vatData = $data['vat'];
        $pj = $dataProvider->getProviderJurisdiction();
        if (!array_key_exists($pj, $vatData)) {
            throw new \Exception(
                "Incorrect value '{$pj}' for provider jurisdiction"
            );
        }

        $provider = $vatData[$pj];
        $cj = $dataProvider->getCustomerJurisdiction();
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
        $customer = $provider[$cj];
        switch ($pj) {
            case 'EU':
                if ($dataProvider->getCustomerVatNumber()) {
                    // B2B deal
                    $jurisdData = $data['jurisdiction'];
                    if (!in_array($dataProvider->getProviderCountry(), $jurisdData[$pj])) {
                        throw new \Exception(
                            "Incorrect country value '{$dataProvider->getProviderCountry()}' for provider jurisdiction"
                        );
                    }
                    if ($dataProvider->getCustomerCountry() == $dataProvider->getProviderCountry()) {
                        $vat = $this->searchActiveVat($dataProvider, $customer);
                    } else {
                        $vat = 0;
                    }
                } else {
                    $vat = $this->searchActiveVat($dataProvider, $customer);
                }
                break;
            case 'RU':
                $vat = $this->searchActiveVat($dataProvider, $customer);
                break;
            default :
                throw new \Exception(
                    "Incorrect value '{$pj}' for provider jurisdiction"
                );
        }

        return $vat;
    }

    private function searchActiveVat(DataProvider $dataProvider, $customerVat)
    {
        $activeDate = $dataProvider->getActiveDate();
        if (!$activeDate) {
            $activeDate = date("Y-m-d");
        }
        if (!array_key_exists($dataProvider->getCustomerCountry(), $customerVat)) {
            throw new \Exception(
                "Incorrect value '{$dataProvider->getCustomerCountry()}' for customer country"
            );
        }
        $periods = $customerVat[$dataProvider->getCustomerCountry()]['periods'];
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
        if (empty($periods[$activePeriod][$dataProvider->getTypeVat()])) {
            throw new \Exception("VAT '{$dataProvider->getTypeVat()}' is not defined");
        }

        return $periods[$activePeriod][$dataProvider->getTypeVat()];
    }
}