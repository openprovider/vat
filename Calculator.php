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
     * @var string
     */
    protected $providerCountry;

    /**
     * @var bool
     */
    protected $isB2b;

    /**
     * @var string - country code
     */
    protected $customerCountry;

    /**
     * @var string
     */
    protected $province;

    private $vatExemption;

    /**
     * @param array $rates see http://jsonvat.com/ for details
     * @param string $effectiveDate format 'Y-m-d'
     * @param array $euCountries List of country codes
     */
    function __construct($effectiveDate, array $euCountries)
    {
        $file = __DIR__ . '/data/vat.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            $rates = $data['rates'];
        } else {
            throw new \InvalidArgumentException('Rates can not be empty.');
        }

        $file = __DIR__ . '/data/vatExemption.json';
        $data = json_decode(file_get_contents($file), true);
        $this->vatExemption = $data['list'];

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
    public function calculate()
    {
        if ($this->isEuCountry($this->getProviderCountry())) {
            return $this->calculateEuVat();
        }

        if ($this->getProviderCountry() == 'RU') {
            return $this->calculateRuVat();
        }

        throw new \RuntimeException("Country '{$this->getProviderCountry()}' not allowed for provider.");
    }

    protected function calculateEuVat()
    {
        if ($this->checkProvincesEu()) {
            return 0;
        }

        if (!$this->isEuCountry($this->getCustomerCountry())) {
            return 0;
        }

        if ($this->getIsB2b() && $this->getProviderCountry() != $this->getCustomerCountry()) {
            return 0;
        }

        return $this->searchEffectiveVat($this->getCustomerCountry(), $this->getEffectiveDate());
    }

    protected function calculateRuVat()
    {
        if ($this->getCustomerCountry() != 'RU') {
            throw new \RuntimeException("Country '{$this->getCustomerCountry()}' not allowed for customer.");
        }

        return $this->searchEffectiveVat($this->getProviderCountry(), $this->getEffectiveDate());
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

            throw new \RuntimeException("Not found period for '{$countryCode}' country.");
        }

        throw new \RuntimeException("VAT rate not found for '{$countryCode}' country.");
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

    /**
     * @return bool
     */
    public function getIsB2b()
    {
        return $this->isB2b;
    }

    /**
     * @param bool $isB2b
     */
    public function setIsB2b($isB2b)
    {
        $this->isB2b = $isB2b;
    }

    /**
     * @return string
     */
    public function getProviderCountry()
    {
        return $this->providerCountry;
    }

    /**
     * @param string $providerCountry
     */
    public function setProviderCountry($providerCountry)
    {
        $this->providerCountry = strtoupper($providerCountry);
    }

    /**
     * @return string
     */
    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    /**
     * @param string $customerCountry
     */
    public function setCustomerCountry($customerCountry)
    {
        $this->customerCountry = strtoupper($customerCountry);
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = strtoupper($province);
    }

    private function checkProvincesEu()
    {
        return $this->getProvince()
            && array_key_exists($this->getCustomerCountry(), $this->vatExemption)
            && in_array($this->getProvince(), $this->vatExemption[$this->getCustomerCountry()]['provinces']);
    }
}
