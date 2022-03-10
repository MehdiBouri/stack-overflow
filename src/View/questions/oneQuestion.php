<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="col-md-8 m-auto">

    <h1 class="text-center pt-4"><?= $question->getTitle() ?></h1>

    <div class="d-flex justify-content-around">
        <p><?= $question->getCreatedAtFormat() ?></p>
    </div>

    <div class="line"></div>

    <div class="col-md-10 m-auto">
        <h5><?= $question->getContent() ?></h5>
    </div>


    <form action="" method="POST" class="formAjax" data-id="<?= $question->getId() ?>">
        <!--Textarea with icon prefix-->
        <div class="md-form amber-textarea active-amber-textarea">
            <label for="form22">Your Answer</label>
            <textarea id="form22" class="md-textarea form-control" rows="3"></textarea>
        </div>
        <div class="d-flex py-4">
                <?php if ($user) {
                    ?><button type="submit" class="btn btn-primary btnSubmit">Post Your Answer</button><?php
                }
                else {
                    ?><button type="submit" class="btn btn-primary btnSubmit" disabled>Login to Answer</button><?php
                }
                ?>
        </div>
    </form>
    

    <?php foreach($answers as $answer): ?>
        <div class="line"></div>

        <div class="col-md-10 m-auto">
            <?= ucfirst($users[$answer->getUserId()]->getNickname()).' - '.$answer->getCreatedAtFormat() ?>
            <p><?= $answer->getContent() ?></p>
        </div>
    <?php endforeach ?>


    <?php if ($pageTotal): ?>
        <nav aria-label="Page">
            <ul class="pagination">
                <li class="page-item"><a class="page-link"
                    href="?page=question&id=<?= $question->getId() ?>&p=<?= ($page - 1) ?>">Previous</a>
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
                    href="?page=question&id=<?= $question->getId() ?>&p=<?= ($page + 1) ?>">Next</a></li>
            </ul>
        </nav>
    <?php else: ?>
        <p>There is no answer yet.</p>
    <?php endif ?>
</div>

<?php

require_once './src/View/includes/footer.inc.php';

?>