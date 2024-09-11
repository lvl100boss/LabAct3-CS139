<?php 
    require_once 'include/books.class.php';

    $booksObj = new Books();
    $array = $booksObj->showAll();
    $keyword = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
        $keyword = htmlentities($_POST['keyword']);
        $genre = htmlentities($_POST['genre']);
        $format = htmlentities($_POST['format']);
        $age_group_array = isset($_POST['age_group']) ? $_POST['age_group'] : [];
    
        $keyword = "%$keyword%"; // For LIKE clause
        $array = $booksObj->searchResult($keyword, $genre, $format, $age_group_array);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="css/general.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="css/styles2.css?v=<?php echo time(); ?>">
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
                    <li class="view"><a href="addbooks.php">ADD BOOKS</a></li>
                    <li class="log-in"><a href="#">LOG IN</a></li>
                </ul>
            </nav>
        </header>
        

    <section class="extra-section">
    <form method="POST" class="filters-container">
        <div class="left-filter-container">
            <div>
                <label for="genre">Genre</label>
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
            </div>
            <div>
                <label for="format">Format</label>
                <select name="format" id="format">
                    <option class="selects" value="">--Select--</option>
                    <option value="Hardbound" <?=(isset($format) && $format == 'Hardbound')? 'selected=true':'' ?>>Hardbound</option>
                    <option value="Softbound" <?=(isset($format) && $format == 'Softbound')? 'selected=true':'' ?>>Softbound</option>
                </select>
            </div>
            
        </div>
        <div class="middle">
            <label for="age_group">Age Group</label>
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
        </div>
        <div class="search-container">
            <input class="search" type="text" placeholder="Search here" name="keyword">
            <input type="submit" name="search" value="Search">
        </div>
    </form>
    </section>

     <section class="section1">
        
        <table class="table">
            <tr class="header-row">
                <th>No.</th>
                <th>Book Title</th>
                <th>Barcode</th>
                <th>Author's Name</th>
                <th>Genre</th>
                <th>Publication Date</th>
                <th>Edition</th>
                <th>Number of Copies</th>
                <th>Format</th>
                <th>Age Group</th>
                <th>Book Rating</th>
                <th>Description</th>
                <th>Options</th>
            </tr>
            
            <?php 
                $i = 1;
                foreach ($array as $row) {
            ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['book_title']; ?></td>
                    <td><?php echo $row['barcode']; ?></td>
                    <td><?php echo $row['authors_name']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td><?php echo $row['publication_date']; ?></td>
                    <td><?php echo $row['edition']; ?></td>
                    <td><?php echo $row['number_of_copies']; ?></td>
                    <td><?php echo $row['format']; ?></td>
                    <td><?php echo $row['age_group']; ?></td>
                    <td><?php echo $row['book_rating']; ?></td>
                    <td class="description"><?php echo $row['description']; ?></td>
                    <td>
                        <div class="option-div">
                            <a class="edit-button" href="editbook.php?book_selected=<?= $row['id']?>">Edit</a>
                            <a class="delete-button" data-id="<?= $row['id']?>" data-name="<?= $row['book_title']?>">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php    
                $i++;
                }
            ?>
        </table>
     </section>
   </main>

   <script src="js/script.js"></script>
</body>
</html>

<!-- 

    SEARCH:
    title
    author

    Dropdown Filter :
    Genre
    Format

    Checkbox Filter:
    Age Group 
            
-->