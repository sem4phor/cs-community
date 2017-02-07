<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Countries Model
 *
 * @author Valentin Rapp
 *
 */
class CountriesTable extends Table
{

    /**
     * Initialize method
     *
     * Configures the associations and other model properties.
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Continents', [
            'foreignKey' => 'continent_code'
        ]);

        $this->table('countries');
        $this->displayField('name');
        $this->primaryKey('code');
    }

    /**
     * getCountryCodesOfContinent
     *
     * Returns an array of country codes which are part of a given continent.
     *
     * @param string $continent_code The ID of a continent
     * @return array $country_codes_of_continent
     */
    public function getCountryCodesOfContinent($continent_code)
    {
        $countries_of_continent = $this->find()->select(['code'])->where(['continent_code =' => $continent_code]);
        $country_codes_of_continent = [];
        foreach ($countries_of_continent as $country) {
            array_push($country_codes_of_continent, $country->code);
        }
        return $country_codes_of_continent;
    }

    /**
     * getLocalesOfContinent
     *
     * Returns an array of locales of all countries which are part of a given continent. Each locale will be returnbed only once.
     *
     * @param string $continent_code The ID of a continent
     * @return array $locales
     */
    public function getLocalesOfContinent($continent_code)
    {
        $country_codes_of_continent = $this->getCountryCodesOfContinent($continent_code);
        $locales = [];
        foreach ($country_codes_of_continent as $key => $code) {
            $locale = explode('_', $this->country_code_to_locale($code))[0];
            if (!in_array($locale, $locales)) $locales[$locale] = $locale;
        }
        return $locales;
    }

