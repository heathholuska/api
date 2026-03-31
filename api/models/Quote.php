<?php
class Quote
{
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Joined Properties
    public $author;
    public $category_name;

    // Constructor with DB connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get All Quotes
    public function read()
    {
        $query = 'SELECT
                c.category as category_name,
                a.author as author_name,
                q.id,
                q.quote,
                q.author_id,
                q.category_id
            FROM
                ' . $this->table . ' q
            LEFT JOIN
                authors a ON q.author_id = a.id
            LEFT JOIN
                categories c ON q.category_id = c.id
            ORDER BY
                q.id DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Single Quote
    public function read_single()
    {
        $query = 'SELECT
                c.category as category_name,
                a.author as author_name,
                q.id,
                q.quote,
                q.author_id,
                q.category_id
            FROM
                ' . $this->table . ' q
            LEFT JOIN
                authors a ON q.author_id = a.id
            LEFT JOIN
                categories c ON q.category_id = c.id
            WHERE
                q.id = ?
            LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a row exists before assigning properties
        if ($row) {
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            $this->author = $row['author_name'];
            $this->category_name = $row['category_name'];
        }
    }

    // Create Quote
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)';

        $stmt = $this->conn->prepare($query);

        // Sanitize incoming data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }

        // Log error silently without breaking JSON output
        error_log("Database Error: " . $stmt->errorInfo()[2]);
        return false;
    }

    // Update Quote
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote, author_id = :author_id, category_id = :category_id
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize incoming data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Database Error: " . $stmt->errorInfo()[2]);
        return false;
    }

    // Delete Quote
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize incoming data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Database Error: " . $stmt->errorInfo()[2]);
        return false;
    }
}
?>