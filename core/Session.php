<?php
class Session {
    /**
     * data(key, value) => set Session
     * data(key) => get Session
     */
    static public function data($key='', $value=''){
        $sessionKey = self::isInvalid();

        if (!empty($value)){
            if (!empty($key)){
                $_SESSION[$sessionKey][$key] = $value; //set session
                return true;
            }
            return false;

        }else{
            if (empty($key)){
                if (isset($_SESSION[$sessionKey])){
                    return $_SESSION[$sessionKey];
                }
            }else{
                if (isset($_SESSION[$sessionKey][$key])){
                    return $_SESSION[$sessionKey][$key]; //get session
                }
            }
        }
    }

    /**
     * delete(key)  => delete session with key
     * delete() => delete all session
     */

    static public function delete($key='') {
        $sessionKey = self::isInvalid();
        if(!empty($key)) {
            if(isset($_SESSION[$sessionKey][$key])) {
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
            return false;
        }else {
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }
    /*
     * Flash Data
     * - set flash data => giống như set session
     * - get flash data => giống như get session, xoá luôn session sau khi get
     * - dùng để làm các thông báo
     */
    static public function flash($key='', $value='') {
        $dataFlash = self::data($key, $value);
        if(empty($value)) {
            self::delete($key);
        }
        return $dataFlash;
    }

    static public function showError($message) {
        $data = ['message' => $message];
        App::$app->loadError('exception', $data);
        die();
    }

    static function isInvalid(){

        global $config;

        if (!empty($config['session'])){
            $sessionConfig = $config['session'];
            if (!empty($sessionConfig['session_key'])){
                $sessionKey = $sessionConfig['session_key'];
                return $sessionKey;
            }else{
                self::showError('Thiếu cấu hình session_key. Vui lòng kiểm tra file: configs/session.php');
            }
        }else{
            self::showError('Thiếu cấu hình session. Vui lòng kiểm tra file: configs/session.php');
        }
    }
}