Openprovider Calculator Vat Percent
====================


### Installation

```bash
$ composer require openprovider/vat 
```

### Usage

```php
$calc = new \Openprovider\Vat\Calculator('2015-12-16', []);
$calc->setProviderCountry('RU');
$calc->setCustomerCountry('RU');
$calc->setIsB2b(true);
$vat = $calc->calculate();
```

### Changelog

#### 1.0.3
- Rename method checkProvincesEu -> isEuExemption

#### 1.0.2
- Update unit-tests
