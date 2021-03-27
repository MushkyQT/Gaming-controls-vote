<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 d-flex justify-content-center">
            <h1>Popular games:</h1>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($data as $popularGamesCard) {
            print templateGen("templates/popularGamesCardTemplate.php", $popularGamesCard);
        }
        ?>
    </div>
</div>