<?php
//Autoload 

spl_autoload_register(function ($className){
    require  $className . '.php';
});


try {
    $db = new PDOConfig('rpg','root','example');
    $manager = new Manager($db);
}
catch (Exception $e){
    echo $e->getMessage();
}


if (isset($_POST['creer']) && isset($_POST['nom']))
{
    // création d'un personnage 
   switch($_POST['type'])
   {
    case 'guerrier' : { $perso = new Guerrier(['nom' => $_POST['nom']]); break; }
    case 'magicien' : { $perso = new Magicien(['nom' => $_POST['nom']]); break; }
    default : { null; $message = 'le type du personnage est invalide'; break; }
   }

    if (!$perso->nomValide()) {
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    }
    elseif (!$manager->exists($_POST['nom']))
    {
        $manager->add($perso);
        $_SESSION['perso'] = $perso;
        $message = 'Personnage créé';
    }
    else
    {
        $message = 'Le nom du personnage est déjà pris';
        unset($perso);
    }
}
elseif (isset($_POST['utiliser']) && isset($_POST['nom']))
{
    // utilsiation d'un personnage 
    if ($manager->exists($_POST['nom']))
    {
        $perso = $manager->get($_POST['nom']);
        $_SESSION['perso'] = $perso;
        $message = 'Personnage bien sélectionné';
    }
    else
    {
       $message = 'Ce personnage n\'existe pas !';
       unset($perso);
    }
} elseif (isset($_GET['frapper']))
{
    if(!isset($perso))
    {
        $message = 'Pas de personnage à utiliser';
    }
    else
    {
     if(!$manager->exists((int) $_GET['frapper']))
     {
        $message = 'Le personnage que voulez frapper n\'existe pas';
     } else
     {

     $persoAFrapper = $manager->get( (int) $_GET['frapper']);
     echo $perso->nom()." ".$perso->id();
     if($manager->exists($persoAFrapper->nom())){
     $retour = $perso->frapper($persoAFrapper);
   
     switch ($retour)
     {
        case Personnage::CEST_MOI :
            $message = 'Impossible de se frapper';
            break;
        case Personnage::PERSONNAGE_FRAPPE :
            $message = $persoAFrapper->nom().' a été bien frappé';
            $manager->update($persoAFrapper);
            $manager->update($perso);

            break;
        case Personnage::PERSONNAGE_TUE :
            $message = $persoAFrapper->nom().' est tué';
            $manager->delete($persoAFrapper);
            break;
        case Personnage::PERSONNAGE_ENDORMI :
            $message = $persoAFrapper->nom().' est endormi';
            break;
     }
     }
     else
     {
        $message = 'Personnage à frapper inexistant';
     }
     }
    }
} elseif (isset($_GET['ensorceler']))
{
    if ($perso->type() != 'magicien')
    {
        $message = 'Seuls les magiciens peuvent ensorceler des personnages !';
    }
    else
    {
        if (!$manager->exists((int) $_GET['ensorceler']))
        {
            $message = 'Le personnage que vous voulez frapper n\'existe pas ';
        }
        else
        {
            $persoAEnsorceler = $manager->get((int) $_GET['ensorceler']);
            $retour = $perso->lancerUnSort($persoAEnsorceler);
            
            switch($retour)
            {
                case Personnage::CEST_MOI :
                    $message = 'Mais... pourquoi voulez-vous vous ensorceler ???';
                    break;
                case Personnage::PERSONNAGE_ENSORCELE :
                    $message = 'Le personnage a bien été ensorcelé !';
                    $manager->update($perso);
                    $manager->update($persoAEnsorceler);
                    break;
                case Personnage::PAS_DE_MAGIE :
                    $message = 'Vous n\'avez pas de magie ! ;)';
                    break;
                case Personnage::PERSONNAGE_ENDROMI :
                    $message = 'Vous êtes endormi, vous ne pouvez pas lancer de sort ! :)';
                    break;
            }
        }
    }
}

