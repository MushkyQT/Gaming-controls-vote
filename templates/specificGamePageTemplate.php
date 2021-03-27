<div class="container-fluid fullHeightMinusNav">
    <div class="row h-100">
        <div class="col-2 banner leftBanner" style="background-image: url(<?php print $background_image ?>);"></div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <h1><?php print $name ?></h1>
                    <p>Metacritic Score: <?php print $metacritic ?> | Released: <?php print $released ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-6 bg-warning">
                    <div class="col">
                        <div class="card m-0">
                            <img class="card-img-top" src="<?php print $background_image_additional ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php print $name ?></h5>
                                <span class="card-text"><?php echo $description ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 bg-warning d-flex">
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <button class="btn btn-primary gameVoteBtn" name="gameVote" value="keyboard">Vote for Keyboard</button>
                        <p>4</p>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <button class="btn btn-primary gameVoteBtn" name="gameVote" value="controller">Vote for Controller</button>
                        <p>18</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 banner rightBanner" style="background-image: url(<?php print $background_image ?>);"></div>
    </div>
</div>