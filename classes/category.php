<?php 
class Category extends Db_object {
    protected static $db_table = "search_category";
    protected static $id_name = "search_category_id";
    protected static $db_table_fields = array('search_category_id', 'table_name', 'display_name');
    
    public $search_category_id;
    public $table_name;
    public $display_name;

    public static function fetchCategoryName($searchCategory) {
        global $database;
 
        $searchCategory = $database->escape_string($searchCategory);
        $sql = "SELECT * FROM ".static::$db_table ." WHERE table_name = '{$searchCategory}' LIMIT 1 ";
        $the_result_array = static::find_by_query($sql);
        return $the_result_array ? $the_result_array[0]->display_name: null;
    }
}
?>