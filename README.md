Openprovider VAT Percentage Calculator
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

#### 1.0.4
- Release to open source

#### 1.0.3
- Rename method checkProvincesEu -> isEuExemption

#### 1.0.2
- Update unit-tests

### Authors

* [Yuriy Vasilev](https://github.com/yuriy-vasilev)
* [Evgeniy Karagodin](https://github.com/ekaragodin)

### Contributors

All the contributors are welcome. If you would like to be the contributor please accept some rules.
- The pull requests will be accepted only in "develop" branch
- All modifications or additions should be tested

Thank you for your understanding!

### License

[MIT Public License](https://github.com/openprovider/vat/blob/master/LICENSE)
