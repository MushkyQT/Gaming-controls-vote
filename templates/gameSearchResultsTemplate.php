<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 d-flex justify-content-center">
            <h1>Search results:</h1>
        </div>
    </div>

    <div class="row">
        <?php
        foreach ($data as $searchResultsCard) {
            print templateGen("templates/searchGameCardTemplate.php", $searchResultsCard);
        }
        ?>
    </div>
</div>