<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesFixture
 *
 */
class CountriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'code' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Two-letter country code (ISO 3166-1 alpha-2)', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'English country name', 'precision' => null, 'fixed' => null],
        'full_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Full English country name', 'precision' => null, 'fixed' => null],
        'iso3' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Three-letter country code (ISO 3166-1 alpha-3)', 'precision' => null],
        'number' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'Three-digit country number (ISO 3166-1 numeric)', 'precision' => null, 'autoIncrement' => null],
        'continent_code' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'continent_code' => ['type' => 'index', 'columns' => ['continent_code'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['code'], 'length' => []],
            'fk_countries_continents' => ['type' => 'foreign', 'columns' => ['continent_code'], 'references' => ['continents', 'code'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'code' => 'c2a98b1e-339c-4d10-9c38-f6c096d50d35',
            'name' => 'Lorem ipsum dolor sit amet',
            'full_name' => 'Lorem ipsum dolor sit amet',
            'iso3' => 'L',
            'number' => 1,
            'continent_code' => ''
        ],
    ];
}
