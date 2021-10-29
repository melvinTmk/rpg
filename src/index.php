<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf8'/>
        <title>COMBAAAT</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <?php require_once("controller.php");
        if(isset($perso))
            {
        ?>
            <br>
                <h1>Mon Personnage</h1>
                <div style="position: relative;
                            z-index: 1;
                            background: #FFFFFF;
                            max-width: 360px;
                            margin: 0 auto 100px;
                            padding: 35px;
                            text-align: center;
                            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);">
                    <p style="font-size:1.5rem; font-weight:bold">
                        <!-- Type : <?=ucfirst($perso->type())?><br/> -->
                        Nom : <?= $perso->nom() ?> <br/>
                        Dégats : <?= $perso->degats() ?>
                        <?php
                      switch($perso->type())
                      {
                          case 'magicien' :
                            echo 'magie : ';
                            break;
                            case 'guerrier' :
                                echo 'Protection : ';
                                break;
                            }
                            echo $perso->atout();
                            ?>
                    </p> 
                    <?php if($perso->type() == "magicien")
                            {
                                echo "<img class='img-perso' src='./assets/sorcier.png'>";
                            }
                            else
                            {
                                echo "<img class='img-perso' src='./assets/guerrier.png'>";
                            }
                    ?>
                </div>
                    <a class="colorWhite" href='index.php?deconnexion=1'>Déconnexion</a>
                    <h2> Qui frapper ? </h2>
                    <?php
                    $persos = $manager->getList($perso->nom());
                    if (empty($persos))
                    {
                        echo 'Personne à frapper !';
                    } else
                    {
                      if ($perso->estEndormi())
                      {
                        echo 'Un magicien vous a endormi ! Vous allez vous reveiller dans ', $perso->reveil(),'.';
                      } else
                      {
                      ?>
                      <div style="position: relative;
                            z-index: 1;
                            background: #FFFFFF;
                            max-width: 560px;
                            margin: 0 auto 100px;
                            padding: 35px;
                            text-align: center;
                            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);">
                            
                        <?php
                            foreach($persos as $pers)
                            {
                              echo '<a  href="?frapper='.$pers->id().'">'.htmlspecialchars($pers->nom()).'</a>',' (dégats : ', $pers->degats(),' | type : ', $pers->type(), ')';
                              if($perso->type() =='magicien')
                              {
                              echo '| <a href="?ensorceler=', $pers->id(),'">', 'lancer un sort ,</a>';
                              }
                              echo '<br/>';
                            }
                            }
                            }
                        ?>   
                        </div>
            <?php
            }
            else {
            ?>
      <h1>FANTASY FIGHT</h1>
            <div class="form-container">
                <form class="form" method='post'>
                    <label for='nom'><input type='text' placeholder="Choisissez un nom" name='nom' maxlength=50 /></label>
                        <input class="btn-use" type='submit' value='utiliser' name='utiliser'/></p>
                    
                    <div class="container-checkbox">
                        <div class="checkbox-item">
                            <img class="img-perso" src="./assets/sorcier.png" alt="">
                            <input type="checkbox" value='magicien' name ="type"></input>
                        </div>
                            <div class="checkbox-item">
                                <img class="img-perso" src="./assets/guerrier.png" alt="">
                            <input type="checkbox" value='guerrier' name ="type"></input>
                        </div>
                    </div>
                    <input class="btn-create" type='submit' value='creer' name='creer' />
                </form  
            </div>
            <?php } ?>
    </body>
</html>


