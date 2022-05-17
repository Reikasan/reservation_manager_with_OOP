<?php 

class User extends DB_object {
    protected static $db_table = "users";
    protected static $db_table_fields = array('user_id', 'username', 'user_email', 'user_password', 'user_role');
    
    public $user_id;
    public $username;
    protected $user_password;
    public $user_email;
    public $user_role;

    // private static function fetch_hashed_password($username) {
    //     global $database;

    //     $username = $database->escape_string($username);
    //     $sql = "SELECT user_password FROM " .self::$db_table;
    //     $sql .= " WHERE username = '" .$username;
    //     $sql .= "' LIMIT 1 ";

    //     $resultArray = static::find_by_query($sql);
    //     $result = $resultArray[0];
    //     return !empty($result) ? $result->user_password : false;
    // }

    public static function fetch_value($username, $db_field_name) {
        global $database;

        $username = $database->escape_string($username);
        $sql = "SELECT {$db_field_name} FROM " .self::$db_table;
        $sql .= " WHERE username = '" .$username;
        $sql .= "' LIMIT 1 ";

        $resultArray = static::find_by_query($sql);
        $result = $resultArray[0];
        return !empty($result) ? $result->$db_field_name : false;
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
        $db_password = static::fetch_value($username, "user_password");

        if($db_password) {
            if(password_verify($password, $db_password)) {
                return $user = static::find_user_by_username($username);
            }
        }
        return false;
    }

    public static function verify_user_email($username, $user_email) {
        global $database;

        $user_email = $database->escape_string($user_email);
        $db_email = static::fetch_value($username, "user_email");

        if($db_email) {
            if($user_email === $db_email) {
                return true;
            }
        }
        return false;
        
        

    }

    
}