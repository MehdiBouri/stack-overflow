<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="col-md-8 m-auto">

    <h1 class="text-center pt-4">Ask a Question</h1>

    <form action="" method="POST">
        <div class="py-2">
            <input class="form-control" type="text" name="title" placeholder="Titre">
        </div>

        <div class="md-form amber-textarea active-amber-textarea">
            <textarea placeholder="Votre question..." id="content" name="content" class="md-textarea form-control" rows="3"></textarea>
        </div>

        <div class="py-2">
            <input class="form-control" type="text" name="technology" placeholder="Technologie">
        </div>

        <div>
            <?php
            if ($user) {
                ?><button type="submit" class="btn btn-primary">Envoyer la question</button><?php
            }
            else {
                ?>
                <button type="submit" class="btn mb-3" disabled>Envoyer la question</button>
                <div>
                    <a href="?page=login" class="btn btn-primary mb-4">Se connecter pour poser une question</a>
                </div>
                <?php
            }
            ?>
        </div>
    </form>
</div>

<?php

require_once './src/View/includes/footer.inc.php';

?>