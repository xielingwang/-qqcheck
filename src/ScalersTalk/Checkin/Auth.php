<?php
/**
 * @Author: AminBy
 * @Date:   2016-10-16 16:50:30
 * @Last Modified by:   AminBy
 * @Last Modified time: 2016-10-28 01:10:57
 */
namespace ScalersTalk\Checkin;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;
use \LeanCloud\Client;
use \LeanCloud\Storage\CookieStorage;
use \LeanCloud\Engine\SlimEngine;
use \LeanCloud\Query;
use \LeanCloud\Object;

class Auth extends CheckinBase {
    const KEY = '_CHECKINUSER';
    public function needAdmin(Request $req, Response $resp, $args) {
        if(empty($_SESSION[self::KEY]) 
            || empty($_SESSION[self::KEY]['type'])
            || $_SESSION[self::KEY]['type'] != 'admin') {
            return $resp->withStatus(302)->withHeader('Location', $this->app->router->pathFor('auth-login'));
        }
    }

    public function login(Request $req, Response $resp, $args) {
        $body = $req->getParsedBody();
        extract($body);

        if($user == 'zoe' && $pass == 'lily') {
            $_SESSION[self::KEY] = [
                'type' => 'admin',
                'user' => $user,
            ];
            return $resp->withStatus(302)->withHeader('Location', $this->app->router->pathFor('admin-home'));
        }
    }
}