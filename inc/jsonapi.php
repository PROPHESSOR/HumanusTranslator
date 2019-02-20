<?php

class JSON {
    public static function read($file) {
        $tmp = file_get_contents('data/' . $file . '.json');

        $json = json_decode($tmp, True);

        return $json;
    }

    public static function save($file, $json) {
        $tmp = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents('data/' . $file . '.json', $tmp);
    }
}

class User {
    public  $user_user           = null;
    public  $user_id             = null;
    private $isnew               = true;

    public function __construct($user) {
        // if(!($user['login'] || $user['id'])) // TODO:

        $this->user_user  = $user;

        $this->isnew      = $user['isnew'];
        $this->user_id    = $user['id'];

        unset($this->user_user['isnew']);
    }

    public function addIP($ip) {
        $this->user_ips[] = $ip;
        $this->user_user['ips'][] = $ip;
    }

    public function save() {
        $json = JSON::read('users');

        if(!$this->isnew) {
            $json[$this->user_id] = $this->user_user;
        } else {
            $json[] = $this->user_user;
        }

        JSON::save('users', $json);
    }

    public static function login($login, $password) {
        $users = JSON::read('users');
        $loggedin = false;
        $tmp = null;

        for($i = 0; $i < count($users); $i++) {
            if($users[$i]['login'] == $login && $users[$i]['password'] == md5($password)) {
                $loggedin = true;
                $tmp = $users[$i];
                $tmp['id'] = $i;
                $tmp['isnew'] = false;
                break;
            }
        }

        if($loggedin) {
            return new User($tmp);
        } else {
            return false;
        }
    }

    public static function isLoginExist($login) {
        $users = JSON::read('users');

        for($i = 0; $i < count($users); $i++) {
            if($users[$i]['login'] == $login) {
                return true;
            }
        }

        return false;
    }
}