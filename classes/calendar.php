<?php

class Calendar {

    private $month;
    public $timestamp;
    public $calendar_title;

    public function __construct() {
        $this->month();
        $this->timestamp();
        $this->createCalendarTitle();  
    }

    private function month() {
        if(isset($_GET['month'])) {
            return $this->month = $_GET['month'];
        } else {
            return $this->month = date('Y-m');
        }
    }

    private function timestamp() {
        return $this->timestamp = strtotime($this->month .'-01');

        if($this->timestamp === false) {
            $this->month =  date('Y-m');
            return $this->timestamp = strtotime($this->month .'-01');
        }
    }

    public function createCalendarTitle() {
        return $this->calendar_title = date('n-Y', $this->timestamp);
    }

    public function getPreviousMonth() {
        echo date('Y-m', strtotime('-1 month', $this->timestamp));
    }
    
    public function getNextMonth() {
        echo  date('Y-m', strtotime('+1 month', $this->timestamp));
    }

    public function showCalendar() {
        $today = date('j-m-Y');

        $day_count = date('t', $this->timestamp);
        $day_of_week = date('w', $this->timestamp);

        $date = new DateTime($this->month);
        $display_month = $date->format('m-Y');
        

        $weeks = array();
        $week = '';

        $week .= str_repeat('<td></td>', $day_of_week);

        for($day = 1; $day <= $day_count; $day++, $day_of_week++) {
            
            $date = $day .'-' .$display_month; 

            if($today === $date) {
                $week .= '<td class="today">' .$day;
            } else {
                $week .= '<td>' .$day;
            }
            $week .= '</td>';


            if($day_of_week % 7 == 6 || $day == $day_count) {
                if($day == $day_count) {
                    $week .= str_repeat('<td></td>', 6 - $day_of_week % 7);
                }

                $weeks[] = '<tr>' .$week .'</tr>';

                $week = '';
            }
        }

        foreach($weeks as $week) {
            echo $week;
        }
    }
    
}