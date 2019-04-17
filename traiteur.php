<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FUNCTIONS ET HEADER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php
    //Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
	$page = 'traiteur';
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
	require_once 'Ressources/php/inc/functions.php';
    //Initialisation de la fonction "reconnect_cookie()" pour que l'utilisateur reste connecté si il a coché la case "Rester connecté" lors de sa connexion.
	reconnect_cookie();
    //Appel du header.php.
	require_once 'Ressources/php/inc/header.php';
?>

<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION IMAGES |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="images">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <div class="openCard" id="animationsIMG">
                    <h2 id="h2Ani">Animations culinaire</h2>
                </div>
            </div>
            <div class="col-md">
                <div class="openCard" id="forfaitIMG">
                <h2 id="h2For">Forfait Mobilier et salle</h2>
                </div>
            </div>
        </div>
    </div>
<section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION ARTICLES |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="article">
    <div class="container-fluid">
        <div id="animation">
            <h1>Animations culinaire traiteur, avec l’AFPA de Nice</h1>
            <h3>Nos Animations Culinaires et Forfaits (à partir de 35 personnes)</h3>
            <br>
            <h4>Les Chauds</h4>
            <p>Une farandole d'ateliers plancha du classique au plus original en mettant toujours 
            l'accent sur le raffinement, une animation d'inspiration française qui ravie petits et 
            grands enfants, des créations snacking dans l'esprit "Guinguette" des food-trucks...</p>

        <h4>Les Froids</h4>
            <p>Notre plus grande fierté, notre déclinaison de "Bar salés", tous incroyablement 
                inédits, raffinés et séduisants dont nous tairons les détails car certes inégalables 
                mais beaucoup trop copiés...(chuttt...c'est un secret entre vous et nous :-))</p>

            <h4>Les Sucrés</h4>
            <p>Un florilège de belle tables, en passant par l'esprit "Guinguette", centres des 
                formation "Classique" ou encore "Renaissance"...satisfaire votre gourmandise 
                est notre devise !</p>

            <h4>Les Boissons</h4>
            <p>Ici encore nous privilégions l’originalité et la créativité sans laisser pour 
                compte les valeurs sûre qui assurerons la satisfaction de tous. 
            Bars à rafraichissements, bars à cocktails, bar "L'original", nos boissons 
            softs (mais pas n'importe quel softs...) 
            Votre curiosité est mise à rude épreuve :-) ?</p>

            <h5>Beaucoup plus de détails vous seront communiqués suite à un entretien personnalisé, 
                mais en attendant...</h5>

            <h3>Laissez-vous tenter par nos forfaits tout compris</h3>

            <h4>Vaisselle</h4>
            <p>Verre apéritif, verre à eau, verre à vin, flûte, tasse à café avec sous-tasse, 
            couteau et fourchette de table, cuillère à dessert, cuillère moka, assiette et 
            assiette à dessert</p>

            <h4>Nappage et Serviette</h4>
            <p>lieu de votre réception la veille au plus tard / Reprise le lundi du matériel 
            "sale" et rangé tel</p>
            <p>9,90 € / Pers</p>
        </div>

        <div id="forfait">
            <h2>Forfait Mobilier et salle</h2>

            <p>Nous pouvons mettre à votre disposition tout le matériel nécessaire à votre 
            réception (chauffages, éclairage…), un devis gratuit sera établi sur 
            simple demande.</p>

            <h4>Service</h4>
            <p>La vaisselle de présentation, l'installation et la mise en scène décorative 
            des bars et buffets, le pain individuel, sel, poivre, café Nespresso et 
            sucre individuels.
            <br>
            Compris uniquement sur prestation complète à partir de 35 Pers </p>

            <h4>Service à Table</h4>
            <p>Nos serveurs sont au nombre d'un serveur pour 25 pers, orchestré 
            par un maître d'hôtel</p>

            <h4>Les Enfants</h4>
            <p>La prestation est offerte pour les moins de 6 ans, un menu enfant 
            est proposé pour les 6 à 11 ans inclus, puis, au delà de 12 ans, 
            nous les considérons comme des "adultes".</p>

            <h4>Menu Enfant :</h4>
            <p>Plat + Dessert = 20 €
            <br>
            Apéritif + Plat + Dessert = 25 €</p>

            <h5>N'hésitez pas à nous contacter afin que nous puissions vous proposer 
            un devis en adéquation avec le nombre d'enfants présents lors de 
            votre événement.</h5>
        </div>
    </div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' //Appel du fichier "footer.php"?>