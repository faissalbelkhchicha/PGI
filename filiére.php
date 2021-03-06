<?php
require_once 'inc/users_data.php';

if (empty(Session::getInstance()->read('id'))) {
  Session::getInstance()->setFlash('danger','Vous devez etre connecté');
  App::redirect('login.php');
}
if (!empty($_POST)) {
 if (!empty($_POST['filièreENS']) && $_POST['filièreENS'] != 'Les filières' ){
  $filièreENS = $_POST['filièreENS'];
  $candidature = 'Pré-inscrit';
  $dure =  date("d/m/Y");
  $db->query("UPDATE users SET filièreENS = ?,candidature = ?,date_candidature = ? WHERE id = ?",[$filièreENS,
  $candidature,
  $dure,$_SESSION['id']]);
  Session::getInstance()->setFlash('success','L\'Inscription a l\'ENS MARRAKECH est terminée avec succès vous pouvez maintenant télécharger le reçu d\'inscription');
  App::redirect('profil.php');
}
else{
  $errors[]="le champs doit être remplis";
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <link rel="shortcut icon" href="style/Icon/pgicon.ico">
  <meta charset="utf-8">
  <title>Page de profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/css_style/styleprofil.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <style type="text/css">
    li img {
      width: 40px;
      height: 40px;
      border-radius: 50% ;

    }
  </style>
</head>
<body>
  <nav>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
      <i class="fas fa-bars"></i>
    </label>
    <label class="logo">Espace etudiant</label>
    <ul>
      <li><img src="<?php echo $PHOTO->file_url1; ?>"></li>
      <li style="color: white;"><?php echo $NOM->nom_fr.' '.$NOM->prénom_fr;   ?></li>
      <li><a href="profil.php">PRINCIPALE</a></li>
      <li><a href="candidature.php">Mes candidatures</a></li>

      <li><a href="inc/logout.php">Quitter</a></li>
    </ul>
  </nav>


  <?php
  if (session_status() == PHP_SESSION_NONE ) {

    session_start();
  }
  ?>
  <?php if (isset($_SESSION['flash'])): ?>
   <?php foreach ($_SESSION['flash'] as $type => $message): ?>

     <div class="alert alert-<?=$type; ?>"><li><?=$message;?></li></div>

   <?php endforeach; ?>
   <?php unset($_SESSION['flash']); ?>
 <?php endif;?>






 <?php  if (!empty($errors)):?>

  <div class="alert alert-danger">
    <p>vous n'avez pas rempli le formulaire correctement</p>

    <?php foreach ($errors as $error): ?>
      <ul>

        <li><?= $error; ?></li>

      <?php endforeach; ?>

    </ul>

  <?php endif; ?>


  <form action="" method="POST">
    <div class="container"
    style="display: grid;
    grid-template-columns: repeat(2,auto);
    grid-gap: 4em;
    margin-top:2em;">
    <h3>Vous pouvez choisir les filiéres disponibles:</h3>
    <br>

    <main>
      <div class="card" style="
      border-top-width: 0px;
      width: 450px;
      height: 300px;
      margin-top: 0px;
      background: white;
      padding: 1.5em;
      border-radius: .4em;
      box-shadow:
      0 20px 30px 0 rgba(0,0,0,.1),
      0 4px  4px 0 rgba(0,0,0,.15);">
      <img src="style/img/logoens.jpg">
      <strong>ENS Marrakech</strong>
      <select class="browser-default custom-select" name="filièreENS">
       <option selected>Les filières</option>
       <option value="CLE-SVT">CLE-ENSEIGNEMENT SECONDAIRE SCIENCES DE LA VIE ET DE LA TERRE</option>
       <option value="CLE-INFO">CLE-ENSEIGNEMENT SECONDAIRE INFORMATIQUE</option>
       <option value="CLE-MATHS">CLE-ENSEIGNEMENT SECONDAIRE MATHS</option>
       <option value="CLE-PC">CLE-SECONDAIRE SCIENCES PHYSIQUES ET CHIMIQUES</option>
       <option value="CLE-PRIMAIRE">CLE-ENSEIGNEMENT PRIMAIRE</option>
       <option value="DUT-INFO">DUT-INGÉNIERIE INFORMATIQUE</option>

     </select>
     <input class="btn btn-info" type="submit" value="Confirmer" >
   </div>
 </main>


</div>
</form>
</body>
</html>
