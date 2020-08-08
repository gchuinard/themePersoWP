<?php
//La fonction "get_comments_number" nous renvoit le nombre de commentaire sous forme de string, on utilise donc la fonction
//'absint' pour convertir la string en int.
$nbr_comments = absint(get_comments_number());
?>

<?php if ($nbr_comments > 0) : ?>
    <h2><?= $nbr_comments ?> Commentaire<?= $count > 1 ? 's' : '' ?></h2>
<?php else : ?>
    <h2>Laisser un commentaire</h2>
<?php endif ?>



<?php 
//Si les commentaires sont acceptés, alors on affiche le formulaire d'ajout de commentaire.
if (comments_open()) : ?>
<?php comment_form(); ?>
<?php endif ?>
<?php wp_list_comments(); ?>