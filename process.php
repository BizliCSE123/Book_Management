<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        $booksJson = file_get_contents('books.json');
        $books = json_decode($booksJson, true);

        if ($action === "add") {
           
            $title = $_POST["title"];
            $author = $_POST["author"];
            $available = $_POST["available"];
            $pages = $_POST["pages"];
            $isbn = $_POST["isbn"];

            $newBook = [
                "title" => $title,
                "author" => $author,
                "available" => $available,
                "pages" => $pages,
                "isbn" => $isbn,
            ];

            $books[] = $newBook;

            
            $jsonUpdated = json_encode($books, JSON_PRETTY_PRINT);
            file_put_contents('books.json', $jsonUpdated);
            echo '<h3 >Added Result<h3>';
            echo "Book added successfully";
            echo '<table border = "1">';
            echo '<tr>';
            echo '<th>Title</th>';
            echo '<th>Author</th>';
            echo '<th>Available</th>';
            echo '<th>Pages</th>';
            echo '<th>Isbn</th>';
            echo  '</tr>';
            foreach($books as $book){
                echo '<tr>';
                foreach($book as $val){
                     echo '<td>' . $val .' </td>';
                }
                 echo '</tr>';
            }
            echo '</table>';
        } elseif ($action === "delete") {
           
            $isbnToDelete = $_POST["isbn_to_delete"];

            $found = false;

            foreach ($books as $key => $book) {
                if ($book["isbn"] == $isbnToDelete) {
                    unset($books[$key]);
                    $found = true; 
                    break;
                }
            }

            if ($found) {
            $jsonUpdated = json_encode(array_values($books), JSON_PRETTY_PRINT);
            file_put_contents('books.json', $jsonUpdated);
            echo '<h3>Deleted Result<h3>';
            echo "Book deleted successfully";
            echo '<table border = "1">';
            echo '<tr>';
            echo '<th>Title</th>';
            echo '<th>Author</th>';
            echo '<th>Available</th>';
            echo '<th>Pages</th>';
            echo '<th>Isbn</th>';
            echo '</tr>';
            foreach ($books as $book) {
            echo '<tr>';
                foreach ($book as $val) {
                    echo '<td>' . $val .' </td>';
                }
            echo '</tr>';
            }
            echo '</table>';
            } else {
            echo "Book with ISBN $isbnToDelete not found.";
            }

        }
    }
}


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action === "search") {
        $searchKeyword = $_GET["search_keyword"];

        $booksJson = file_get_contents('books.json');
        $books = json_decode($booksJson, true);
        $searchResults = [];
        foreach ($books as $book) {
            if (strtolower($book["title"]) === strtolower($searchKeyword) || strtolower($book["author"]) === strtolower($searchKeyword)) {
                $searchResults[] = $book;
            }
        }
        echo '<h3>Searched Result<h3>';
        if (count($searchResults) > 0) {
            
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Title</th>';
            echo '<th>Author</th>';
            echo '<th>Available</th>';
            echo '<th>Pages</th>';
            echo '<th>Isbn</th>';
            echo '</tr>';
            
            foreach ($searchResults as $book) {
                echo '<tr>';
                echo '<td>' . $book["title"] . '</td>';
                echo '<td>' . $book["author"] . '</td>';
                echo '<td>' . $book["available"] . '</td>';
                echo '<td>' . $book["pages"] . '</td>';
                echo '<td>' . $book["isbn"] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No matching books found.";
        }
    }

   
}
?>