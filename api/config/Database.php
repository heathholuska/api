<?php
class Database
{
    // Only put the actual hostname here
    private $host = "dpg-d72tg895pdvs73f3tri0-a.oregon-postgres.render.com"; 
    private $port = "5432";
    private $db_name = "quotesdb_e4p5";
    private $username = "hholuska";
    private $password = "MpNTB0w8NKuvQavJ971sheuwmloueNjZ";
    private $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            // Construct the DSN correctly
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
