<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="col-md-8 m-auto">

    <h1 class="text-center pt-4">Ask a Question</h1>

    <form action="" method="POST">
        <div class="py-2">
            <input class="form-control" type="text" name="title" placeholder="Title">
        </div>

        <div class="md-form amber-textarea active-amber-textarea">
            <textarea placeholder="Your Question" id="content" class="md-textarea form-control" rows="3"></textarea>
        </div>

        <div class="py-2">
            <input class="form-control" type="text" name="technology" placeholder="Technology">
        </div>

        <div class="d-flex pb-4">
            <?php if ($user) {
                ?><button type="submit" class="btn btn-primary btnSubmit">Post Your Answer</button><?php
            }
            else {
                ?><button type="submit" class="btn btn-primary btnSubmit" disabled>Login to ask a Question</button><?php
            }
            ?>
        </div>
    </form>
</div>

<?php

require_once './src/View/includes/footer.inc.php';

?>