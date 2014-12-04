<?php

namespace Openprovider\Vat;

use Openprovider\Vat\Config;

class TestManager
{
    private $data = null;

    public function __construct() {
        $this->data = Config::get();
    }

    public function getVat(
        $providerJurisdiction,
        $customerJurisdiction,
        $customerCountry,
        $period = null,
        $typeVat = 'standard'
    )
    {
        $pj = strtoupper($providerJurisdiction);
        $cj = strtoupper($customerJurisdiction);
        $cc = strtoupper($customerCountry);
        if (!isset($this->data[$pj][$cj][$cc]['periods'])) {
            throw new \Exception(__METHOD__.": Incorrect values('{$pj}', '{$cj}', '{$cc}')");
        }

        $periods = $this->data[$pj][$cj][$cc]['periods'];
        $activePeriod = $period ? $period : $this->searchActivePeriod($periods);
        if (!isset($periods[$activePeriod][$typeVat])) {
            throw new \Exception(__METHOD__.": Incorrect values('{$activePeriod}', '{$typeVat}')");
        }

        return $periods[$activePeriod][$typeVat];
    }

    public function setVat(
        $value,
        $providerJurisdiction,
        $customerJurisdiction,
        $customerCountry,
        $period = null,
        $typeVat = 'standard'
    )
    {
        $pj = strtoupper($providerJurisdiction);
        $cj = strtoupper($customerJurisdiction);
        $cc = strtoupper($customerCountry);
        if (empty($pj) || empty($cj) || empty($cc)) {
            throw new \Exception(__METHOD__.": Incorrect values('{$pj}', '{$cj}', '{$cc}')");
        }
        if (!isset($this->data[$pj][$cj][$cc]['periods'])) {
            $this->data[$pj][$cj][$cc]['periods'] = [];
        }

        $periods = $this->data[$pj][$cj][$cc]['periods'];
        $activePeriod = $period ? $period : $this->searchActivePeriod($periods);

        $this->data[$pj][$cj][$cc]['periods'][$activePeriod][$typeVat] = $value;
    }

    private function searchActivePeriod($periods)
    {
        $activeDate = date("Y-m-d");

        $keys = array_keys($periods);
        sort($keys);
        $activePeriod = $activeDate;
        foreach ($keys as $key) {
            if ($activeDate >= $key) {
                $activePeriod = $key;
            } else {
                break;
            }
        }

        return $activePeriod;
    }
}