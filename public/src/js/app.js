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

    $('.livres').on('mouseenter', function() {
        //je veux changer la bordure de taille

        //cela marche mais mauvaise pratique : on fait du css en js !
        //$(this).css('border-width', '10px');
        //$(this).css('background-color', 'lightblue');

        //là aussi, mauvaise pratique car possibilité de faire ça directement en css avec un hover
        //si vous avez le choix entre js ou css, choisissez du CSS
        $(this).addClass('bookHover');

        // pour tous les livres, sauf celui sur lequel on a passé la souris, on réduit la taille
        $('.livres').not($(this)).addClass('bookSmall');
    });

    $('.livres').on('mouseleave', function() {
        // remettre la bordure à la taille d'origine et la couleur de fond

        //$(this).css('border-width', '1px');
        //$(this).css('background-color', 'white');

        $(this).removeClass('bookHover');

        //on rétablit la taille initiale
        $('.livres').removeClass('bookSmall');
    });


    //exemple de code pour faire une inscription à une newsletter avec une modal
    // il faudra créer au préalable le bouton d’inscription à la newsletter ainsi que les classes utilisées
    $('.header-newsletter').on('click', function() {
        $('.popup-newsletter').addClass('popup-newsletter-show');
    });


    // au clic n'importe ou dans ma page
    $('body').on('click', function (e) {

        // e = evenement, donc c'est toutes les infos relatives au clic que je viens de faire
        // avec e.target je regarde si l'élement cliqué n'est pas le bouton de newsletter
        // ou la popup en elle même pour éviter de masquer ma popup si c'est le cas
        if (!$('.header-newsletter').is(e.target) && !$('.popup-newsletter').is(e.target)) {
            // dans ce cas là je masque ma popup
            $('.popup-newsletter').removeClass('popup-newsletter-show');
        }

    });



});




