<?php

class Paginate {
    public $current_page;
    public $items_per_page;
    public $items_total_count;
    public $paginations_per_page;

    public function __construct($page=1, $items_per_page=4, $items_total_count=0, $paginations_per_page=1) {
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
        $this->paginations_per_page = (int)$paginations_per_page;
    }

    public function next() {
        return $this->current_page +1;
    }

    public function previous() {
        return $this->current_page -1;
    }

    public function page_total() {
        return ceil($this->items_total_count/$this->items_per_page);
    }

    // Limit number of paginations
    public function show_pagination($location) {
        $middle = ceil($this->paginations_per_page/2);
        $last_pagination_set = $this->page_total() - $this->paginations_per_page +1;

        if($this->page_total() <= $this->paginations_per_page) {
            $init = 1;
            $iteration = $this->page_total();

        } elseif ($this->page_total() > $this->paginations_per_page) {

            if($this->current_page <= $middle) {
                $init = 1;
                $iteration = $this->paginations_per_page;

            } elseif($this->current_page >= $last_pagination_set) {
                $init = $last_pagination_set;
                $iteration = $this->page_total();

            } elseif($this->current_page >= $middle) {
                $init = $this->current_page - $middle;
                $iteration = $this->paginations_per_page;
            } 
        }

        for($i=$init; $i <= $iteration; $i++) {
            if($i == $this->current_page) {
                echo "<li class='active'><a href='{$location}?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='{$location}?page={$i}'>{$i}</a></li>";
            }
        }
    }

    public function has_previous($location) {
        if($this->previous() >=1) {
            echo "<li><a href='{$location}?page={$this->previous()}'><i class='fas fa-angle-left'></i></a></li>";
        }
    }

    public function has_next($location) {
        if($this->next() <= $this->page_total()) {
            echo "<li><a href='{$location}?page={$this->next()}'><i class='fas fa-angle-right'></i></a></li>";
        }
    }

    public function offset() {
        return ($this->current_page -1) * $this->items_per_page;
    }

} // end of class Paginate


?>