    /**
     * country_code_to_locale
     *
     * Returns a locale from a country code that is provided.
     *
     * @author author of http://stackoverflow.com/questions/3191664/list-of-all-locales-and-their-short-codes
     * @param $country_code  ISO 3166-2-alpha 2 country code
     * @param $language_code ISO 639-1-alpha 2 language code
     * @returns  a locale, formatted like en_US, or null if not found
     */
    public function country_code_to_locale($country_code, $language_code = '')
    {
        $locales = array('af-ZA',
            'ca-AD',
            'am-ET',
            'ar-AE',
            'ar-BH',
            'ar-DZ',
            'ar-EG',
            'ar-IQ',
            'ar-JO',
            'ar-KW',
            'ar-LB',
            'ar-LY',
            'ar-MA',
            'arn-CL',
            'ar-OM',
            'ar-QA',
            'ar-SA',
            'ar-SY',
            'ar-TN',
            'ar-YE',
            'as-IN',
            'az-Cyrl-AZ',
            'az-Latn-AZ',
            'ba-RU',
            'be-BY',
            'bg-BG',
            'bn-BD',
            'bn-IN',
            'bo-CN',
            'bs-Cyrl-BA',
            'bs-Latn-BA',
            'co-FR',
            'cs-CZ',
            'cy-GB',
            'da-DK',
            'de-AT',
            'de-CH',
            'de-DE',
            'de-LI',
            'de-LU',
            'dsb-DE',
            'dv-MV',
            'el-GR',
            'en-029',
            'en-AU',
            'en-BZ',
            'en-CA',
            'en-GB',
            'en-GG',
            'en-GI',
            'en-IE',
            'en-IM',
            'en-IN',
            'en-JE',
            'en-JM',
            'en-MY',
            'en-NZ',
            'en-PH',
            'en-SG',
            'en-TT',
            'en-US',
            'en-ZA',
            'en-ZW',
            'es-AR',
            'es-BO',
            'es-CL',
            'es-CO',
            'es-CR',
            'es-DO',
            'es-EC',
            'es-ES',
            'es-GT',
            'es-HN',
            'es-MX',
            'es-NI',
            'es-PA',
            'es-PE',
            'es-PR',
            'es-PY',
            'es-SV',
            'es-US',
            'es-UY',
            'es-VE',
            'et-EE',
            'eu-ES',
            'fa-IR',
            'fi-FI',
            'fil-PH',
            'fo-FO',
            'fr-BE',
            'fr-CA',
            'fr-CH',
            'fr-FR',
            'fr-LU',
            'fr-MC',
            'fy-NL',
            'ga-IE',
            'gd-GB',
            'gl-ES',
            'gsw-FR',
            'gu-IN',
            'ha-Latn-NG',
            'he-IL',
            'hi-IN',
            'hr-BA',
            'hr-HR',
            'hsb-DE',
            'hu-HU',
            'hy-AM',
            'id-ID',
            'ig-NG',
            'ii-CN',
            'is-IS',
            'it-CH',
            'it-IT',
            'it-SM',
            'it-VA',
            'iu-Cans-CA',
            'iu-Latn-CA',
            'ja-JP',
            'ka-GE',
            'kk-KZ',
            'kl-GL',
            'km-KH',
            'kn-IN',
            'kok-IN',
            'ko-KR',
            'ky-KG',
            'lb-LU',
            'lo-LA',
            'lt-LT',
            'lv-LV',
            'mi-NZ',
            'mk-MK',
            'ml-IN',
            'mn-MN',
            'mn-Mong-CN',
            'moh-CA',
            'mr-IN',
            'ms-BN',
            'ms-MY',
            'mt-MT',
            'nb-NO',
            'nb-SJ',
            'ne-NP',
            'nl-BE',
            'nl-NL',
            'nn-NO',
            'nso-ZA',
            'oc-FR',
            'or-IN',
            'pa-IN',
            'pl-PL',
            'prs-AF',
            'ps-AF',
            'pt-BR',
            'pt-PT',
            'qut-GT',
            'quz-BO',
            'quz-EC',
            'quz-PE',
            'rm-CH',
            'ro-RO',
            'ro-MD',
            'ru-RU',
            'rw-RW',
            'sah-RU',
            'sa-IN',
            'se-FI',
            'se-NO',
            'se-SE',
            'si-LK',
            'sk-SK',
            'sl-SI',
            'sma-NO',
            'sma-SE',
            'smj-NO',
            'smj-SE',
            'smn-FI',
            'sms-FI',
            'sq-AL',
            'sr-Cyrl-BA',
            'sr-Cyrl-CS',
            'sr-Cyrl-ME',
            'sr-Cyrl-RS',
            'sr-Latn-BA',
            'sr-Latn-CS',
            'sr-Latn-ME',
            'sr-Latn-RS',
            'sv-FI',
            'sv-SE',
            'sv-AX',
            'sw-KE',
            'syr-SY',
            'ta-IN',
            'te-IN',
            'tg-Cyrl-TJ',
            'th-TH',
            'tk-TM',
            'tn-ZA',
            'tr-TR',
            'tt-RU',
            'tzm-Latn-DZ',
            'ug-CN',
            'uk-UA',
            'ur-PK',
            'uz-Cyrl-UZ',
            'uz-Latn-UZ',
            'vi-VN',
            'wo-SN',
            'xh-ZA',
            'yo-NG',
            'zh-CN',
            'zh-HK',
            'zh-MO',
            'zh-SG',
            'zh-TW',
            'zu-ZA',);
        foreach ($locales as $locale) {
            $locale_region = locale_get_region($locale);
            $locale_language = locale_get_primary_language($locale);
            $locale_array = array('language' => $locale_language,
                'region' => $locale_region);

            if (strtoupper($country_code) == $locale_region &&
                $language_code == ''
            ) {
                return locale_compose($locale_array);
            } elseif (strtoupper($country_code) == $locale_region &&
                strtolower($language_code) == $locale_language
            ) {
                return locale_compose($locale_array);
            }
        }

        return null;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('code', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name');

        $validator
            ->requirePresence('iso3', 'create')
            ->notEmpty('iso3');

        $validator
            ->integer('number')
            ->requirePresence('number', 'create')
            ->notEmpty('number');

        $validator
            ->requirePresence('continent_code', 'create')
            ->notEmpty('continent_code');

        return $validator;
    }
}
