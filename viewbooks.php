<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="css/general.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/styles2.css?v=<?php echo time(); ?>">
</head>
<body>
   <main>
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
     <section class="section1">
        <table class="table">
            <tr class="header-row">
                <th>No.</th>
                <th>Book Title</th>
                <th>Author's Name</th>
                <th>Genre</th>
                <th>Publication Date</th>
                <th>Edition</th>
                <th>Number of Copies</th>
                <th>Format</th>
                <th>Age Group</th>
                <th>Book Rating</th>
                <th>Description</th>
            </tr>
            
            <?php 
                require_once 'include/books.class.php';
        
                $booksObj = new Books();
                $array = $booksObj->showAll();
        
                $i = 1;
                foreach ($array as $row) {
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['book_title']; ?></td>
                    <td><?php echo $row['authors_name']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td><?php echo $row['publication_date']; ?></td>
                    <td><?php echo $row['edition']; ?></td>
                    <td><?php echo $row['number_of_copies']; ?></td>
                    <td><?php echo $row['format']; ?></td>
                    <td><?php echo $row['age_group']; ?></td>
                    <td><?php echo $row['book_rating']; ?></td>
                    <td class="description"><?php echo $row['description']; ?></td>
            <?php    
                $i++;
                }
            ?>
        </table>
     </section>
   </main>
</body>
</html>