<?php

namespace Openprovider\Vat;

use Openprovider\Vat;

class VatManager
{
    public static function getVat(
        $providerJurisdiction, $customerJurisdiction, $customerCountry,
        $period = null, $typeVat = 'standard'
    )
    {
        $data = Config::get();

        $pj = strtoupper($providerJurisdiction);
        $cj = strtoupper($customerJurisdiction);
        $cc = strtoupper($customerCountry);
        if (!isset($data[$pj][$cj][$cc]['periods'])) {
            throw new \Exception("Incorrect values: '{$pj}', '{$cj}', '{$cc}'");
        }

        $periods = $data[$pj][$cj][$cc]['periods'];
        $activePeriod = $period ? $period : self::searchActivePeriod($periods);
        if (!isset($periods[$activePeriod][$typeVat])) {
            throw new \Exception("Incorrect values: '{$activePeriod}', '{$typeVat}'");
        }

        return $periods[$activePeriod][$typeVat];
    }

    public static function setVat(
        $value, $providerJurisdiction, $customerJurisdiction, $customerCountry,
        $period = null, $typeVat = 'standard'
    )
    {
        $data = Config::get();

        $pj = strtoupper($providerJurisdiction);
        $cj = strtoupper($customerJurisdiction);
        $cc = strtoupper($customerCountry);
        if (empty($pj) || empty($cj) || empty($cc)) {
            throw new \Exception("Incorrect values: '{$pj}', '{$cj}', '{$cc}'");
        }
        if (!isset($data[$pj][$cj][$cc]['periods'])) {
            $data[$pj][$cj][$cc]['periods'] = [];
            Config::set($data);
        }

        $periods = $data[$pj][$cj][$cc]['periods'];
        $activePeriod = $period ? $period : self::searchActivePeriod($periods);

        $data[$pj][$cj][$cc]['periods'][$activePeriod][$typeVat] = $value;
        Config::set($data);
    }

    private static function searchActivePeriod($periods)
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