<?php 

require_once 'include/functions.php';
require_once 'include/books.class.php';

$book_title = $authors_name = $genre = $publisher = $publication_date = $edition = $number_of_copies = $format = $age_group = $book_rating = $description = '';

$book_titleErr = $authors_nameErr = $genreErr = $publisherErr = $publication_dateErr = $editionErr = $number_of_copiesErr = $formatErr = $age_groupErr = $book_ratingErr = $descriptionErr = '';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $book_title = clean_input($_POST['book_title']);
    $authors_name = clean_input($_POST['authors_name']);
    $genre = clean_input($_POST['genre']);
    $publisher = clean_input($_POST['publisher']);
    $publication_date = clean_input($_POST['publication_date']);
    $edition = clean_input($_POST['edition']);
    $number_of_copies = clean_input($_POST['number_of_copies']);
    $format = isset($_POST['format']) ? clean_input($_POST['format']) : '';
    $age_group = isset($_POST['age_group']) && is_array($_POST['age_group']) ? implode(',', $_POST['age_group']) : ''; // Handle checkboxes
    $book_rating = clean_input($_POST['book_rating']);
    $description = clean_input($_POST['description']);

    $age_group_array = isset($_POST['age_group']) && is_array($_POST['age_group']) ? $_POST['age_group'] : [];
    $age_group = implode(',', $age_group_array);

    // Validate fields
    if(empty($book_title)){
        $book_titleErr = "This Field is required";
    }

    if(empty($authors_name)){
        $authors_nameErr = "This Field is required";
    }

    if(empty($genre)){
        $genreErr = "This Field is required";
    }

    if(empty($publisher)){
        $publisherErr = "This Field is required";
    }

    if(empty($publication_date)){
        $publication_dateErr = "This Field is required";
    }

    if(empty($edition)){
        $editionErr = "This Field is required";
    }

    if(empty($number_of_copies)){
        $number_of_copiesErr = "This Field is required";
    } else if(!is_numeric($number_of_copies)){
        $number_of_copiesErr = "Number of Copies must be a number";
    } else if ($number_of_copies < 1){
        $number_of_copiesErr = "Number of Copies must be greater than 0";
    }

    if(empty($format)){
        $formatErr = "This Field is required";
    }

    if(empty($age_group)){
        $age_groupErr = "This Field is required";
    }

    if(empty($book_rating)){
        $book_ratingErr = "This Field is required";
    }

    // Check if there are no errors
    if(empty($book_titleErr) && empty($authors_nameErr) && empty($genreErr) && empty($publisherErr) && empty($publication_dateErr) && empty($editionErr) && empty($number_of_copiesErr) && empty($formatErr) && empty($age_groupErr) && empty($book_ratingErr)) {
        
        $booksObj = new Books();
        $booksObj->book_title = $book_title;
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

        if($booksObj->add()){
            header('Location: addbooks.php?success=true');  
            exit;
        } else {
            echo "Failed to add book";
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
                    <input type="text" name="book_title" id="book_title" placeholder="Enter Book Title" value="<?= $book_title ?>">
                    
                    <div>
                        <label for="authors_name">Author's Name</label>
                        <span class="error"> 
                            * <?php echo $authors_nameErr; ?>
                        </span>
                    </div>
                    <input type="text" name="authors_name" id="authors_name" placeholder="Enter Lead Author's Name" value="<?= $authors_name ?>">
                    
                    <div>
                        <label for="genre">Genre</label>
                        <span class="error">
                            * <?php echo $genreErr; ?>
                        </span>
                    </div>
                    <select name="genre" id="genre">
                        <option class="selects" value="">--Select--</option>
                        <option value="Fiction" <?=(isset($genre) && $genre == 'Fiction')? 'selected=true':'' ?> >Fiction</option>
                        <option value="History" <?=(isset($genre) && $genre == 'History')? 'selected=true':'' ?> >History</option>
                        <option value="Novel" <?=(isset($genre) && $genre == 'Novel')? 'selected=true':'' ?>>Novel</option>
                        <option value="Fantasy" <?=(isset($genre) && $genre == 'Fantasy')? 'selected=true':'' ?>>Fantasy</option>
                        <option value="Science Fiction" <?=(isset($genre) && $genre == 'Science Fiction')? 'selected=true':'' ?>>Science Fiction</option>
                        <option value="Action" <?=(isset($genre) && $genre == 'Action')? 'selected=true':'' ?>>Action</option>
                        <option value="Adventure" <?=(isset($genre) && $genre == 'Adventure')? 'selected=true':'' ?>>Adventure</option>
                        <option value="Mystery" <?=(isset($genre) && $genre == 'Mystery')? 'selected=true':'' ?>>Mystery</option>
                        <option value="Historical Fiction" <?=(isset($genre) && $genre == 'Historical Fiction')? 'selected=true':'' ?>>Historical Fiction</option>
                        <option value="Romance" <?=(isset($genre) && $genre == 'Romance')? 'selected=true':'' ?>>Romance</option>
                        <option value="Horror" <?=(isset($genre) && $genre == 'Horror')? 'selected=true':'' ?>>Horror</option>
                        <option value="Isekai" <?=(isset($genre) && $genre == 'Isekai')? 'selected=true':'' ?>>Isekai</option>
                    </select>
                    
                    <div>
                        <label for="publisher">Publisher</label>
                        <span class="error">
                            * <?php echo $publisherErr; ?>
                        </span>
                    </div>
                    <input type="text" name="publisher" id="publisher" placeholder="Enter Publisher's Company Name" value="<?= $publisher ?>">
                    
                    <div>
                        <label for="publication_date">Publication Date</label>
                        <span class="error">
                            * <?php echo $publication_dateErr; ?>
                        </span>
                    </div>
                    <input type="date" name="publication_date" id="publication_date" value="<?= $publication_date ?>">
                    
                    <div>
                        <label for="edition">Edition</label>
                        <span class="error">
                            * <?php echo $editionErr; ?>
                        </span>
                    </div>
                    <input type="text" name="edition" id="edition" placeholder="Enter Edition Number" value="<?= $edition ?>">
                    
                </div>
                <div class="right-form">
                    <div class="container">
                        <div>
                            <label for="number_of_copies">Number of Copies</label>
                            <span class="error">
                                * <?php echo $number_of_copiesErr; ?>
                            </span>
                        </div>
                        <input type="text" name="number_of_copies" id="number_of_copies" placeholder="Enter Number of Available Copies" value="<?= $number_of_copies ?>">
                        
                        <div>
                            <label for="format">Format</label>
                            <span class="error">
                                * <?php echo $formatErr; ?>
                            </span>
                        </div>
                        <div class="radio-container">
                            <div>
                                <input type="radio" name="format" id="hardbound" value="Hardbound"  <?= (isset($format) && $format == 'hardbound')? 'checked':'' ?>>
                                <label for="hardbound">Hardbound</label>
                            </div>
                            <div>
                                <input type="radio" name="format" id="softbound" value="Softbound" <?= (isset($format) && $format == 'softbound')? 'checked':'' ?>>
                                <label for="softbound">Softbound</label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="age_group">Age Group</label>
                            <span class="error">* <?php echo $age_groupErr; ?></span>
                        </div>
                        <div class="checkbox-container">
                            <div>
                                <input type="checkbox" name="age_group[]" id="kids" value="Kids" <?= (isset($age_group_array) && in_array('Kids', $age_group_array)) ? 'checked' : '' ?>>    
                                <label for="kids">Kids</label>
                            </div>
                        
                            <div>
                                <input type="checkbox" name="age_group[]" id="teens" value="Teens" <?= (isset($age_group_array) && in_array('Teens', $age_group_array)) ? 'checked' : '' ?>>   
                                <label for="teens">Teens</label>
                            </div>
                        
                            <div>
                                <input type="checkbox" name="age_group[]" id="adults" value="Adults" <?= (isset($age_group_array) && in_array('Adults', $age_group_array)) ? 'checked' : '' ?>>  
                                <label for="adults">Adults</label>
                            </div>
                        </div>
                        
                        <label for="book_rating">Book Rating</label>
                        <div class="rating-container">
                            <label for="one_star">1 star</label>
                            <input type="range" name="book_rating" id="book_rating" min="1" max="5" step="1">
                            <label for="five_star">5 star</label>
                        </div>
                        
                        
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="Enter Book Description(Optional)"></textarea>
                    </div>
                    
                    <button type="submit">SAVE BOOK</button>
                </div>
            </form>

        </section>
    </main>
</body>
</html>