<?php 

require_once 'database.php';

class Books extends Database {
    public $id = '';
    public $book_title = '';
    public $barcode = '';
    public $authors_name = '';
    public $genre = '';
    public $publisher = '';
    public $publication_date = '';
    public $edition = '';
    public $number_of_copies = '';
    public $num_of_copies = '';
    public $format = '';
    public $age_group = '';
    public $book_rating = '';
    public $description = '';

    protected $connection;

    public function __construct() {
        $this->connection = $this->connection();
    }

    function add() {
        try {
            $sql = "INSERT INTO books (book_title, barcode, authors_name, genre, publisher, publication_date, edition, number_of_copies, format, age_group, book_rating, description) 
                    VALUES (:book_title, :barcode, :authors_name, :genre, :publisher, :publication_date, :edition, :number_of_copies, :format, :age_group, :book_rating, :description)";
    
            $query = $this->connection->prepare($sql);
    
            $query->bindParam(':book_title', $this->book_title);
            $query->bindParam(':barcode', $this->barcode);
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
    
            return $query->execute();
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] == 1062) {
                return "duplicate_barcode"; 
            }
            return false; 
        }
    }
    
    function showAll() {
        $sql = "SELECT * FROM books ORDER BY id DESC LIMIT 10;";
        $query = $this->connection->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkBarcodeExists($barcode) {
        $sql = "SELECT barcode FROM books WHERE barcode = :barcode";
        $query = $this->connection->prepare($sql);
        $query->bindParam(':barcode', $barcode, PDO::PARAM_STR);
        $query->execute();
        
        return $query->fetchColumn() > 0; 
        if ($result) {
            return false;
        } else {
            return true;
        }
    }

    function update($id) {
        // Prepare the SQL update statement
        $sql = "UPDATE books SET 
            book_title = :book_title, 
            barcode = :barcode, 
            authors_name = :authors_name, 
            genre = :genre, 
            publisher = :publisher,
            publication_date = :publication_date, 
            edition = :edition, 
            number_of_copies = :number_of_copies, 
            format = :format, 
            age_group = :age_group, 
            book_rating = :book_rating,
            description = :description 
            WHERE id = :id";
    
        // Prepare the statement
        $query = $this->connection->prepare($sql);
    
        // Bind the class properties to the query parameters
        $query->bindParam(':book_title', $this->book_title);
        $query->bindParam(':barcode', $this->barcode, PDO::PARAM_STR);
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
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    
        // Execute the update
        if ($query->execute()) {
            echo "Debug: Update successful.\n";
            return true;
        } else {
            $errorInfo = $query->errorInfo();
            echo "SQL Error: " . $errorInfo[2];
            return false;
        }
    }
    
    
    
    

    // function updates($id) {
    //     // Prepare the SQL update statement
    //     $sql = "UPDATE book_content SET 
    //         barcode = :barcode, 
    //         book_title = :book_title, 
    //         authors_name = :authors_name, 
    //         genre = :genre, 
    //         publisher = :publisher,
    //         publication_date = :publication_date, 
    //         edition = :edition, 
    //         num_of_copies = :num_of_copies, 
    //         format = :format, 
    //         age_group = :age_group, 
    //         book_rating = :book_rating,
    //         description = :description 
    //         WHERE book_id = :book_id";
    
    //     $query = $this->connection->prepare($sql);
    //     $query->execute();
    
    //     // Bind the class properties to the query parameters
    //     $query->bindParam(':barcode', $this->barcode, PDO::PARAM_STR);
    //     $query->bindParam(':book_title', $this->book_title);
    //     $query->bindParam(':authors_name', $this->authors_name);
    //     $query->bindParam(':genre', $this->genre);
    //     $query->bindParam(':publisher', $this->publisher);
    //     $query->bindParam(':publication_date', $this->publication_date);
    //     $query->bindParam(':edition', $this->edition);
    //     $query->bindParam(':num_of_copies', $this->num_of_copies);
    //     $query->bindParam(':format', $this->format);
    //     $query->bindParam(':age_group', $this->age_group);
    //     $query->bindParam(':book_rating', $this->book_rating);
    //     $query->bindParam(':description', $this->description);
    //     $query->bindParam(':id', $id, PDO::PARAM_INT);
    
    //     // Execute the update and return true if successful, false otherwise
    //     if ($query->execute()) {
    //         echo "Debug: Update successful.\n";
    //         return true;
    //     } else {
    //         echo "Debug: Update failed.\n";
    //         return false;
    //     }
    // }

    function showbookonly($id) {
        $sql = "SELECT * FROM books WHERE id = :id"; // Use the actual table and column names
        $query = $this->connection->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    
}
