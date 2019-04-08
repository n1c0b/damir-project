$(function(){

/* |||||||||||||||||||||||||||||||||||||||||||||| BOUTON "CREER MON COMPTE" |||||||||||||||||||||||||||||||||||||||||||||| */
//Lorsqu'un clique à lieu sur l'élément qui a l'ID "#btnAccount".
$('#btnAccount').click(function(){
	//On affiche le modal qui à l'ID "#popup_logsub".
	$('#popup_logsub').modal('toggle');
	//Et on dit à jQuery d'effectuer un clique sur l'onglet "#tabsub".
	$('#tabsub').click();
});


});