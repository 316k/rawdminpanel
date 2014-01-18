<?php

class Rawdmin {
    
    /**
     * (PDO) Database to use
     */
    private $database;

    public function Rawdmin($database) {
        $this->database = $database;
    }

    /**
     * Outputs an HTML view
     *
     * @param String $table
     * @param array $columns DB Columns to use
     * @param String $view The view/{$view}.php to use as html template
     */
    public function view($table, array $columns, $view) {
        $sql = "SELECT ";
        
        foreach($columns as $index => $column) {
            $sql .= $column;
            $sql .= ($index == count($columns) - 1) ? '' : ',';
        }
        $sql .= " FROM `$table`";

        $query = $this->database->prepare($sql);
        $query->execute();
        
        $raw = $query->fetchAll();
        $data = array();
        // Fill $data
        foreach($raw as $index => $row) {
            foreach($columns as $column) {
                $data[$index][$column] = array('column' => $row[$column], 'type' => $this->type($table, $column));
            }
        }
        
        include("views/$view.php");
    }
    
    /**
     * Save changes (this function must be called on the data treatement page)
     *
     */
    public function save($table, $array = NULL) {
        $array = ($array ? : $_POST['rawdmin']); // Default value
    }

    /**
     * @param String $table
     * @param String $column
     * @return String The type of column, one of : (int, float, boolean, string, enum, date, blob)
     */
    private function type($table, $column) {
        $query = $this->database->prepare("SHOW COLUMNS FROM `$table` WHERE `Field`=?");
        $query->execute(array($column));
        $data = $query->fetch();
        
        $type = "";
        
        // Parse type
        if(preg_match("#int#i", $data['Type'])) {
            $type = 'int';
        } elseif(preg_match("#char|text#i", $data['Type'])) {
            $type = 'string';
        } elseif(preg_match("#float|double|real#i", $data['Type'])) {
            $type = 'float';
        } elseif(preg_match("#boolean#i", $data['Type'])) {
            $type = 'boolean';
        } elseif(preg_match("#^enum#i", $data['Type'])) {
            $type = 'enum';
        } elseif(preg_match("#blob#i", $data['Type'])) {
            $type = 'blob';
        } elseif(preg_match("#date|time|year#i", $data['Type'])) { // maybe timestamp and date should be seperated
            $type = 'date';
        } else {
            throw new RuntimeException();
        }
        
        return $type;
    }

    public static function form_open($action = '', $method = 'POST') {
        echo "<form action=\"$action\" method=\"$method\">";
    }

    public static function form_close() {
        echo "</form>";
    }
}
