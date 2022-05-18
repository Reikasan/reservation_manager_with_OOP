<?php

class Token extends Db_object {
    protected static $db_table = "token";
    protected static $id_name = "id";
    protected static $db_table_fields = array('id', 'user_id', 'email', 'token', 'issue_date_time', 'expire_date_time');

    public $user_id;
    public $token;
    public $length;
    public $email;
    public $issue_date_time;
    public $expire_date_time;
    
    public static function find_by_token($sentToken) {
        global $database;
        $sentToken = $database->escape_string($sentToken);

        $sql = "SELECT * FROM " .static::$db_table ." WHERE token = '{$sentToken}' LIMIT 1";
        $the_result_array = static::find_by_query($sql);
        return !empty($the_result_array) ? $the_result_array[0] : false;
    }

    public function create_token($length) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    public static function create_issue_date() {
        return new DateTime('now');
    }

    public function format_issue_date() {
        $issue_date = self::create_issue_date();
        return $issue_date->format("Y-m-d H:m:s");
    }

    public function create_and_format_expire_date($issue_date)  {
        return $expire = $issue_date->add(new DateInterval('P1D'))->format("Y-m-d H:m:s");
    }

    public function isTokenExpired($token) {
        $user = self::find_by_token($token);
        return  self::format_issue_date() > $user->expire_date_time;
    }

    public function isEmailValid($token, $sentEmail) {
        $user = self::find_by_token($token);
        return $user->email === $sentEmail;
    }
}