<?php

class Session {
    private $signed_in = false;
    public $msg;
    public $message;


    function __construct() {
        session_start();
        $this->check_the_login();
        $this->check_message();
    }

    // Message
    public function message($msg="") {
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function check_message() {
        if(isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    // Login
    public function is_signed_in() {
        return $this->signed_in;
    }

    public function login($user) {
        if($user) {
            $this->user_role = $_SESSION['user_role'] = $user->user_role;
            $this->signed_in = true; 
        }
    }

    public function logout() {
        unset($_SESSION['user_role']);
        unset($this->user_role);
        $this->signed_in = false;
        self::unset_search_set();
    }

    private function check_the_login() {
        if(isset($_SESSION['user_role'])) {
            $this->user_role = $_SESSION['user_role'];
            $this->signed_in = true;
        } else {
            unset($this->user_role);
            $this->signed_in = false;
        }
    }

    // Search
    public function is_searched() {
        if(isset($_SESSION['searchText']) && isset($_SESSION['searchCategory'])) {
            return true;
        } else {
            return false;
        }
    }

    public function unset_search_set() {
        unset($_SESSION['searchText']);
        unset($_SESSION['searchCategory']);
    }
}

$session = new session();
$message = $session->message();
?>