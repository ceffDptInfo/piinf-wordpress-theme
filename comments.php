<?php
/// Crée une variable recevant le nombre de commentaires
$count = get_comments_number();
$append = "";
if ($count != 1) {
    $append = "s";
}
/// Affiche le nombre de commentaires, si il est égal à 0 ou > 1, il prend un s
echo get_comments_number() . " Commentaire" . $append;

/// Cette fonction liste les commentaires
wp_list_comments(
    array(
        'avatar_size' => 120,
        'style' => 'div',
    )
);

/// Ceci affiche le formulaire de commentaires si les commentaires sont autorisés sur cet article
if (comments_open()) {
    comment_form(
        array(
            'class_form' => '',
            'title_reply_before' => '<h2 id="idsivousvoulez">Répondre</h2>'
        )
    );
}
