<?php 

class Db_object {
    public static function find_all() {
        return static::find_by_query("SELECT * FROM " .static::$db_table ." ");
    }

    public static function count_all() {
        return count(static::find_all());
    }

    public static function find_by_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " .static::$db_table ." WHERE " .static::$id_name ." = {$id} LIMIT 1");
        return !empty($the_result_array) ? $the_result_array[0] : false;
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
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    public function clean_properties() {
        global $database;

        $clean_properties = array();

        foreach($this->properties() as $key => $value) {
            if(is_string($value)) {
                $clean_properties[$key] = $database->escape_string($value);
            }
            
        }
        return $clean_properties;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " .static::$db_table ." (" .implode(", ", array_keys($properties)) .")";
        $sql .= " VALUES ('" .implode("', '", array_values($properties)) ."') ";

        if($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $properties = $this->clean_properties();
        $properties_pair = array();

        foreach($properties as $key => $value) {
            $properties_pair[] = "{$key} = '{$value}'";  
        }

        $sql = "UPDATE " .static::$db_table ." SET ";
        $sql .= implode(", ", $properties_pair);
        $sql .= " WHERE " .static::$id_name ." = " .$database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete() {
        global $database;
        $sql = "DELETE FROM " .static::$db_table ." WHERE " .static::$id_name ." = " .$database->escape_string($this->id);
        $sql .= " LIMIT 1";
        echo $sql;
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
} // end of class Db_object
?>