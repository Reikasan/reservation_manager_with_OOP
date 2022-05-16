<?php 

class User extends DB_object {
    protected static $db_table = "users";
    protected static $db_table_fields = array('user_id', 'username', 'user_email', 'user_password', 'user_role');
    
    public $username;
    protected $user_password;
    public $user_email;
    public $user_role;

    private static function fetch_hashed_password($username) {
        global $database;

        $username = $database->escape_string($username);
        $sql = "SELECT user_password FROM " .self::$db_table;
        $sql .= " WHERE username = '" .$username;
        $sql .= "' LIMIT 1 ";

        $resultArray = static::find_by_query($sql);
        $result = $resultArray[0];
        return !empty($result) ? $result->user_password : false;
    }

    private static function find_user_by_username($username) {
        $sql = "SELECT * FROM " .static::$db_table;
        $sql .= " WHERE username = '" .$username;
        $sql .= "' LIMIT 1 ";

        $resultArray = static::find_by_query($sql);
        $result = $resultArray[0];
        return !empty($result) ? $result : false;
    }

    public static function verify_user($username, $password) {
        global $database;

        $password = $database->escape_string($password);
        $db_password = static::fetch_hashed_password($username);
        print_r($db_password);

        if($db_password) {
            if(password_verify($password, $db_password)) {
                return $user = static::find_user_by_username($username);
            }
        }
        return false;
    }

    
}