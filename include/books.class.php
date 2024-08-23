<?php 

require_once 'database.php';

class Books extends Database {
    public $id = '';
    public $book_title = '';
    public $authors_name = '';
    public $genre = '';
    public $publisher = '';
    public $publication_date = '';
    public $edition = '';
    public $number_of_copies = '';
    public $format = '';
    public $age_group = '';
    public $book_rating = '';
    public $description = '';

    protected $connection;

    public function __construct() {
        $this->connection = $this->connection(); // Initialize the database connection
    }

    function add() {
        $sql = "INSERT INTO books (book_title, authors_name, genre, publisher, publication_date, edition, number_of_copies, format, age_group, book_rating, description) VALUES (:book_title, :authors_name, :genre, :publisher ,:publication_date, :edition, :number_of_copies, :format, :age_group, :book_rating, :description)";

        $query = $this->connection->prepare($sql);

        $query->bindParam(':book_title', $this->book_title);
        $query->bindParam(':authors_name', $this->authors_name);
        $query->bindParam(':genre', $this->genre);
        $query->bindParam(':publisher', $this->publisher);
        $query->bindParam(':publication_date', $this->publication_date);
        $query->bindParam(':edition', $this->edition);
        $query->bindParam(':number_of_copies', $this->number_of_copies);
        $query->bindParam(':format', $this->format);
        $query->bindParam(':age_group', $this->age_group);
        $query->bindParam(':book_rating', $this->book_rating);
        $query->bindParam(':description', $this->description);

        return $query->execute(); // Simplify return statement
    }
    
    function showAll() {
        $sql = "SELECT * FROM books";
        $query = $this->connection->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC); // Use PDO::FETCH_ASSOC for associative array
    }
}
