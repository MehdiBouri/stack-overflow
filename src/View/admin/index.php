<?php
require_once './src/View/includes/header.inc.php';
?>

<h1 class="text-center">Tableau de bord</h1>



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
                    
                    if ($question->getStatus() == 'moderated') {
                        ?> - <i class="fas fa-window-close"></i> Cette question est modérée et masquée<?php
                    }
                    
                    
                    if ($question->getStatus() == 'published') {
                        ?><a href="?page=questionClose&id=<?= $question->getId() ?>"><i class="fas fa-lock"></i> Clôturer</a><?php
                    }
                    elseif ($question->getStatus() == 'closed') {
                        ?><a href="?page=questionPublish&id=<?= $question->getId() ?>"><i class="fas fa-unlock"></i> Réouvrir</a><?php
                    }

                    if ($question->getStatus() != 'moderated') {
                        ?> <a href="?page=questionModerate&id=<?= $question->getId() ?>"><i class="fas fa-window-close ml-2"></i> Modérer</a><?php
                    }
                    elseif ($question->getStatus() == 'moderated') {
                        ?> <a href="?page=questionPublish&id=<?= $question->getId() ?>"><i class="fas fa-user ml-2"></i> Republier</a><?php
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