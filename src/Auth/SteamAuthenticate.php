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
        $steamauth['domainname'] = "http://localhost/cakephp-blog-tutorial-master/"; // The main URL of your website displayed in the login page
        $steamauth['apikey'] = "07A5DA78F41F32FF1A3DF737DACED598";

        $openid = new \LightOpenID($steamauth['domainname']);
        if (!$openid->mode) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
            $_POST[$openid];
        } elseif ($openid->mode == 'cancel') {
            return false;
        } else {
            if ($openid->validate()) {
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);

                debug($matches[1]);// steam id

                // TODO outsource in method getuser? (but need matches[1] maybe make it global?)
                // fetch user info here like: (see userinfo.php)
                $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$matches[1]);
                $content = json_decode($url, true);
                $user['steam_steamid'] = $content['response']['players'][0]['steamid'];
                $user['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
                $user['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
                $user['steam_personaname'] = $content['response']['players'][0]['personaname'];
                $user['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
                $user['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
                $user['steam_avatar'] = $content['response']['players'][0]['avatar'];
                $user['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
                $user['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
                $user['steam_personastate'] = $content['response']['players'][0]['personastate'];
                if (isset($content['response']['players'][0]['realname'])) {
                    $user['steam_realname'] = $content['response']['players'][0]['realname'];
                } else {
                    $user['steam_realname'] = "Real name not given";
                }
                $user['steam_primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
                $user['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
                $user['steam_uptodate'] = time();
                return $user;

                //return $this->getUser($request);

            } else {
                return false;
            }
        }
    }

    // TODO why so many errors after pc restart?
    // TODO return false if bla denie login when profile private and stuff
   /*public function getUser(Request $request)
   {
        $steamauth['apikey'] = "07A5DA78F41F32FF1A3DF737DACED598";

        // get steamid from request by trimming url
        $id = $request->query['openid_identity'];
        $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
        preg_match($ptn, $id, $matches);
        // fetch userdata
        $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$matches[1]);
        $content = json_decode($url, true);
        // set userdata
        $user = [];
        $user['steam_steamid'] = $content['response']['players'][0]['steamid'];
        $user['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
        $user['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
        $user['steam_personaname'] = $content['response']['players'][0]['personaname'];
        $user['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
        $user['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
        $user['steam_avatar'] = $content['response']['players'][0]['avatar'];
        $user['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
        $user['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
        $user['steam_personastate'] = $content['response']['players'][0]['personastate'];
        if (isset($content['response']['players'][0]['realname'])) {
            $user['steam_realname'] = $content['response']['players'][0]['realname'];
        } else {
            $user['steam_realname'] = "Real name not given";
        }
        $user['steam_primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
        $user['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
        $user['steam_uptodate'] = time();
        return $user ? $user : false;
   }*/

}