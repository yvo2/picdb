<?php
class View {
    private $name;
    public $properties = array();

    public function setName($name) {
        $this->name = $name;
    }

    public function __set($key, $value) {
        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    public function __get($key) {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }

    public function display() {
        extract($this->properties);
        require "view/$this->name.php";
    }
}
?>