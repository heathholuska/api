<?php
class Database
{

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public ?PDO $conn;
    // Render Internal Credentials
    // remember to update to env
    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->port = getenv('DB_PORT');
    }

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
