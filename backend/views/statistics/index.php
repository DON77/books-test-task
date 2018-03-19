<table class="table table-bordered">
    <caption>Most Sold Books</caption>
    <?php
    foreach ($mostSoldBooks as $book) {
        echo '<tr><td>' . $book . '</td></tr>';
    }
    ?>
</table>

<table class="table table-bordered">
    <caption>Most Sold Authors</caption>
    <?php
    foreach ($mostSoldAuthors as $author) {
        echo '<tr><td>' . $author . '</td></tr>';
    }
    ?>
</table>

<table class="table table-bordered">
    <caption>Most Profitable Books</caption>
    <?php
    foreach ($mostProfitableBooks as $book) {
        echo '<tr><td>' . $book . '</td></tr>';
    }
    ?>
</table>

<table class="table table-bordered">
    <caption>Most Profitable Authors</caption>
    <?php
    foreach ($mostProfitableAuthors as $author) {
        echo '<tr><td>' . $author . '</td></tr>';
    }
    ?>
</table>