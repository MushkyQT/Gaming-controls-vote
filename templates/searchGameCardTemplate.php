<div class="col-4">
    <div class="card">
        <img class="card-img-top" src="<?php print $background_image ?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><?php print $name ?></h5>
            <p class="card-text"><?php print @$genres[0]["name"] ?></p>
            <form method="post">
                <button type="submit" class="btn btn-warning" name="gameRequested" value="<?php print $id ?>">Go</button>
            </form>
        </div>
    </div>
</div>