<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=Formulaire_PHP;charset=utf8', 'psaulay', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

//add variables
if(isset($_POST['valider'])){
    $contact_type=htmlspecialchars($_POST['subscribe']);
    $genre=htmlspecialchars($_POST['sexe']);
    $motif=htmlspecialchars($_POST['motif']);
    $prenom=htmlspecialchars($_POST['prenom']);
    $nom=htmlspecialchars($_POST['nom']);
    $objet=htmlspecialchars($_POST['objet']);
    $msg=htmlspecialchars($_POST['message']);
    $error= false;

    //Check if the input objet is empty 
    if (empty($genre)) {
        $error=true;
        $error_genre = 'Vous n\'avez pas indiqué votre sexe. <BR>';
    }
    if (empty($objet)) {
        $error=true;
        $error_object = 'Vous n\'avez pas indiqué l\'objet. <BR>';
    }
    //Check if the input objet is > 51
    if (strlen($objet) > 51){
        $error=true;
        $error_objet ='Votre objet ne peut pas dépasser 50 caractères';
    }
    //Check if the input prenom is empty
    if (empty($prenom)) {
        $error=true;
        $error_prenom = 'Vous n\'avez pas indiqué votre prénom. <BR>';
    }
    //Check if the input prenom is > 51
    if (strlen($prenom) > 51){
        $error=true;
        $error_prenom ='Votre objet ne peut pas dépasser 50 caractères';
    }
    //Check if the input nom is empty
    if (empty($nom)) {
        $error=true;
        $error_nom = 'Vous n\'avez pas indiqué votre nom <BR>';
    }
    //Check if the input nom is > 51
    if (strlen($nom) > 51){
        $error=true;
        $error_nom ='Votre nom ne peut pas dépasser 50 caractères';
    }
    //Check if the input message is empty
    if (empty($msg)) {
        $error=true;
        $error_message = 'Vous avez oublié de rédiger un message ! <BR>';
    }
    //Check if the input message is > 501
    if (strlen($objet) > 501){
        $error=true;
        $error_message ='Votre message ne doit pas dépasser 500 caractères';
    }
    if ($error== false) {
        $bdd->exec("INSERT INTO form_contact(nom, prenom, sujet, msg, genre, motif, contact_type) VALUES('$nom', '$prenom', '$objet', '$msg', '$genre', '$motif', '$contact_type')");
        $confirm_message ='Message envoyé !';
    }
}
if(isset($_POST['annuler'])){
    $msg= $_POST['message'];
    $reponse = $bdd->prepare("DELETE FROM form_contact WHERE msg='$msg'");
    $reponse->execute();
    $error_message ='Message supprimé !';
}

?>

<html>
    <head>
    <title>Formulaire PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Formulaire PHP</h1>
        <form name="formulaire" method="post" action="index.php">
            <div>
                <input type="checkbox" id="subscribe" name="subscribe" value="mail">
                <label for="subscribe1">Je souhaite être recontacté par mail</label><br>
                <input type="checkbox" id="subscribe" name="subscribe" value="tel">
                <label for="subscribe2">Je souhaite être recontacté par téléphone</label>
            </div>
            <div class="radio col-12" id="sexe" required >
                <p class="nocss">Genre:</p>
                <input type="radio" id="sexe1" name="sexe" value="FEMME">
                <label for="sexe1">Mme</label>
                <input type="radio" id="sexe2" name="sexe" value="HOMME">
                <label for="sexe2">M.</label>
                <span id='missSelectSexe'></span><br>
            </div>
            Motif du contact :<br>
            <select name="motif" required value="<?php if (isset($_POST['motif'])){echo $_POST['motif'];} ?>">
                <option name"motif" value="Pro">Professionel</option> 
                <option name"motif" value="Perso" selected>Personnel</option>
            </select>
            <p><?php if(isset($error_genre)) echo $error_genre; ?></p>
            <p class="nocss">Nom :</p><input class="form-control col-6" type="text" name="nom" value="<?php if (isset($_POST['nom'])){echo $_POST['nom'];} ?>"/>
            <p style="color:red;"><?php if(isset($error_nom)) echo $error_nom; ?></p>
            <p class="nocss">Prénom :</p><input class="form-control col-6" type="text" name="prenom" value="<?php if (isset($_POST['prenom'])){echo $_POST['prenom'];} ?>"/>
            <p style="color:red;"><?php if(isset($error_prenom)) echo $error_prenom; ?></p>
            <p class="nocss">Objet du message :</p> <input class="form-control col-6" type="text" name="objet" value="<?php if (isset($_POST['objet'])){echo $_POST['objet'];} ?>"/>
            <p style="color:red;"><?php if(isset($error_object)) echo $error_object; ?></p>
            <p class="nocss">Message : </p><input class="form-control col-10" type="text" id="message"name="message" value="<?php if (isset($_POST['message'])){echo $_POST['message'];} ?>"/> </input><br/>
            <p style="color:red;"><?php if(isset($error_message)) echo $error_message; ?></p>
            <p style="color:green; font-size:30px;"><?php if(isset($confirm_message)) echo $confirm_message; ?></p>
            <input class="btn" id="submit" type="submit" name="valider" value="ENVOYER LE MESSAGE"/><br>
            <input class="btn" id="submit2"type="submit" name="annuler" value="ANNULER L'ENVOI DU MESSAGE"/>
        </form>
    </body>
</html>