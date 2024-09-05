<?php 

require_once 'include/functions.php';
require_once 'include/books.class.php';

$book_title = $barcode = $authors_name = $genre = $publisher = $publication_date = $edition = $number_of_copies = $format = $book_rating = $description = '';
$age_group_array = [];

$book_titleErr = $barcodeErr = $authors_nameErr = $genreErr = $publisherErr = $publication_dateErr = $editionErr = $number_of_copiesErr = $formatErr = $age_groupErr = $book_ratingErr = $descriptionErr = '';

if (isset($_GET['book_selected'])) {
    $id = $_GET['book_selected'];
    $selected_book = new Books();
    $book_contents = $selected_book->showbookonly($id);

    // Populate form with current book data
    $book_title = $current_title = $book_contents['book_title'];  
    $barcode = $current_barcode = $book_contents['barcode'];  
    $authors_name = $current_author = $book_contents['authors_name'];
    $genre = $current_genre = $book_contents['genre'];
    $publisher = $current_publisher = $book_contents['publisher'];
    $publication_date = $current_publication_date = $book_contents['publication_date'];
    $edition = $current_edition = $book_contents['edition'];
    $number_of_copies = $current_copies = $book_contents['number_of_copies'];
    $format = $current_format = $book_contents['format'];
    $age_group_array = $current_age_group = explode(',', $book_contents['age_group']);
    $book_rating = $current_rating = $book_contents['book_rating'];
    $description = $current_description = $book_contents['description'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $book_title = clean_input($_POST['book_title']);
    $barcode = clean_input($_POST['barcode']);
    $authors_name = clean_input($_POST['authors_name']);
    $genre = clean_input($_POST['genre']);
    $publisher = clean_input($_POST['publisher']);
    $publication_date = clean_input($_POST['publication_date']);
    $edition = clean_input($_POST['edition']);
    $number_of_copies = clean_input($_POST['number_of_copies']);
    $format = isset($_POST['format']) ? clean_input($_POST['format']) : '';
    $book_rating = clean_input($_POST['book_rating']);
    $description = clean_input($_POST['description']);
    $age_group_array = isset($_POST['age_group']) && is_array($_POST['age_group']) ? $_POST['age_group'] : [];
    $age_group = implode(',', $age_group_array);

    // Fetch current book's barcode from the database
    $current_book_id = $_GET['book_selected'] ?? null;
    $booksObj = new Books();
    $current_book = $current_book_id ? $booksObj->showbookonly($current_book_id) : null;
    $current_barcode = $current_book ? $current_book['barcode'] : '';

    // Validation
    if (empty($book_title)) {
        $book_titleErr = "This Field is required";
    }

    if (empty($barcode)) {
        $barcodeErr = "This field is required";
    } else {
        // Check if the barcode is already in use, excluding the current book's barcode
        $barcodes = $booksObj->checkBarcodeExists($barcode);
        if ($barcodes && $barcode !== $current_barcode) {
            $barcodeErr = "Barcode $barcode already exists";
        }
    }

    if (empty($authors_name)) {
        $authors_nameErr = "This Field is required";
    }

    if (empty($genre)) {
        $genreErr = "This Field is required";
    }

    if (empty($publisher)) {
        $publisherErr = "This Field is required";
    }

    if (empty($publication_date)) {
        $publication_dateErr = "This Field is required";
    }

    if (empty($edition)) {
        $editionErr = "This Field is required";
    }

    if (empty($number_of_copies)) {
        $number_of_copiesErr = "This Field is required";
    } else if (!is_numeric($number_of_copies)) {
        $number_of_copiesErr = "Number of Copies must be a number";
    } else if ($number_of_copies < 1) {
        $number_of_copiesErr = "Number of Copies must be greater than 0";
    }

    if (empty($format)) {
        $formatErr = "This Field is required";
    }

    if (empty($age_group)) {
        $age_groupErr = "This Field is required";
    }

    if (empty($book_rating)) {
        $book_ratingErr = "This Field is required";
    }

    // Check if there are no errors
    if (empty($book_titleErr) && empty($barcodeErr) && empty($authors_nameErr) && empty($genreErr) && empty($publisherErr) && empty($publication_dateErr) && empty($editionErr) && empty($number_of_copiesErr) && empty($formatErr) && empty($age_groupErr) && empty($book_ratingErr)) {
        $booksObj->book_title = $book_title;
        $booksObj->barcode = $barcode;  
        $booksObj->authors_name = $authors_name;
        $booksObj->genre = $genre;
        $booksObj->publisher = $publisher;
        $booksObj->publication_date = $publication_date;
        $booksObj->edition = $edition;
        $booksObj->number_of_copies = $number_of_copies;
        $booksObj->format = $format;
        $booksObj->age_group = $age_group;
        $booksObj->book_rating = $book_rating;
        $booksObj->description = $description;

        if ($booksObj->update($current_book_id)) { // Use appropriate method for update
            header('Location: addbooks.php?success=true');  
            exit;
        } else {
            echo "Failed to update book";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Records</title>
    <link rel="stylesheet" href="css/general.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <main>
        <header class="header1">
            <div>
                <h1 class="logo">LIBRARY 
                    <span class="records">- RECORDS -</span>
                </h1>
            </div>
            <nav>
                <ul>
                    <li class="view"><a href="viewbooks.php">VIEW BOOKS</a></li>
                    <li class="log-in"><a href="#">LOG IN</a></li>
                </ul>
            </nav>
        </header>
        <section class="section1">

            

        <form class="form" action="" method="post">
    <div class="left-form">
        <h1>ADD A NEW BOOK TO THE LIBRARY</h1>
        <div>
            <label for="book_title">Book Title</label> 
            <span class="error"> 
                * <?php echo $book_titleErr; ?>
            </span>
        </div>
        <input type="text" name="book_title" id="book_title" placeholder="Enter Book Title" value="<?= htmlspecialchars($book_title) ?>">

        <div>
            <label for="barcode">Bar Code</label> 
            <span class="error"> 
                * <?php echo $barcodeErr; ?>
            </span>
        </div>
        <input type="text" name="barcode" id="barcode" placeholder="Enter Bar Code" value="<?= htmlspecialchars($barcode) ?>">
        
        <div>
            <label for="authors_name">Author's Name</label>
            <span class="error"> 
                * <?php echo $authors_nameErr; ?>
            </span>
        </div>
        <input type="text" name="authors_name" id="authors_name" placeholder="Enter Lead Author's Name" value="<?= htmlspecialchars($authors_name) ?>">
        
        <div>
            <label for="genre">Genre</label>
            <span class="error">
                * <?php echo $genreErr; ?>
            </span>
        </div>
        <select name="genre" id="genre">
            <option class="selects" value="">--Select--</option>
            <option value="Fiction" <?= $genre == 'Fiction' ? 'selected' : '' ?>>Fiction</option>
            <option value="History" <?= $genre == 'History' ? 'selected' : '' ?>>History</option>
            <option value="Novel" <?= $genre == 'Novel' ? 'selected' : '' ?>>Novel</option>
            <option value="Fantasy" <?= $genre == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
            <option value="Science Fiction" <?= $genre == 'Science Fiction' ? 'selected' : '' ?>>Science Fiction</option>
            <option value="Action" <?= $genre == 'Action' ? 'selected' : '' ?>>Action</option>
            <option value="Adventure" <?= $genre == 'Adventure' ? 'selected' : '' ?>>Adventure</option>
            <option value="Mystery" <?= $genre == 'Mystery' ? 'selected' : '' ?>>Mystery</option>
            <option value="Historical Fiction" <?= $genre == 'Historical Fiction' ? 'selected' : '' ?>>Historical Fiction</option>
            <option value="Romance" <?= $genre == 'Romance' ? 'selected' : '' ?>>Romance</option>
            <option value="Horror" <?= $genre == 'Horror' ? 'selected' : '' ?>>Horror</option>
            <option value="Isekai" <?= $genre == 'Isekai' ? 'selected' : '' ?>>Isekai</option>
        </select>
        
        <div>
            <label for="publisher">Publisher</label>
            <span class="error">
                * <?php echo $publisherErr; ?>
            </span>
        </div>
        <input type="text" name="publisher" id="publisher" placeholder="Enter Publisher's Company Name" value="<?= htmlspecialchars($publisher) ?>">
        
        <div>
            <label for="publication_date">Publication Date</label>
            <span class="error">
                * <?php echo $publication_dateErr; ?>
            </span>
        </div>
        <input type="date" name="publication_date" id="publication_date" value="<?= htmlspecialchars($publication_date) ?>">
        
        <div>
            <label for="edition">Edition</label>
            <span class="error">
                * <?php echo $editionErr; ?>
            </span>
        </div>
        <input type="text" name="edition" id="edition" placeholder="Enter Edition Number" value="<?= htmlspecialchars($edition) ?>">
        
    </div>
    <div class="right-form">
        <div class="container">
            <div>
                <label for="number_of_copies">Number of Copies</label>
                <span class="error">
                    * <?php echo $number_of_copiesErr; ?>
                </span>
            </div>
            <input type="text" name="number_of_copies" id="number_of_copies" placeholder="Enter Number of Available Copies" value="<?= htmlspecialchars($number_of_copies) ?>">
            
            <div>
                <label for="format">Format</label>
                <span class="error">
                    * <?php echo $formatErr; ?>
                </span>
            </div>
            <div class="radio-container">
                <div>
                    <input type="radio" name="format" id="hardbound" value="Hardbound" <?= $format == 'Hardbound' ? 'checked' : '' ?>>
                    <label for="hardbound">Hardbound</label>
                </div>
                <div>
                    <input type="radio" name="format" id="softbound" value="Softbound" <?= $format == 'Softbound' ? 'checked' : '' ?>>
                    <label for="softbound">Softbound</label>
                </div>
            </div>
            
            <div>
                <label for="age_group">Age Group</label>
                <span class="error">* <?php echo $age_groupErr; ?></span>
            </div>
            <div class="checkbox-container">
                <div>
                    <input type="checkbox" name="age_group[]" id="kids" value="Kids" <?= in_array('Kids', $age_group_array) ? 'checked' : '' ?>>    
                    <label for="kids">Kids</label>
                </div>
            
                <div>
                    <input type="checkbox" name="age_group[]" id="teens" value="Teens" <?= in_array('Teens', $age_group_array) ? 'checked' : '' ?>>   
                    <label for="teens">Teens</label>
                </div>
            
                <div>
                    <input type="checkbox" name="age_group[]" id="adults" value="Adults" <?= in_array('Adults', $age_group_array) ? 'checked' : '' ?>>  
                    <label for="adults">Adults</label>
                </div>
            </div>
            
            <label for="book_rating">Book Rating</label>
            <div class="rating-container">
                <label for="one_star">1 star</label>
                <input type="range" name="book_rating" id="book_rating" min="1" max="5" step="1" value="<?= htmlspecialchars($book_rating) ?>">
                <label for="five_star">5 star</label>
            </div>
            
            <label for="description">Description</label>
            <textarea name="description" id="description" placeholder="Enter Book Description(Optional)"><?= htmlspecialchars($description) ?></textarea>
        </div>
        
        <button type="submit">SAVE BOOK</button>
    </div>
</form>


        </section>
    </main>
</body>
</html>