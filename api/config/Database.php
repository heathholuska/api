<?php
class Database
{
    // Render Internal Credentials
    // remember to update to env
    private $host = "dpg-d72tg895pdvs73f3tri0-a.oregon-postgres.render.com";
    private $db_name = "quotesdb_e4p5";
    private $username = "hholuska";
    private $password = "MpNTB0w8NKuvQavJ971sheuwmloueNjZ";
    private $port = "5432";
    public ?PDO $conn;

    public function connect(): ?PDO
    {
        $this->conn = null;

        try {
            // Login statement
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;

            $this->conn = new PDO($dsn, $this->username, $this->password);


            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
