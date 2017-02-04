-- phpMyAdmin SQL Dump
        -- version 4.5.1
        -- http://www.phpmyadmin.net
        --
        -- Host: 127.0.0.1
        -- Erstellungszeit: 03. Feb 2017 um 15:58
        -- Server-Version: 10.1.16-MariaDB
        -- PHP-Version: 7.0.9

        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        SET time_zone = "+00:00";


        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        /*!40101 SET NAMES utf8mb4 */;

        --
        -- Datenbank: `cs-community`
        --

        -- --------------------------------------------------------
        SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS chat_messages, lobbies, users, continents, countries, roles, ranks;
        SET FOREIGN_KEY_CHECKS=1;

        --
        -- Tabellenstruktur fÃ¼r Tabelle `chat_messages`
        --

        CREATE TABLE IF NOT EXISTS `chat_messages` (
        `message_id` int(10) UNSIGNED NOT NULL,
        `sent_by` varchar(255) NOT NULL,
        `message` varchar(50) NOT NULL,
        `created` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `chat_messages`
        --

        INSERT INTO `chat_messages` (`message_id`, `sent_by`, `message`, `created`) VALUES
        (49, '76561198126151407', 'test1', '2016-12-20 18:25:44'),
        (50, '76561198126151407', 'test2', '2016-12-20 18:25:56'),
        (51, '76561198126151407', 'wuff', '2016-12-20 18:26:30'),
        (52, '76561198126151407', 'wuff1', '2016-12-20 18:26:37'),
        (53, '76561198126151407', 'wuff2', '2016-12-20 18:26:39'),
        (54, '76561198126151407', 'wuff3', '2016-12-20 18:26:40'),
        (55, '76561198126151407', 'wuff4', '2016-12-20 18:26:41'),
        (56, '76561198126151407', 'wuff5', '2016-12-20 18:26:42'),
        (57, '76561198126151407', 'wuff6', '2016-12-20 18:26:43'),
        (58, '76561198126151407', 'wuff7', '2016-12-20 18:26:44'),
        (59, '76561198126151407', 'wuff8', '2016-12-20 18:26:46'),
        (60, '76561198126151407', 'wuff9', '2016-12-20 18:26:47'),
        (61, '76561198126151407', 'lul1', '2016-12-20 19:08:44'),
        (62, '76561198126151407', 'lul2', '2016-12-20 19:08:46'),
        (63, '76561198126151407', 'lul3', '2016-12-20 19:08:47'),
        (64, '76561198126151407', 'lul4', '2016-12-20 19:08:48'),
        (65, '76561198126151407', 'lul5', '2016-12-20 19:08:48'),
        (66, '76561198126151407', 'lul6', '2016-12-20 19:08:50'),
        (67, '76561198126151407', 'lul7', '2016-12-20 19:08:51'),
        (68, '76561198126151407', 'lul8', '2016-12-20 19:08:52'),
        (69, '76561198126151407', 'lul9', '2016-12-20 19:08:53'),
        (70, '76561198126151407', 'lul10', '2016-12-20 19:08:55');

        -- --------------------------------------------------------

        --
        -- Tabellenstruktur fÃ¼r Tabelle `continents`
        --

        CREATE TABLE IF NOT EXISTS `continents` (
        `code` char(2) NOT NULL COMMENT 'Continent code',
        `name` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `continents`
        --

        INSERT INTO `continents` (`code`, `name`) VALUES
        ('AF', 'Africa'),
        ('AN', 'Antarctica'),
        ('AS', 'Asia'),
        ('EU', 'Europe'),
        ('NA', 'North America'),
        ('OC', 'Oceania'),
        ('SA', 'South America');

        -- --------------------------------------------------------

        --
        -- Tabellenstruktur fÃ¼r Tabelle `countries`
        --

        CREATE TABLE IF NOT EXISTS `countries` (
        `code` char(2) NOT NULL COMMENT 'Two-letter country code (ISO 3166-1 alpha-2)',
        `name` varchar(255) NOT NULL COMMENT 'English country name',
        `full_name` varchar(255) NOT NULL COMMENT 'Full English country name',
        `iso3` char(3) NOT NULL COMMENT 'Three-letter country code (ISO 3166-1 alpha-3)',
        `number` smallint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Three-digit country number (ISO 3166-1 numeric)',
        `continent_code` char(2) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `countries`
        --

        INSERT INTO `countries` (`code`, `name`, `full_name`, `iso3`, `number`, `continent_code`) VALUES
        ('AD', 'Andorra', 'Principality of Andorra', 'AND', 020, 'EU'),
        ('AE', 'United Arab Emirates', 'United Arab Emirates', 'ARE', 784, 'AS'),
        ('AF', 'Afghanistan', 'Islamic Republic of Afghanistan', 'AFG', 004, 'AS'),
        ('AG', 'Antigua and Barbuda', 'Antigua and Barbuda', 'ATG', 028, 'NA'),
        ('AI', 'Anguilla', 'Anguilla', 'AIA', 660, 'NA'),
        ('AL', 'Albania', 'Republic of Albania', 'ALB', 008, 'EU'),
        ('AM', 'Armenia', 'Republic of Armenia', 'ARM', 051, 'AS'),
        ('AO', 'Angola', 'Republic of Angola', 'AGO', 024, 'AF'),
        ('AQ', 'Antarctica', 'Antarctica (the territory South of 60 deg S)', 'ATA', 010, 'AN'),
        ('AR', 'Argentina', 'Argentine Republic', 'ARG', 032, 'SA'),
        ('AS', 'American Samoa', 'American Samoa', 'ASM', 016, 'OC'),
        ('AT', 'Austria', 'Republic of Austria', 'AUT', 040, 'EU'),
        ('AU', 'Australia', 'Commonwealth of Australia', 'AUS', 036, 'OC'),
        ('AW', 'Aruba', 'Aruba', 'ABW', 533, 'NA'),
        ('AX', 'Ã…land Islands', 'Ã…land Islands', 'ALA', 248, 'EU'),
        ('AZ', 'Azerbaijan', 'Republic of Azerbaijan', 'AZE', 031, 'AS'),
        ('BA', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'BIH', 070, 'EU'),
        ('BB', 'Barbados', 'Barbados', 'BRB', 052, 'NA'),
        ('BD', 'Bangladesh', 'People''s Republic of Bangladesh', 'BGD', 050, 'AS'),
        ('BE', 'Belgium', 'Kingdom of Belgium', 'BEL', 056, 'EU'),
        ('BF', 'Burkina Faso', 'Burkina Faso', 'BFA', 854, 'AF'),
        ('BG', 'Bulgaria', 'Republic of Bulgaria', 'BGR', 100, 'EU'),
        ('BH', 'Bahrain', 'Kingdom of Bahrain', 'BHR', 048, 'AS'),
        ('BI', 'Burundi', 'Republic of Burundi', 'BDI', 108, 'AF'),
        ('BJ', 'Benin', 'Republic of Benin', 'BEN', 204, 'AF'),
        ('BL', 'Saint BarthÃ©lemy', 'Saint BarthÃ©lemy', 'BLM', 652, 'NA'),
        ('BM', 'Bermuda', 'Bermuda', 'BMU', 060, 'NA'),
        ('BN', 'Brunei Darussalam', 'Brunei Darussalam', 'BRN', 096, 'AS'),
        ('BO', 'Bolivia', 'Plurinational State of Bolivia', 'BOL', 068, 'SA'),
        ('BQ', 'Bonaire, Sint Eustatius and Saba', 'Bonaire, Sint Eustatius and Saba', 'BES', 535, 'NA'),
        ('BR', 'Brazil', 'Federative Republic of Brazil', 'BRA', 076, 'SA'),
        ('BS', 'Bahamas', 'Commonwealth of the Bahamas', 'BHS', 044, 'NA'),
        ('BT', 'Bhutan', 'Kingdom of Bhutan', 'BTN', 064, 'AS'),
        ('BV', 'Bouvet Island (BouvetÃ¸ya)', 'Bouvet Island (BouvetÃ¸ya)', 'BVT', 074, 'AN'),
        ('BW', 'Botswana', 'Republic of Botswana', 'BWA', 072, 'AF'),
        ('BY', 'Belarus', 'Republic of Belarus', 'BLR', 112, 'EU'),
        ('BZ', 'Belize', 'Belize', 'BLZ', 084, 'NA'),
        ('CA', 'Canada', 'Canada', 'CAN', 124, 'NA'),
        ('CC', 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CCK', 166, 'AS'),
        ('CD', 'Congo', 'Democratic Republic of the Congo', 'COD', 180, 'AF'),
        ('CF', 'Central African Republic', 'Central African Republic', 'CAF', 140, 'AF'),
        ('CG', 'Congo', 'Republic of the Congo', 'COG', 178, 'AF'),
        ('CH', 'Switzerland', 'Swiss Confederation', 'CHE', 756, 'EU'),
        ('CI', 'Cote d''Ivoire', 'Republic of Cote d''Ivoire', 'CIV', 384, 'AF'),
        ('CK', 'Cook Islands', 'Cook Islands', 'COK', 184, 'OC'),
        ('CL', 'Chile', 'Republic of Chile', 'CHL', 152, 'SA'),
        ('CM', 'Cameroon', 'Republic of Cameroon', 'CMR', 120, 'AF'),
        ('CN', 'China', 'People''s Republic of China', 'CHN', 156, 'AS'),
        ('CO', 'Colombia', 'Republic of Colombia', 'COL', 170, 'SA'),
        ('CR', 'Costa Rica', 'Republic of Costa Rica', 'CRI', 188, 'NA'),
        ('CU', 'Cuba', 'Republic of Cuba', 'CUB', 192, 'NA'),
        ('CV', 'Cabo Verde', 'Republic of Cabo Verde', 'CPV', 132, 'AF'),
        ('CW', 'CuraÃ§ao', 'CuraÃ§ao', 'CUW', 531, 'NA'),
        ('CX', 'Christmas Island', 'Christmas Island', 'CXR', 162, 'AS'),
        ('CY', 'Cyprus', 'Republic of Cyprus', 'CYP', 196, 'AS'),
        ('CZ', 'Czechia', 'Czech Republic', 'CZE', 203, 'EU'),
        ('DE', 'Germany', 'Federal Republic of Germany', 'DEU', 276, 'EU'),
        ('DJ', 'Djibouti', 'Republic of Djibouti', 'DJI', 262, 'AF'),
        ('DK', 'Denmark', 'Kingdom of Denmark', 'DNK', 208, 'EU'),
        ('DM', 'Dominica', 'Commonwealth of Dominica', 'DMA', 212, 'NA'),
        ('DO', 'Dominican Republic', 'Dominican Republic', 'DOM', 214, 'NA'),
        ('DZ', 'Algeria', 'People''s Democratic Republic of Algeria', 'DZA', 012, 'AF'),
        ('EC', 'Ecuador', 'Republic of Ecuador', 'ECU', 218, 'SA'),
        ('EE', 'Estonia', 'Republic of Estonia', 'EST', 233, 'EU'),
        ('EG', 'Egypt', 'Arab Republic of Egypt', 'EGY', 818, 'AF'),
        ('EH', 'Western Sahara', 'Western Sahara', 'ESH', 732, 'AF'),
        ('ER', 'Eritrea', 'State of Eritrea', 'ERI', 232, 'AF'),
        ('ES', 'Spain', 'Kingdom of Spain', 'ESP', 724, 'EU'),
        ('ET', 'Ethiopia', 'Federal Democratic Republic of Ethiopia', 'ETH', 231, 'AF'),
        ('FI', 'Finland', 'Republic of Finland', 'FIN', 246, 'EU'),
        ('FJ', 'Fiji', 'Republic of Fiji', 'FJI', 242, 'OC'),
        ('FK', 'Falkland Islands (Malvinas)', 'Falkland Islands (Malvinas)', 'FLK', 238, 'SA'),
        ('FM', 'Micronesia', 'Federated States of Micronesia', 'FSM', 583, 'OC'),
        ('FO', 'Faroe Islands', 'Faroe Islands', 'FRO', 234, 'EU'),
        ('FR', 'France', 'French Republic', 'FRA', 250, 'EU'),
        ('GA', 'Gabon', 'Gabonese Republic', 'GAB', 266, 'AF'),
        ('GB', 'United Kingdom of Great Britain & Northern Ireland', 'United Kingdom of Great Britain & Northern Ireland', 'GBR', 826, 'EU'),
        ('GD', 'Grenada', 'Grenada', 'GRD', 308, 'NA'),
        ('GE', 'Georgia', 'Georgia', 'GEO', 268, 'AS'),
        ('GF', 'French Guiana', 'French Guiana', 'GUF', 254, 'SA'),
        ('GG', 'Guernsey', 'Bailiwick of Guernsey', 'GGY', 831, 'EU'),
        ('GH', 'Ghana', 'Republic of Ghana', 'GHA', 288, 'AF'),
        ('GI', 'Gibraltar', 'Gibraltar', 'GIB', 292, 'EU'),
        ('GL', 'Greenland', 'Greenland', 'GRL', 304, 'NA'),
        ('GM', 'Gambia', 'Islamic Republic of the Gambia', 'GMB', 270, 'AF'),
        ('GN', 'Guinea', 'Republic of Guinea', 'GIN', 324, 'AF'),
        ('GP', 'Guadeloupe', 'Guadeloupe', 'GLP', 312, 'NA'),
        ('GQ', 'Equatorial Guinea', 'Republic of Equatorial Guinea', 'GNQ', 226, 'AF'),
        ('GR', 'Greece', 'Hellenic Republic of Greece', 'GRC', 300, 'EU'),
        ('GS', 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'SGS', 239, 'AN'),
        ('GT', 'Guatemala', 'Republic of Guatemala', 'GTM', 320, 'NA'),
        ('GU', 'Guam', 'Guam', 'GUM', 316, 'OC'),
        ('GW', 'Guinea-Bissau', 'Republic of Guinea-Bissau', 'GNB', 624, 'AF'),
        ('GY', 'Guyana', 'Co-operative Republic of Guyana', 'GUY', 328, 'SA'),
        ('HK', 'Hong Kong', 'Hong Kong Special Administrative Region of China', 'HKG', 344, 'AS'),
        ('HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', 334, 'AN'),
        ('HN', 'Honduras', 'Republic of Honduras', 'HND', 340, 'NA'),
        ('HR', 'Croatia', 'Republic of Croatia', 'HRV', 191, 'EU'),
        ('HT', 'Haiti', 'Republic of Haiti', 'HTI', 332, 'NA'),
        ('HU', 'Hungary', 'Hungary', 'HUN', 348, 'EU'),
        ('ID', 'Indonesia', 'Republic of Indonesia', 'IDN', 360, 'AS'),
        ('IE', 'Ireland', 'Ireland', 'IRL', 372, 'EU'),
        ('IL', 'Israel', 'State of Israel', 'ISR', 376, 'AS'),
        ('IM', 'Isle of Man', 'Isle of Man', 'IMN', 833, 'EU'),
        ('IN', 'India', 'Republic of India', 'IND', 356, 'AS'),
        ('IO', 'British Indian Ocean Territory (Chagos Archipelago)', 'British Indian Ocean Territory (Chagos Archipelago)', 'IOT', 086, 'AS'),
        ('IQ', 'Iraq', 'Republic of Iraq', 'IRQ', 368, 'AS'),
        ('IR', 'Iran', 'Islamic Republic of Iran', 'IRN', 364, 'AS'),
        ('IS', 'Iceland', 'Republic of Iceland', 'ISL', 352, 'EU'),
        ('IT', 'Italy', 'Italian Republic', 'ITA', 380, 'EU'),
        ('JE', 'Jersey', 'Bailiwick of Jersey', 'JEY', 832, 'EU'),
        ('JM', 'Jamaica', 'Jamaica', 'JAM', 388, 'NA'),
        ('JO', 'Jordan', 'Hashemite Kingdom of Jordan', 'JOR', 400, 'AS'),
        ('JP', 'Japan', 'Japan', 'JPN', 392, 'AS'),
        ('KE', 'Kenya', 'Republic of Kenya', 'KEN', 404, 'AF'),
        ('KG', 'Kyrgyz Republic', 'Kyrgyz Republic', 'KGZ', 417, 'AS'),
        ('KH', 'Cambodia', 'Kingdom of Cambodia', 'KHM', 116, 'AS'),
        ('KI', 'Kiribati', 'Republic of Kiribati', 'KIR', 296, 'OC'),
        ('KM', 'Comoros', 'Union of the Comoros', 'COM', 174, 'AF'),
        ('KN', 'Saint Kitts and Nevis', 'Federation of Saint Kitts and Nevis', 'KNA', 659, 'NA'),
        ('KP', 'Korea', 'Democratic People''s Republic of Korea', 'PRK', 408, 'AS'),
        ('KR', 'Korea', 'Republic of Korea', 'KOR', 410, 'AS'),
        ('KW', 'Kuwait', 'State of Kuwait', 'KWT', 414, 'AS'),
        ('KY', 'Cayman Islands', 'Cayman Islands', 'CYM', 136, 'NA'),
        ('KZ', 'Kazakhstan', 'Republic of Kazakhstan', 'KAZ', 398, 'AS'),
        ('LA', 'Lao People''s Democratic Republic', 'Lao People''s Democratic Republic', 'LAO', 418, 'AS'),
        ('LB', 'Lebanon', 'Lebanese Republic', 'LBN', 422, 'AS'),
        ('LC', 'Saint Lucia', 'Saint Lucia', 'LCA', 662, 'NA'),
        ('LI', 'Liechtenstein', 'Principality of Liechtenstein', 'LIE', 438, 'EU'),
        ('LK', 'Sri Lanka', 'Democratic Socialist Republic of Sri Lanka', 'LKA', 144, 'AS'),
        ('LR', 'Liberia', 'Republic of Liberia', 'LBR', 430, 'AF'),
        ('LS', 'Lesotho', 'Kingdom of Lesotho', 'LSO', 426, 'AF'),
        ('LT', 'Lithuania', 'Republic of Lithuania', 'LTU', 440, 'EU'),
        ('LU', 'Luxembourg', 'Grand Duchy of Luxembourg', 'LUX', 442, 'EU'),
        ('LV', 'Latvia', 'Republic of Latvia', 'LVA', 428, 'EU'),
        ('LY', 'Libya', 'Libya', 'LBY', 434, 'AF'),
        ('MA', 'Morocco', 'Kingdom of Morocco', 'MAR', 504, 'AF'),
        ('MC', 'Monaco', 'Principality of Monaco', 'MCO', 492, 'EU'),
        ('MD', 'Moldova', 'Republic of Moldova', 'MDA', 498, 'EU'),
        ('ME', 'Montenegro', 'Montenegro', 'MNE', 499, 'EU'),
        ('MF', 'Saint Martin', 'Saint Martin (French part)', 'MAF', 663, 'NA'),
        ('MG', 'Madagascar', 'Republic of Madagascar', 'MDG', 450, 'AF'),
        ('MH', 'Marshall Islands', 'Republic of the Marshall Islands', 'MHL', 584, 'OC'),
        ('MK', 'Macedonia', 'Republic of Macedonia', 'MKD', 807, 'EU'),
        ('ML', 'Mali', 'Republic of Mali', 'MLI', 466, 'AF'),
        ('MM', 'Myanmar', 'Republic of the Union of Myanmar', 'MMR', 104, 'AS'),
        ('MN', 'Mongolia', 'Mongolia', 'MNG', 496, 'AS'),
        ('MO', 'Macao', 'Macao Special Administrative Region of China', 'MAC', 446, 'AS'),
        ('MP', 'Northern Mariana Islands', 'Commonwealth of the Northern Mariana Islands', 'MNP', 580, 'OC'),
        ('MQ', 'Martinique', 'Martinique', 'MTQ', 474, 'NA'),
        ('MR', 'Mauritania', 'Islamic Republic of Mauritania', 'MRT', 478, 'AF'),
        ('MS', 'Montserrat', 'Montserrat', 'MSR', 500, 'NA'),
        ('MT', 'Malta', 'Republic of Malta', 'MLT', 470, 'EU'),
        ('MU', 'Mauritius', 'Republic of Mauritius', 'MUS', 480, 'AF'),
        ('MV', 'Maldives', 'Republic of Maldives', 'MDV', 462, 'AS'),
        ('MW', 'Malawi', 'Republic of Malawi', 'MWI', 454, 'AF'),
        ('MX', 'Mexico', 'United Mexican States', 'MEX', 484, 'NA'),
        ('MY', 'Malaysia', 'Malaysia', 'MYS', 458, 'AS'),
        ('MZ', 'Mozambique', 'Republic of Mozambique', 'MOZ', 508, 'AF'),
        ('NA', 'Namibia', 'Republic of Namibia', 'NAM', 516, 'AF'),
        ('NC', 'New Caledonia', 'New Caledonia', 'NCL', 540, 'OC'),
        ('NE', 'Niger', 'Republic of Niger', 'NER', 562, 'AF'),
        ('NF', 'Norfolk Island', 'Norfolk Island', 'NFK', 574, 'OC'),
        ('NG', 'Nigeria', 'Federal Republic of Nigeria', 'NGA', 566, 'AF'),
        ('NI', 'Nicaragua', 'Republic of Nicaragua', 'NIC', 558, 'NA'),
        ('NL', 'Netherlands', 'Kingdom of the Netherlands', 'NLD', 528, 'EU'),
        ('NO', 'Norway', 'Kingdom of Norway', 'NOR', 578, 'EU'),
        ('NP', 'Nepal', 'Federal Democratic Republic of Nepal', 'NPL', 524, 'AS'),
        ('NR', 'Nauru', 'Republic of Nauru', 'NRU', 520, 'OC'),
        ('NU', 'Niue', 'Niue', 'NIU', 570, 'OC'),
        ('NZ', 'New Zealand', 'New Zealand', 'NZL', 554, 'OC'),
        ('OM', 'Oman', 'Sultanate of Oman', 'OMN', 512, 'AS'),
        ('PA', 'Panama', 'Republic of Panama', 'PAN', 591, 'NA'),
        ('PE', 'Peru', 'Republic of Peru', 'PER', 604, 'SA'),
        ('PF', 'French Polynesia', 'French Polynesia', 'PYF', 258, 'OC'),
        ('PG', 'Papua New Guinea', 'Independent State of Papua New Guinea', 'PNG', 598, 'OC'),
        ('PH', 'Philippines', 'Republic of the Philippines', 'PHL', 608, 'AS'),
        ('PK', 'Pakistan', 'Islamic Republic of Pakistan', 'PAK', 586, 'AS'),
        ('PL', 'Poland', 'Republic of Poland', 'POL', 616, 'EU'),
        ('PM', 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'SPM', 666, 'NA'),
        ('PN', 'Pitcairn Islands', 'Pitcairn Islands', 'PCN', 612, 'OC'),
        ('PR', 'Puerto Rico', 'Commonwealth of Puerto Rico', 'PRI', 630, 'NA'),
        ('PS', 'Palestine', 'State of Palestine', 'PSE', 275, 'AS'),
        ('PT', 'Portugal', 'Portuguese Republic', 'PRT', 620, 'EU'),
        ('PW', 'Palau', 'Republic of Palau', 'PLW', 585, 'OC'),
        ('PY', 'Paraguay', 'Republic of Paraguay', 'PRY', 600, 'SA'),
        ('QA', 'Qatar', 'State of Qatar', 'QAT', 634, 'AS'),
        ('RE', 'RÃ©union', 'RÃ©union', 'REU', 638, 'AF'),
        ('RO', 'Romania', 'Romania', 'ROU', 642, 'EU'),
        ('RS', 'Serbia', 'Republic of Serbia', 'SRB', 688, 'EU'),
        ('RU', 'Russian Federation', 'Russian Federation', 'RUS', 643, 'EU'),
        ('RW', 'Rwanda', 'Republic of Rwanda', 'RWA', 646, 'AF'),
        ('SA', 'Saudi Arabia', 'Kingdom of Saudi Arabia', 'SAU', 682, 'AS'),
        ('SB', 'Solomon Islands', 'Solomon Islands', 'SLB', 090, 'OC'),
        ('SC', 'Seychelles', 'Republic of Seychelles', 'SYC', 690, 'AF'),
        ('SD', 'Sudan', 'Republic of Sudan', 'SDN', 729, 'AF'),
        ('SE', 'Sweden', 'Kingdom of Sweden', 'SWE', 752, 'EU'),
        ('SG', 'Singapore', 'Republic of Singapore', 'SGP', 702, 'AS'),
        ('SH', 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', 654, 'AF'),
        ('SI', 'Slovenia', 'Republic of Slovenia', 'SVN', 705, 'EU'),
        ('SJ', 'Svalbard & Jan Mayen Islands', 'Svalbard & Jan Mayen Islands', 'SJM', 744, 'EU'),
        ('SK', 'Slovakia (Slovak Republic)', 'Slovakia (Slovak Republic)', 'SVK', 703, 'EU'),
        ('SL', 'Sierra Leone', 'Republic of Sierra Leone', 'SLE', 694, 'AF'),
        ('SM', 'San Marino', 'Republic of San Marino', 'SMR', 674, 'EU'),
        ('SN', 'Senegal', 'Republic of Senegal', 'SEN', 686, 'AF'),
        ('SO', 'Somalia', 'Federal Republic of Somalia', 'SOM', 706, 'AF'),
        ('SR', 'Suriname', 'Republic of Suriname', 'SUR', 740, 'SA'),
        ('SS', 'South Sudan', 'Republic of South Sudan', 'SSD', 728, 'AF'),
        ('ST', 'Sao Tome and Principe', 'Democratic Republic of Sao Tome and Principe', 'STP', 678, 'AF'),
        ('SV', 'El Salvador', 'Republic of El Salvador', 'SLV', 222, 'NA'),
        ('SX', 'Sint Maarten (Dutch part)', 'Sint Maarten (Dutch part)', 'SXM', 534, 'NA'),
        ('SY', 'Syrian Arab Republic', 'Syrian Arab Republic', 'SYR', 760, 'AS'),
        ('SZ', 'Swaziland', 'Kingdom of Swaziland', 'SWZ', 748, 'AF'),
        ('TC', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TCA', 796, 'NA'),
        ('TD', 'Chad', 'Republic of Chad', 'TCD', 148, 'AF'),
        ('TF', 'French Southern Territories', 'French Southern Territories', 'ATF', 260, 'AN'),
        ('TG', 'Togo', 'Togolese Republic', 'TGO', 768, 'AF'),
        ('TH', 'Thailand', 'Kingdom of Thailand', 'THA', 764, 'AS'),
        ('TJ', 'Tajikistan', 'Republic of Tajikistan', 'TJK', 762, 'AS'),
        ('TK', 'Tokelau', 'Tokelau', 'TKL', 772, 'OC'),
        ('TL', 'Timor-Leste', 'Democratic Republic of Timor-Leste', 'TLS', 626, 'AS'),
        ('TM', 'Turkmenistan', 'Turkmenistan', 'TKM', 795, 'AS'),
        ('TN', 'Tunisia', 'Tunisian Republic', 'TUN', 788, 'AF'),
        ('TO', 'Tonga', 'Kingdom of Tonga', 'TON', 776, 'OC'),
        ('TR', 'Turkey', 'Republic of Turkey', 'TUR', 792, 'AS'),
        ('TT', 'Trinidad and Tobago', 'Republic of Trinidad and Tobago', 'TTO', 780, 'NA'),
        ('TV', 'Tuvalu', 'Tuvalu', 'TUV', 798, 'OC'),
        ('TW', 'Taiwan', 'Taiwan, Province of China', 'TWN', 158, 'AS'),
        ('TZ', 'Tanzania', 'United Republic of Tanzania', 'TZA', 834, 'AF'),
        ('UA', 'Ukraine', 'Ukraine', 'UKR', 804, 'EU'),
        ('UG', 'Uganda', 'Republic of Uganda', 'UGA', 800, 'AF'),
        ('UM', 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UMI', 581, 'OC'),
        ('US', 'United States of America', 'United States of America', 'USA', 840, 'NA'),
        ('UY', 'Uruguay', 'Eastern Republic of Uruguay', 'URY', 858, 'SA'),
        ('UZ', 'Uzbekistan', 'Republic of Uzbekistan', 'UZB', 860, 'AS'),
        ('VA', 'Holy See (Vatican City State)', 'Holy See (Vatican City State)', 'VAT', 336, 'EU'),
        ('VC', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VCT', 670, 'NA'),
        ('VE', 'Venezuela', 'Bolivarian Republic of Venezuela', 'VEN', 862, 'SA'),
        ('VG', 'British Virgin Islands', 'British Virgin Islands', 'VGB', 092, 'NA'),
        ('VI', 'United States Virgin Islands', 'United States Virgin Islands', 'VIR', 850, 'NA'),
        ('VN', 'Vietnam', 'Socialist Republic of Vietnam', 'VNM', 704, 'AS'),
        ('VU', 'Vanuatu', 'Republic of Vanuatu', 'VUT', 548, 'OC'),
        ('WF', 'Wallis and Futuna', 'Wallis and Futuna', 'WLF', 876, 'OC'),
        ('WS', 'Samoa', 'Independent State of Samoa', 'WSM', 882, 'OC'),
        ('YE', 'Yemen', 'Yemen', 'YEM', 887, 'AS'),
        ('YT', 'Mayotte', 'Mayotte', 'MYT', 175, 'AF'),
        ('ZA', 'South Africa', 'Republic of South Africa', 'ZAF', 710, 'AF'),
        ('ZM', 'Zambia', 'Republic of Zambia', 'ZMB', 894, 'AF'),
        ('ZW', 'Zimbabwe', 'Republic of Zimbabwe', 'ZWE', 716, 'AF');

        -- --------------------------------------------------------

        --
        -- Tabellenstruktur fÃ¼r Tabelle `lobbies`
        --

        CREATE TABLE IF NOT EXISTS `lobbies` (
        `lobby_id` int(10) UNSIGNED NOT NULL,
        `owner_id` varchar(255) NOT NULL,
        `free_slots` int(11) DEFAULT '5',
        `url` varchar(255) NOT NULL,
        `created` datetime DEFAULT NULL,
        `modified` datetime DEFAULT NULL,
        `microphone_req` tinyint(1) DEFAULT '0',
        `prime_req` tinyint(1) DEFAULT '0',
        `min_age` int(11) DEFAULT NULL,
        `teamspeak_req` tinyint(1) DEFAULT '0',
        `teamspeak_ip` varchar(100) DEFAULT NULL,
        `rank_from` int(10) UNSIGNED DEFAULT NULL,
        `rank_to` int(10) UNSIGNED DEFAULT NULL,
        `min_playtime` int(11) DEFAULT NULL,
        `region` char(2) DEFAULT NULL,
        `language` char(6) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        -- --------------------------------------------------------
        INSERT INTO `lobbies` (`lobby_id`, `owner_id`, `free_slots`, `url`, `created`, `modified`, `microphone_req`, `prime_req`, `min_age`, `teamspeak_req`, `teamspeak_ip`, `rank_from`, `rank_to`, `min_playtime`, `region`, `language`) VALUES
        (1,'76561198179977039', 4, 'steam://joinlobby/730/123409775241993547872/76561198186213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (2,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/76561198186413972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (3,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/76561198186613972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (4,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/76561198186113972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (5,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/765611981862113972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (6,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/76561198186212413972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (7,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/7656119818621343972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (8,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/765611981836213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (9,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/7656119823186213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (10,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/7656119818621113972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (11,'76561198179977039', 4, 'steam://joinlobby/730/109775241993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (12,'76561198179977039', 4, 'steam://joinlobby/730/10977547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (13,'76561198179977039', 4, 'steam://joinlobby/730/1097752419931547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (14,'76561198179977039', 4, 'steam://joinlobby/730/10977524199748833547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (15,'76561198179977039', 4, 'steam://joinlobby/730/10977524199354777872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (16,'76561198179977039', 4, 'steam://joinlobby/730/109775241993566747872/34776561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (17,'76561198179977039', 4, 'steam://joinlobby/730/10977524199354557872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (18,'76561198179977039', 4, 'steam://joinlobby/730/10977524199354447872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (19,'76561198179977039', 4, 'steam://joinlobby/730/10977524199354722872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (20,'76561198179977039', 4, 'steam://joinlobby/730/1097752419935727872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (21,'76561198179977039', 4, 'steam://joinlobby/730/109775231146419935478634572/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (22,'76561198179977039', 4, 'steam://joinlobby/730/109775261113441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (23,'76561198179977039', 4, 'steam://joinlobby/730/10977526111113441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (24,'76561198179977039', 4, 'steam://joinlobby/730/1097752611113441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (25,'76561198179977039', 4, 'steam://joinlobby/730/109771115263441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (26,'76561198179977039', 4, 'steam://joinlobby/730/1097175263441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (27,'76561198179977039', 4, 'steam://joinlobby/730/109775132263441993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (28,'76561198179977039', 4, 'steam://joinlobby/730/1019775263441993547872/7656111598123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (29,'76561198179977039', 4, 'steam://joinlobby/730/1097752634419931235547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (30,'76561198179977039', 4, 'steam://joinlobby/730/109775263441993513247872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (31,'76561198179977039', 4, 'steam://joinlobby/730/109775263441993512347872/7656116198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (32,'76561198179977039', 4, 'steam://joinlobby/730/109775263541441993547872/7651661198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (33,'76561198179977039', 4, 'steam://joinlobby/730/10977526344191393547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (34,'76561198179977039', 4, 'steam://joinlobby/730/10977526344199354157872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (35,'76561198179977039', 4, 'steam://joinlobby/730/1097752634463199354781472/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (36,'76561198179977039', 4, 'steam://joinlobby/730/109775263441993547872/76561231198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (37,'76561198179977039', 4, 'steam://joinlobby/730/10977526344199123547872/7656113198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (38,'76561198179977039', 4, 'steam://joinlobby/730/10977526344135993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (39,'76561198179977039', 4, 'steam://joinlobby/730/109775263441346993547872/76561198123111486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en'),
        (40,'76561198179977039', 4, 'steam://joinlobby/730/109775263441346993547872/76561198123486213972', '2016-11-21 11:32:28', NULL, true, true, 12, true, '123.456.789:123', 16,18,0,'EU','en');




        --
        -- Tabellenstruktur fÃ¼r Tabelle `ranks`
        --

        CREATE TABLE IF NOT EXISTS `ranks` (
        `rank_id` int(10) UNSIGNED NOT NULL,
        `abbr` varchar(30) DEFAULT NULL,
        `name` varchar(40) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `ranks`
        --

        INSERT INTO `ranks` (`rank_id`, `abbr`, `name`) VALUES
        (1, 'S1', 'Silver I'),
        (2, 'S2', 'Silver II'),
        (3, 'S3', 'Silver III'),
        (4, 'S4', 'Silver IV'),
        (5, 'SE', 'Silver Elite'),
        (6, 'SEM', 'Silver Elite Master'),
        (7, 'GN1', 'Gold Nova I'),
        (8, 'GN2', 'Gold Nova II'),
        (9, 'GN3', 'Gold Nova III'),
        (10, 'GNM', 'Gold Nova Master'),
        (11, 'MG1', 'Master Guardian I'),
        (12, 'MG2', 'Master Guardian II'),
        (13, 'MGE', 'Master Guardian Elite'),
        (14, 'DMG', 'Distinguished Master Guardian'),
        (15, 'LE', 'Legendary Eagle'),
        (16, 'LEM', 'Legendary Eagle Master'),
        (17, 'SMFC', 'Supreme Master First Class'),
        (18, 'GE', 'Global Elite');

        -- --------------------------------------------------------

        --
        -- Tabellenstruktur fÃ¼r Tabelle `roles`
        --

        CREATE TABLE IF NOT EXISTS `roles` (
        `role_id` int(10) UNSIGNED NOT NULL,
        `name` varchar(30) DEFAULT NULL,
        `description` varchar(50) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `roles`
        --

        INSERT INTO `roles` (`role_id`, `name`, `description`) VALUES
        (1, 'default', NULL),
        (2, 'admin', NULL),
        (3, 'mod', NULL),
        (4, 'banned', NULL);

        -- --------------------------------------------------------

        --
        -- Tabellenstruktur fÃ¼r Tabelle `users`
        --

        CREATE TABLE IF NOT EXISTS `users` (
        `steam_id` varchar(255) NOT NULL,
        `loccountrycode` char(2) DEFAULT NULL,
        `lobby_id` int(10) UNSIGNED DEFAULT NULL,
        `avatar` varchar(255) DEFAULT NULL,
        `avatarmedium` varchar(255) DEFAULT NULL,
        `avatarfull` varchar(255) DEFAULT NULL,
        `personaname` varchar(255) DEFAULT NULL,
        `profileurl` varchar(255) DEFAULT NULL,
        `playtime` int(11) DEFAULT NULL,
        `role_id` int(10) UNSIGNED DEFAULT '1',
        `created` datetime DEFAULT NULL,
        `modified` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        --
        -- Daten fÃ¼r Tabelle `users`
        --

        INSERT INTO `users` (`steam_id`, `loccountrycode`, `lobby_id`, `avatar`, `avatarmedium`, `avatarfull`, `personaname`, `profileurl`, `playtime`, `role_id`, `created`, `modified`) VALUES
        ('76561198126151402', 'DE', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_full.jpg', 'Semaphor5', 'http://steamcommunity.com/id/stablestorage/', 900, 1, '2016-11-21 11:15:42', NULL),
        ('76561198126151403', 'US', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_full.jpg', 'Statsu', 'http://steamcommunity.com/id/stablestorage/', 1402, 1, '2016-11-21 11:15:42', NULL),
        ('76561198126151404', 'GB', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/c7/c72fd66d8bd545232dfe7d103e2c67c94d4940e5.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/c7/c72fd66d8bd545232dfe7d103e2c67c94d4940e5_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/c7/c72fd66d8bd545232dfe7d103e2c67c94d4940e5_full.jpg', 'Exampler', 'http://steamcommunity.com/id/stablestorage/', 900, 1, '2016-11-21 11:15:42', NULL),
        ('76561198126151405', 'CH', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f0/f045e851a26a02eb4069842bec5f491d6779e194_full.jpg', 'MaxM', 'http://steamcommunity.com/id/stablestorage/', 1402, 1, '2016-11-21 11:15:42', NULL),
        ('76561198126151406', 'IN', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/afb7a1576fa96abc303fd71d7bd26f8892851a15.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/afb7a1576fa96abc303fd71d7bd26f8892851a15_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/afb7a1576fa96abc303fd71d7bd26f8892851a15_full.jpg', 'aoba', 'http://steamcommunity.com/id/stablestorage/', 900, 1, '2016-11-21 11:15:42', NULL),
        ('76561198126151407', 'DE', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5d/5d0cc83daf9d21c3765828b4fc0a49e6709f691b.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5d/5d0cc83daf9d21c3765828b4fc0a49e6709f691b_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5d/5d0cc83daf9d21c3765828b4fc0a49e6709f691b_full.jpg', 'Mushu', 'http://steamcommunity.com/id/stablestorage/', 1505, 2, '2016-11-21 11:32:28', '2017-02-03 14:41:45'),
        ('76561198179977039', 'DE', NULL, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39a4e79c4da85717f07b0e2a75b338d7176158c3.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39a4e79c4da85717f07b0e2a75b338d7176158c3_medium.jpg', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39a4e79c4da85717f07b0e2a75b338d7176158c3_full.jpg', 'Semaphor', 'http://steamcommunity.com/profiles/76561198179977039/', 845, 1, '2016-11-21 11:15:42', '2017-02-02 10:48:28');

        --
        -- Indizes der exportierten Tabellen
        --

        --
        -- Indizes fÃ¼r die Tabelle `chat_messages`
        --
        ALTER TABLE `chat_messages`
        ADD PRIMARY KEY (`message_id`),
        ADD KEY `sent_by` (`sent_by`);

        --
        -- Indizes fÃ¼r die Tabelle `continents`
        --
        ALTER TABLE `continents`
        ADD PRIMARY KEY (`code`);

        --
        -- Indizes fÃ¼r die Tabelle `countries`
        --
        ALTER TABLE `countries`
        ADD PRIMARY KEY (`code`),
        ADD KEY `continent_code` (`continent_code`);

        --
        -- Indizes fÃ¼r die Tabelle `lobbies`
        --
        ALTER TABLE `lobbies`
        ADD PRIMARY KEY (`lobby_id`),
        ADD UNIQUE KEY `url` (`url`),
        ADD KEY `region` (`region`),
        ADD KEY `rank_from` (`rank_from`),
        ADD KEY `rank_to` (`rank_to`),
        ADD KEY `owner_id` (`owner_id`);

        --
        -- Indizes fÃ¼r die Tabelle `ranks`
        --
        ALTER TABLE `ranks`
        ADD PRIMARY KEY (`rank_id`);

        --
        -- Indizes fÃ¼r die Tabelle `roles`
        --
        ALTER TABLE `roles`
        ADD PRIMARY KEY (`role_id`);

        --
        -- Indizes fÃ¼r die Tabelle `users`
        --
        ALTER TABLE `users`
        ADD PRIMARY KEY (`steam_id`),
        ADD KEY `loccountrycode` (`loccountrycode`),
        ADD KEY `role_id` (`role_id`),
        ADD KEY `lobby_id` (`lobby_id`);

        --
        -- AUTO_INCREMENT fÃ¼r exportierte Tabellen
        --

        --
        -- AUTO_INCREMENT fÃ¼r Tabelle `chat_messages`
        --
        ALTER TABLE `chat_messages`
        MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;
        --
        -- AUTO_INCREMENT fÃ¼r Tabelle `lobbies`
        --
        ALTER TABLE `lobbies`
        MODIFY `lobby_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
        --
        -- AUTO_INCREMENT fÃ¼r Tabelle `ranks`
        --
        ALTER TABLE `ranks`
        MODIFY `rank_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
        --
        -- AUTO_INCREMENT fÃ¼r Tabelle `roles`
        --
        ALTER TABLE `roles`
        MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
        --
        -- Constraints der exportierten Tabellen
        --

        --
        -- Constraints der Tabelle `chat_messages`
        --
        ALTER TABLE `chat_messages`
        ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`sent_by`) REFERENCES `users` (`steam_id`) ON DELETE CASCADE;

        --
        -- Constraints der Tabelle `countries`
        --
        ALTER TABLE `countries`
        ADD CONSTRAINT `fk_countries_continents` FOREIGN KEY (`continent_code`) REFERENCES `continents` (`code`);

        --
        -- Constraints der Tabelle `lobbies`
        --
        ALTER TABLE `lobbies`
        ADD CONSTRAINT `lobbies_ibfk_1` FOREIGN KEY (`region`) REFERENCES `continents` (`code`) ON DELETE CASCADE,
        ADD CONSTRAINT `lobbies_ibfk_2` FOREIGN KEY (`rank_from`) REFERENCES `ranks` (`rank_id`) ON DELETE CASCADE,
        ADD CONSTRAINT `lobbies_ibfk_3` FOREIGN KEY (`rank_to`) REFERENCES `ranks` (`rank_id`) ON DELETE CASCADE,
        ADD CONSTRAINT `lobbies_ibfk_4` FOREIGN KEY (`owner_id`) REFERENCES `users` (`steam_id`) ON DELETE CASCADE;

        --
        -- Constraints der Tabelle `users`
        --
        ALTER TABLE `users`
        ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`loccountrycode`) REFERENCES `countries` (`code`),
        ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
        ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`lobby_id`) REFERENCES `lobbies` (`lobby_id`) ON DELETE SET NULL;

        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
