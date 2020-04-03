// pour tester le bon fonctionnement de Jquery
// console.log('Hello world');


//je sélectionne le document, j'exécute que si ma page est bien chargée avant
$(document).ready(function() {
    //je sélectionne avec jQuery les 2 premiers éléments qui ont la classe "livres" et je les montre
    $('.livres').slice(0, 2).show();
    // je sélectionne en jQuery mon bouton
    // j'utilise la fonction on('click') pour exécuter une fonction quand le bouton est cliqué
    $('.button-more').on('click', function() {
        // je sélectionne tous les livres et je les affiche
        //$('.livres').show();

        // OU

        //j'ajoute une condition : si le texte est égal à "Voir plus"
        //ici this fait référence au bouton car $('.button-more') = $(this)
        if ($(this).text() === 'Voir plus') {
            //alors je  remplace le texte en "Voir moins"
            $(this).text('Voir moins');
            //et si le bouton a pour texte "Voir plus" alors j'affiche tous les livres
            $('.livres').show();
            //sinon càd s'il est égal à "Voir moins", alors je le change en "Voir plus"
        } else {
            $(this).text('Voir plus');
            //et je sélectionne tous les livres pour les masquer (sauf les trois premiers grâce à slice)
            $('.livres').slice(3).hide();
        }

    });

});




