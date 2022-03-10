<?php

require_once './src/View/includes/header.inc.php';

?>

<h1 class="text-center">Questions</h1>
<a href="?page=ask" class="btn btn-primary float-right askQuestion">Ask Question</a>
<?php foreach ($questions as $question) : ?>
    
    <div class="containerQuestion">

        <div class="left">
            <a href=""><?= ucfirst($users[$question->getUserId()]->getNickname()); ?></a>
            <p><?= $question->getCreatedAtFormat() ?></p>
        </div>

        <div class="right">
            <a href="?page=question&id=<?= $question->getId() ?>"><?= $question->getTitle() ?></a>

            <?php if ($question->getTechnology()): ?>
                <div class="infoFlex">
                    <a href="" class="btn btn-primary tag"><?= $question->getTechnology() ?></a>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="line"></div>
<?php endforeach ?>

<?php

require_once './src/View/includes/footer.inc.php';

?>