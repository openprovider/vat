<?php

namespace Openprovider\Vat\Config;

class Config
{
    static private $data = array(
        // provider
        'NL' => array(
            // customer
            'EU' => array(
                // country

                'ES' => array (
                    'name' => 'Spain',
                    'periods' => array (
                        // effective_from => rates
                        '0000-01-01' => array (
                            'super_reduced' => 4,
                            'reduced' => 10,
                            'standard' => 21,
                        ),
                    ),
                ),

                'LU' => array (
                    'name' => 'Luxembourg',
                    'periods' => array (
                        '0000-01-01' => array (
                            'super_reduced' => 3,
                            'reduced1' => 6,
                            'reduced2' => 12,
                            'standard' => 15,
                            'parking' => 12,
                        ),
                    ),
                ),

                'LT' => array (
                    'name' => 'Luthuania',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 9,
                            'standard' => 21,
                        ),
                    ),
                ),

                'FI' => array (
                    'name' => 'Finland',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 10,
                            'reduced2' => 14,
                            'standard' => 24,
                        ),
                    ),
                ),

                'CY' => array (
                    'name' => 'Cyprus',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 9,
                            'standard' => 19,
                        ),
                    ),
                ),

                'AT' => array (
                    'name' => 'Austria',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 10,
                            'standard' => 20,
                            'parking' => 12,
                        ),
                    ),
                ),

                'CZ' => array (
                    'name' => 'Czech Republic',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 15,
                            'standard' => 21,
                        ),
                    ),
                ),

                'IE' => array (
                    'name' => 'Ireland',
                    'periods' => array (
                        '0000-01-01' => array (
                            'super_reduced' => 4.7999999999999998,
                            'reduced1' => 9,
                            'reduced2' => 13.5,
                            'standard' => 23,
                            'parking' => 13.5,
                        ),
                    ),
                ),

                'GB' => array (
                    'name' => 'United Kingdom',
                    'periods' => array (
                        '2011-01-04' => array (
                            'standard' => 20,
                            'reduced' => 5,
                        ),
                    ),
                ),

                'SE' => array (
                    'name' => 'Sweden',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 6,
                            'reduced2' => 12,
                            'standard' => 25,
                        ),
                    ),
                ),

                'BE' => array (
                    'name' => 'Belgium',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 6,
                            'reduced2' => 12,
                            'standard' => 21,
                            'parking' => 12,
                        ),
                    ),
                ),

                'IT' => array (
                    'name' => 'Italy',
                    'periods' => array (
                        '0000-01-01' => array (
                            'super_reduced' => 4,
                            'reduced' => 10,
                            'standard' => 22,
                        ),
                    ),
                ),

                'PL' => array (
                    'name' => 'Poland',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 8,
                            'standard' => 23,
                        ),
                    ),
                ),

                'LV' => array (
                    'name' => 'Latvia',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 12,
                            'standard' => 21,
                        ),
                    ),
                ),

                'HU' => array (
                    'name' => 'Hungary',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 18,
                            'standard' => 27,
                        ),
                    ),
                ),

                'RO' => array (
                    'name' => 'Romania',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 9,
                            'standard' => 24,
                        ),
                    ),
                ),

                'DE' => array (
                    'name' => 'Germany',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 7,
                            'standard' => 19,
                        ),
                    ),
                ),

                'DK' => array (
                    'name' => 'Denmark',
                    'periods' => array (
                        '0000-01-01' => array (
                            'standard' => 25,
                        ),
                    ),
                ),

                'EE' => array (
                    'name' => 'Estonia',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 9,
                            'standard' => 20,
                        ),
                    ),
                ),

                'HR' => array (
                    'name' => 'Croatia',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 13,
                            'standard' => 25,
                        ),
                    ),
                ),

                'BG' => array (
                    'name' => 'Bulgaria',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 9,
                            'standard' => 20,
                        ),
                    ),
                ),

                'MT' => array (
                    'name' => 'Malta',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 5,
                            'reduced2' => 7,
                            'standard' => 18,
                        ),
                    ),
                ),

                'FR' => array (
                    'name' => 'France',
                    'periods' => array (
                        '0000-01-01' => array (
                            'super_reduced' => 2.1000000000000001,
                            'reduced1' => 5.5,
                            'reduced2' => 10,
                            'standard' => 20,
                        ),
                    ),
                ),

                'SK' => array (
                    'name' => 'Slovakia',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 10,
                            'standard' => 20,
                        ),
                    ),
                ),

                'PT' => array (
                    'name' => 'Portugal',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 6,
                            'reduced2' => 13,
                            'standard' => 23,
                            'parking' => 13,
                        ),
                    ),
                ),

                'NL' => array (
                    'name' => 'Netherlands',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 6,
                            'standard' => 21,
                        ),
                    ),
                ),

                'SI' => array (
                    'name' => 'Slovenia',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced' => 9.5,
                            'standard' => 22,
                        ),
                    ),
                ),

                'EL' => array (
                    'name' => 'Greece',
                    'periods' => array (
                        '0000-01-01' => array (
                            'reduced1' => 6.5,
                            'reduced2' => 13,
                            'standard' => 23,
                        ),
                    ),
                ),

            ),
        ),

        'RU' => array(

        ),
    );

    static public function get()
    {
        return self::$data;
    }
}
