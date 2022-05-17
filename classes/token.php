<?php

class Token extends Db_object {
    protected static $db_table = "token";
    protected static $id_name = "id";
    protected static $db_table_fields = array('id', 'user_id', 'token', 'issue_date_time', 'expire_date_time');

    public $token;
    public $length;
    public $issue_date_time;
    public $expire_date_time;
    
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
}