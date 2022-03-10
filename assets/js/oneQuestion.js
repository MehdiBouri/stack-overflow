$(document).ready(function () {

    // function pour ajouter un commentaire
    function addNewComment(event) {
        
        event.preventDefault();

        const form = $('.formAjax')
        const answerContent = $('textarea').val().trim();
        const questionId = $('.formAjax').data('id');
    
        if (answerContent == "") {
            return false;
        }

        // j'ajoute ma carte à la base de donnée
        $.ajax({
            method: "POST",
            url: "?page=answer",
            data: { answerContent: answerContent, questionId: questionId}
        })
        // si la requête a fonctionnée, j'ajoute le commentaire au dom
        .done(function (response) {
            // je créé une card
            const newAnswer = `
                <div class="line"></div>

                <div class="col-md-10 m-auto">
                    <h5>Ma réponse</h5>
                    <p>${answerContent}</p>
                </div>
                `;

            // j'ajoute le commentaire
            $(form).after(newAnswer);
            // je vide l'input
            $(form).val('');
        });
    }

    // event pour ajouter une cards
    $('.formAjax .btnSubmit').click(addNewComment);

});   