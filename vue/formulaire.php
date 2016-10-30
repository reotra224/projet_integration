<?php

	require_once('vue/entete.html');
	require_once('vue/menu.html');
	require_once('modele/relation.php');
?>
<h2>FORMULAIRE SIGNATURES</h2>
<article style="margin-left:70px;">
	<form action="livre_d_or.php" method="POST" enctype="multipart/form-data" >
		<label class="lbl" for="civ">Civilité :</label>
			<input name="civilite" type="radio" value="Mr" id="civ"/> 			<label class="radio">Monsieur</label>
			<input name="civilite" type="radio" value="Mme" id="civ" checked />	<label class="radio">Madame</label>
			<input name="civilite" type="radio" value="Mlle" id="civ" />		<label class="radio">Mademoiselle</label>
		<label class="lbl" for="nom">Nom Complet :</label>
			<input name="nom_complet" type="text" id="nom" autofocus/>
		<label class="lbl" for="email">Email :</label>
			<input name="email" type="email" id="email" /><br/><br/>
		<label class="lbl" for="pseudo">Pseudo :</label>
			<input name="pseudo" type="text" id="pseudo" />
		<label class="lbl" for="anonymat">Anonymat :</label>
			<input name="anonymat" type="radio" value="1" id="anonymat" checked/>	<label class="radio">OUI</label>
			<input name="anonymat" type="radio" value="2" id="anonymat" />			<label class="radio">NON</label>
		<label class="lbl" for="relation">Relation :</label><br/>
			<?php
				// On fait appel à la méthode liste_choix de la classe Relation pour récupérer les données de la table relation
				$liste = Relation::liste_choix();

				/*Si la methode liste_choix renvoie des données alors on utilise une boucle pour créer des checkboxs et des labels
				 pour chaque valeur retournée par la methode liste_choix en nous servant du getter nom_relation définit dans la
				 classe Relation pour retourner la valeur de la propriété qui est privée.
				*/
				if(!empty($liste)){
					foreach ($liste as $v) { ?>
						<input name="relation[]" type="checkbox" value = <?php echo $v->nom_relation(); ?> id="relation" />
						<label class="checkbox"><?php echo $v->nom_relation(); ?></label><br/>
			<?php }	}?>

		<label class="lbl" for="photo" >Photo :</label>
			<input name="photo" type="file" id="photo" /><br/><br/>
		<label class="lbl" for="message" >Message :</label><br/>
			<textarea rows=10 cols=50 name="message" id="message" ></textarea><br/><br/>
		<input type="submit" value="ENVOYER" /><br/><br/>
	</form>
</article>
<?php
	require_once('vue/pied.html');
?>
