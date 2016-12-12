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
use Cake\ORM\TableRegistry;


// credit to: https://github.com/SmItH197/SteamAuthentication/tree/master/steamauth
class FormValueAuthenticate extends BaseAuthenticate
{

    /**
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function authenticate(Request $request, Response $response)
    {
        $model = $this->config('userModel');
        $field = $this->config('field');
        return TableRegistry::get($model)->get($request->data[$model][$field]);
    }

}