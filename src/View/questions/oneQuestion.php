<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="col-md-8 m-auto">

    <h1 class="text-center pt-4"><?= $question->getTitle() ?></h1>

    <div class="d-flex justify-content-around">
        <p><?= '<b>'.ucfirst($users[$question->getUserId()]->getNickname()) . '</b> - ' . $question->getCreatedAtFormat() ?></p>
    </div>

    <div class="col-md-10 m-auto">
        <h5><?= $question->getContent() ?></h5>
    </div>
    

    <?php

    // Affichage du formulaire si la question n'est pas clôturée
    if ($question->getStatus() == 'published') {
        ?>
        <form action="?page=answer&questionId=<?= $question->getId() ?>" method="POST" class="mt-5">
            <!--Textarea with icon prefix-->
            <div class="md-form amber-textarea active-amber-textarea">
                <label for="form22">Votre réponse</label>
                <textarea id="form22" name="answerContent" class="md-textarea form-control" rows="3"></textarea>
            </div>
            <div class="d-flex py-4">
                    <?php if ($user) {
                        ?><button type="submit" class="btn btn-primary btnSubmit">Envoyer la réponse</button><?php
                    }
                    else {
                        ?><button type="submit" class="btn btn-primary btnSubmit" disabled>Se connecter pour répondre</button><?php
                    }
                    ?>
            </div>
        </form>
        <?php
    }
    else {
        ?>
        <div class="alert alert-warning mt-4">Cette question est clôturée</div>
        <?php
    }
    
    

    foreach($answers as $answer): ?>
        <div class="col-md-10 m-auto">
            <b><?= ucfirst($users[$answer->getUserId()]->getNickname()) ?></b>
            <small><?= ' - '.$answer->getCreatedAtFormat() ?></small>
            <p><?= $answer->getContent() ?></p>
        </div>
    <?php endforeach ?>


    <?php if ($pageTotal): ?>
        <nav aria-label="Page">
            <ul class="pagination">
                <li class="page-item"><a class="page-link"
                    href="?page=question&id=<?= $question->getId() ?>&p=<?= ($page - 1) ?>">Précédente</a>
                </li>

                <?php for($i = 0; $i < $pageTotal; $i++): ?>
                    <?php if ($page == ($i + 1)) {
                        $active = 'active';
                    }
                    else {
                        $active = '';
                    }

                    ?>
                    <li class="page-item <?= $active ?>"><a class="page-link"
                        href="?page=question&id=<?= $question->getId() ?>&p=<?= ($i + 1) ?>"><?= ($i + 1) ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item"><a class="page-link"
                    href="?page=question&id=<?= $question->getId() ?>&p=<?= ($page + 1) ?>">Suivante</a></li>
            </ul>
        </nav>
    <?php else: ?>
        <p>Il n'y a pas encore de réponses.</p>
    <?php endif ?>
</div>

<?php

require_once './src/View/includes/footer.inc.php';

?>