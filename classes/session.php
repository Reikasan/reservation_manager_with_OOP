<?php

class Session {
    private $signed_in = false;
    public $msg;
    public $message;
    public $current_page;
    public $current_search_page;
    public $filterParameter;
    public $searchArrayForUrl;
    
    public function __construct() {
        session_start();
        $this->check_the_login();
        $this->check_message();
        $this->check_current_page();
        $this->check_current_search_page();
        $this->check_filterParameter();
        $this->check_searchArrayForUrl();
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

    public function current_page($page = "") {
        if(!empty($page)) {
            $_SESSION['current_page'] = $page;
        } else {
            return $this->current_page;
        }
    }

    private function check_current_page() {
        if(isset($_SESSION['current_page'])) {
            $this->current_page = $_SESSION['current_page'];
        } 
    }

    public function current_search_page($page = "") {
        if(!empty($page)) {
            $_SESSION['current_search_page'] = $page;
        } else {
            return $this->current_search_page;
        }
    }

    private function check_current_search_page() {
        if(isset($_SESSION['current_search_page'])) {
            $this->current_search_page = $_SESSION['current_search_page'];
        }
    }

    public function filterParameter($filter, $filterParameter = "") {
        if(!empty($filterParameter)) {
            $_SESSION['filterParameter'] =  $filterParameter = $filter->filterParameter;
        } else {
            return $this->filterParameter;
        }
    }

    public function searchArrayForUrl($filter, $searchArrayForUrl = "") {
        if(!empty($searchArrayForUrl)) {
            $_SESSION['searchArrayForUrl'] = $searchArrayForUrl = $filter->searchArrayForUrl;
        } else {
            return $this->searchArrayForUrl;
        }
    }

    private function check_filterParameter() {
        if(isset($_SESSION['filterParameter'])) {
            $this->filterParameter = $_SESSION['filterParameter'];
        }
    }

    private function check_searchArrayForUrl() {
        if(isset($_SESSION['searchArrayForUrl'])) {
            $this->searchArrayForUrl = $_SESSION['searchArrayForUrl'];
        } else {
            $this->searchArrayForUrl = "";
        }
    } 

    public function finish_search() {
        unset($this->filterParameter);
        unset($this->searchArrayForUrl);
        unset($this->current_search_page);

        unset($_SESSION['filterParameter']);
        unset($_SESSION['searchArrayForUrl']);
        unset($_SESSION['current_search_page']);
    }
}

$session = new session();
$message = $session->message();
?>