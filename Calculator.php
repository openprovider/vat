<?php

namespace Openprovider\Vat;

class Calculator
{
    /**
     * @var array
     */
    protected $euCountries = [];

    /**
     * @var array
     */
    protected $rates = [];

    /**
     * @var string
     */
    protected $effectiveDate;

    /**
     * @param array $rates see http://jsonvat.com/ for details
     * @param string $effectiveDate format 'Y-m-d'
     * @param array $euCountries List of country codes
     */
    function __construct(array $rates, $effectiveDate, array $euCountries)
    {
        $this->effectiveDate = $effectiveDate;
        $this->euCountries = $euCountries;

        $this->rates = [];
        foreach ($rates as $country) {
            $periods = $country['periods'];
            // sort periods by effective_from desc
            usort($periods, function ($a, $b) {
                if ($a['effective_from'] == $b['effective_from']) {
                    return 0;
                }
                return ($a['effective_from'] < $b['effective_from']) ? 1 : -1;
            });
            $country['periods'] = $periods;

            $this->rates[$country['code']] = $country;
        }
    }

    /**
     * @param string $providerCountry
     * @param string $customerCountry
     * @param bool $isB2b
     * @return mixed
     */
    public function calculate($providerCountry, $customerCountry, $isB2b)
    {
        $providerCountry = strtoupper($providerCountry);
        $customerCountry = strtoupper($customerCountry);

        if ($this->isEuCountry($providerCountry)) {
            return $this->calculateEuVat($providerCountry, $customerCountry, $isB2b);
        }

        if ($providerCountry == 'RU') {
            return $this->calculateRuVat($providerCountry, $customerCountry);
        }

        throw new \RuntimeException("Country '$providerCountry' not allowed for provider.");
    }

    protected function calculateEuVat($providerCountry, $customerCountry, $isB2b)
    {
        if (!$this->isEuCountry($customerCountry)) {
            return 0;
        }

        if ($isB2b && $providerCountry != $customerCountry) {
            return 0;
        }

        return $this->searchEffectiveVat($customerCountry, $this->effectiveDate);
    }

    protected function calculateRuVat($providerCountry, $customerCountry)
    {
        if ($customerCountry != 'RU') {
            throw new \RuntimeException("Country '$customerCountry' not allowed for customer.");
        }

        return $this->searchEffectiveVat($providerCountry, $this->effectiveDate);
    }

    protected function isEuCountry($countryCode)
    {
        return in_array($countryCode, $this->euCountries);
    }

    /**
     * @param string $countryCode
     * @param string $effectiveDate
     * @return number
     */
    protected function searchEffectiveVat($countryCode, $effectiveDate)
    {
        if (isset($this->rates[$countryCode])) {
            $country = $this->rates[$countryCode];
            foreach ($country['periods'] as $period) {
                if ($period['effective_from'] < $effectiveDate) {
                    return $period['rates']['standard'];
                }
            }

            throw new \RuntimeException("Not found period for '$countryCode' country.");
        }

        throw new \RuntimeException("VAT rate not found for '$countryCode' country.");
    }

    /**
     * @return string
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * @param string $effectiveDate
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;
    }
}