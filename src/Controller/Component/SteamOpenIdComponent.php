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
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * SteamOpenId Component
 *
 * Authorizes a user with help of the openid protocol and Steam as the openid provider.
 *
 * @author Valentin Rapp (Source of validate and genURL method: https://gist.github.com/Leimi/6904467)
 */
class SteamOpenIdComponent extends Component
{
    // the identifier of the openid provider
    const STEAM_LOGIN = 'https://steamcommunity.com/openid/login';

    /**
     * validate
     *
     * Validates an openid response of the openid provider and resends an authentication request
     *
     * @return string Returns the SteamID if successful or empty string on failure
     */
    public static function validate()
    {
        // Get the response params and build them properly
        $params = array(
            'openid.assoc_handle' => $_GET['openid_assoc_handle'],
            'openid.signed' => $_GET['openid_signed'],
            'openid.sig' => $_GET['openid_sig'],
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
        );
        $signed = explode(',', $_GET['openid_signed']);
        foreach ($signed as $item) {
            $val = $_GET['openid_' . str_replace('.', '_', $item)];
            $params['openid.' . $item] = get_magic_quotes_gpc() ? stripslashes($val) : $val;
        }
        // Add the mode for checking authntication.
        $params['openid.mode'] = 'check_authentication';
        $data = http_build_query($params);
        // send data for validation
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                    "Accept-language: en\r\n" .
                    "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data,
            ),
        ));
        // get the result form the stream context
        $result = file_get_contents(self::STEAM_LOGIN, false, $context);
        // Validate wheather it's true and if we have a good ID
        preg_match("#^http://steamcommunity.com/openid/id/([0-9]{17,25})#", $_GET['openid_claimed_id'], $matches);
        $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;
        return preg_match("#is_valid\s*:\s*true#i", $result) == 1 ? $steamID64 : false;
    }

    /**
     * Get the URL to sign into steam
     *
     * @param mixed returnTo URI to tell steam where to return
     * @param bool useAmp Use &amp; in the URL, true; or just &, false.
     * @return string The openid URL
     */
    public static function genUrl($returnTo = false, $useAmp = true)
    {
        $returnTo = (!$returnTo) ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] : $returnTo;
        $params = array(
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => $returnTo,
            'openid.realm' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'],
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        );
        $sep = ($useAmp) ? '&amp;' : '&';
        return self::STEAM_LOGIN . '?' . http_build_query($params, '', $sep);
    }
}

?>