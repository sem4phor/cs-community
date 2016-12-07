<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 11.10.2016
 * Time: 11:23
 */
namespace Cake\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;

// TODO remove when rdy
use Cake\Log\Log;
use Cake\Core\Configure;

// TODO put this somewhere in vendor and put api key+domain somewhere else (some config stuff)
require_once("openid.php");

// credit to: https://github.com/SmItH197/SteamAuthentication/tree/master/steamauth
class SteamAuthenticate extends BaseAuthenticate
{

    /**
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function authenticate(Request $request, Response $response)
    {
        $openid = new \LightOpenID(Configure::read('domainname'));
        if (!$openid->mode) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
            $_POST[$openid];
        } elseif ($openid->mode == 'cancel') {
            return false;
        } else {
            if ($openid->validate()) {
                $id = $request->query['openid_identity'];
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
                $user['steam_id'] = $matches [1];
                return $user;
            } else {
                return false;
            }
        }
        return false;
    }

}