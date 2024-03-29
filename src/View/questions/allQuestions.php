<?php
require_once './src/View/includes/header.inc.php';
?>

<h1 class="text-center">Toutes les questions</h1>

<div class="text-center">
    <a href="?page=ask" class="btn btn-primary mb-3">Poser une question</a>
</div>

<hr/>

<div class="d-flex justify-content-center">
    <form action="" method="get" class="form-inline">
        <input class="form-control mr-sm-4" name="title" type="search" placeholder="Rechercher..."
            <?php if ($title) { echo 'value="'.$title.'"'; } ?> aria-label="Search">

        <label>Trier : </label>
        <select name="order" class="ml-1">
            <option value="DESC" <?php if ($order == 'DESC') { echo 'selected'; } ?>>Plus récent</option>
            <option value="ASC" <?php if ($order == 'ASC') { echo 'selected'; } ?>>Plus ancien</option>
        </select>
        <button type="submit" class="btn btn-success ml-2">Recherche</button>
    </form>
</div>



<?php foreach ($questions as $question) : ?>
    
    <div class="list-group">
        <a href="?page=question&id=<?= $question->getId() ?>">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $question->getTitle() ?></h5>
                <small class="text-muted">
                    <?php

                    echo ucfirst($users[$question->getUserId()]->getNickname()).' - '.
                    $question->getCreatedAtFormat();

                    if ($question->getStatus() == 'closed') {
                        ?> - <i class="fas fa-lock"></i> Cette question est clôturée<?php
                    }

                    if ($question->getTechnology()) {
                        ?>
                        <div>
                            <div class="btn btn-primary tag"><?= $question->getTechnology() ?></div>
                        </div>
                        <?php
                    }
                
                    
                    if ($question->getStatus() == 'published') {
                        ?><a href="?page=questionClose&id=<?= $question->getId() ?>"><i class="fas fa-lock"></i> Clôturer</a><?php
                    }
                    else {
                        ?><a href="?page=questionPublish&id=<?= $question->getId() ?>"><i class="fas fa-unlock"></i> Réouvrir</a><?php
                    }
                    ?>
                    
                </small>
            </div>
        </a>
    </div>
<?php endforeach ?>

<?php

require_once './src/View/includes/footer.inc.php';

?>