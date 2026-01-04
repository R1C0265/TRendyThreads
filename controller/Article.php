<?php


class Article extends Database {
    private $titles;
    private $codes;

    public function get_details($title, $code){
        $details = $this->query("SELECT * FROM news WHERE title='$title' AND code='$code'")->fetchAll();
        return $details;
    }
}