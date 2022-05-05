<?php 

class Db_object {
    public static function find_all() {
        return static::find_by_query("SELECT * FROM " .static::$db_table ." ");
    }

    public static function count_all() {
        return count(static::find_all());

    }
    public static function find_by_query($sql) {
        global $database;

        $result_set = $database->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    
    public static function instantiation($the_record) {
        $calling_class = get_called_class();

        $the_object = new $calling_class;

        foreach($the_record as $the_attribute => $value) {
            if($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    public function properties() {
        $properties = array();
        foreach(static::$db_table_fields as $db_field) {
            $properties[$db_field] = $this->$db_field;
        }
        return $properties;
    }

    public function clean_properties() {
        global $database;

        $clean_properties = array();

        foreach($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }
} // end of class Db_object
?>