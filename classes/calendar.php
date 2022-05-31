<?php

class Calendar {

    protected $month;
    public $timestamp;
    public $calendar_title;
    protected $day_count;
    protected $day_of_week; 
    private $weeks;
    private $week;

    public function __construct() {
        $this->month();
        $this->timestamp();
        $this->createCalendarTitle();  
        $this->weeks = array();
        $this->week = '';
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
        echo date('Y-m', strtotime('+1 month', $this->timestamp));
    }

    public function showCalendar() {
        $today = date('j-m-Y');
        $this->day_count = date('t', $this->timestamp);
        $this->day_of_week = date('N', $this->timestamp);

        $date = new DateTime($this->month);
        $display_month = $date->format('m-Y');
        
        $this->addBlankForBeginning();
        
        for($day = 1; $day <= $this->day_count; $day++, $this->day_of_week++) {
            $date = $day .'-' .$display_month; 

            if($today == $date) {
                $this->week .= "<td class='today'>";
            } else {
                $this->week .= "<td>";
            }

            $reservation_table = $this->makeReservationTable($day);
            $this->week .=  $reservation_table . "</td>";
            
            if($this->day_of_week % 7 == 0 || $day == $this->day_count) {
                $this->addBlankForEnd($day); 
    
                $this->weeks[] = '<tr>' .$this->week .'</tr>';
                $this->week = '';
            }       
        }

        foreach($this->weeks as $this->week) {
            echo $this->week;
        }

        $this->saveMonth();
    }

    private function makeReservationTable($day) {
        $search_date = "{$this->month}-{$day}";
        $reservation = new Reservation();
        $reservations = $reservation->selectByRequestDate($search_date);
        $num_result = count($reservations);

        $reservation_table = "<table class='reservations'><tr><td>{$day}</td></tr>";
        if($num_result > 0) {
            if($num_result >= 2) {
                $length = 1;
            } else {
                $length = $num_result -1;
            }
            
            for($i = 0; $i <= $length; $i++) {
                $reservation_table .= "<tr><td><a href='reservation.php?source=details&r_id={$reservations[$i]->request_id}'>{$reservations[$i]->formatTime()} {$reservations[$i]->request_num_seats} Seats</a></td></tr>";
            }

            if($length <= 1) {
                $reservation_table .= str_repeat("<tr><td></td></tr>", 3 - ($length + 1));
            } else {
                $plus = $num_result - 2;
                $reservation_table .= "<tr><td class='plus'><a href='reservation.php?source=details&r_id={$reservations[2]->request_id}'>+ {$plus}</a></td></tr>";
            }
        } else {
            $reservation_table .= str_repeat("<tr><td></td></tr>", 3);
        }
        return $reservation_table .= "</table>";
    }

    private function addBlankForBeginning() {
        $this->week .= str_repeat('<td></td>', $this->day_of_week-1);
    } 

    private function addBlankForEnd($day) {
        if($day == $this->day_count && $this->day_of_week % 7 != 0) {
            $this->week .= str_repeat('<td></td>', 7 - $this->day_of_week % 7);
        }
    }

    private function saveMonth() {
        global $session;

        $_SESSION['displayedMonth'] = $this->month;
    }
    
}