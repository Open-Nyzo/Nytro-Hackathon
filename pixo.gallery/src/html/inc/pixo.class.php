<?php

class Pixo {
    
    private $config;
    private $db;
    
    public function __construct($config) {
        global $DB;
        $this->config = $config;
        $this->db = $DB;
    }
    
    private function reinitDb() {
        global $DB;
        DB_init();
        $this->db = $DB;
    }
    
    public function getBoardName($board){
        if (!in_array($board, $this->config["boards"])){
            $board = $this->config["default_board"];
        }
        return $board;
    }
    
    public function getBoard($board=null) {
        $board = $this->getBoardName($board);
        $sql="SELECT * FROM board$board ";
        
        $reqStmt = $this->db->prepare($sql);
        $res = array();
        if ($reqStmt->execute()) {
            $res = $reqStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $res;
    }
    
    public function getPixelsAfter($height, $board=null){
        $board = $this->getBoardName($board);
        $sql="SELECT * FROM board$board WHERE height >= $height ORDER BY height ASC";
        $reqStmt = $this->db->prepare($sql);
        $res = array();
        if ($reqStmt->execute()) {
            $res = $reqStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $res;
    }
    
    public function storePaint($pixel, $color, $address, $height, $board=null) {
        $board = $this->getBoardName($board);
        $sql = "REPLACE INTO board$board set color= :color, address= :address, height= :height, pixel = :pixel";
        $reqStmt = $this->db->prepare($sql);
        $reqStmt->execute(array("address" => $address, "color" => $color, "height" => $height, "pixel" => $pixel));
    }
    
    public function updateOwner($pixel, $address, $board=null) {
        $board = $this->getBoardName($board);
        $sql = "REPLACE INTO board$board(pixel, address) VALUES (:pixel, :address)";
        $reqStmt = $this->db->prepare($sql);
        $reqStmt->execute(array("address" => $address, "pixel" => $pixel));
    }
    public function globalScore(){return 0;}
    
    public function getLastHeight(){
        $sql = "SELECT coalesce(max(height), 0) as max_height FROM board64";
        $reqStmt = $this->db->prepare($sql);
        $res = 0;
        if ($reqStmt->execute()) {
            $res = $reqStmt->fetchAll(PDO::FETCH_ASSOC)[0]["max_height"];
        }
        return $res;
    }
    
    /*
    public function globalScore(){
        $sql = "SELECT sum((id, bgcolor) in ( select id, color from target_squares)) as score FROM squares";
        $reqStmt = $this->db->prepare($sql);
        $res = 0;
        if ($reqStmt->execute()){
            $res = $reqStmt->fetchAll(PDO::FETCH_ASSOC)[0]["score"];
        }
        return intval(100 * $res/4096);
    }
    
    public function addressScore($address){
        $address = str_replace([" ",".","\\","/","*","&",'|'],"", $address);
        $sql = "SELECT sum(2*((id, bgcolor) in ( select id, color from target_squares))-1) as score FROM squares where address=:address";
        $reqStmt = $this->db->prepare($sql);
        $res = 0;
        if ($reqStmt->execute(array("address" => $address))){
            $res = $reqStmt->fetchAll(PDO::FETCH_ASSOC)[0]["score"];
        }
        return $res;
        // all scores: "SELECT address, sum(2*((id, bgcolor) in ( select id, color from target_squares))-1) as score FROM squares group by address "
    }*/
    
}
