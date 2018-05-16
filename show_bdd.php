<!DOCTYPE html>
<html>
    <head>
    <title>Message du formulaire PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    </head>
    <body>
        <?php
        try
        {
        $bdd = new PDO('mysql:host=localhost;dbname=Formulaire_PHP;charset=utf8', 'psaulay', '');
        }
        catch (Exception $e)
        {
        die('Erreur : ' . $e->getMessage());
        }


        echo '<h1>Vos messages</h1>';
        $reponse = $bdd->prepare('SELECT * FROM form_contact WHERE genre LIKE ?');
        $reponse->execute(['%M%']);
        //var_dump ($reponse);
        $results = $reponse->fetchAll();

        echo '<form action = "show_bdd.php" method = "post"><table class="table">';
        echo '
        <thead class="thead-dark">
            <tr>
                <th>nom</th>
                <th>prenom</th>
                <th>sujet</th>
                <th>msg</th>
                <th>genre</th>
                <th>motif</th>
                <th>type de contact</th>
                <th>supprimer</th>
            </tr>
        </thead>';
        foreach ($results as $result){
            echo '<tr><td>'.$result['nom'].'</td>';
            echo '<td>'.$result['prenom'].'</td>';
            echo '<td>'.$result['sujet'].'</td>';
            echo '<td>'.$result['msg'].'</td>';
            echo '<td>'.$result['genre'].'</td>';
            echo '<td>'.$result['motif'].'</td>';
            echo '<td>'.$result['contact_type'].'</td>';
            echo '<input name="message" type="hidden" value="'.$result['msg'].' "</input>';
            echo '<td><input class="btn btn-danger" id="submit" type="submit" name="submit" value="X"/></td></tr>';
        }
        echo '</table></form>';


        if(isset($_POST['submit'])){
            $msg= $_POST['message'];
            $test = $bdd->prepare("DELETE FROM form_contact WHERE msg='$msg'");
            $test->execute();
            header('Refresh:0');
        }
        ?>
    </body>
</html>