<?php
$booksJson = file_get_contents('books.json');
$books = json_decode($booksJson, true);
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
?>