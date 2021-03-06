<?php
//Classe Magicien heritant de la classe abstraite Personnage
class Magicien extends Personnage
{
  // Nouvelle fonctionnalit√© de la sous classe Magicien
  public function lancerUnSort(Personnage $perso)
  {
    if ($this->degats >= 0 && $this->degats <= 25)
    {
      $this->atout = 4;
    }
    elseif ($this->degats > 25 && $this->degats <= 50)
    {
      $this->atout = 3;
    }
    elseif ($this->degats > 50 && $this->degats <= 75)
    {
      $this->atout = 2;
    }
    elseif ($this->degats > 75 && $this->degats <= 90)
    {
      $this->atout = 1;
    }
    else
    {
      $this->atout = 0;
    }
    
    if ($perso->id == $this->id)
    {
      return self::CEST_MOI;
    }
    
    if ($this->atout == 0)
    {
      return self::PAS_DE_MAGIE;
    }
    
    if ($this->estEndormi())
    {
      return self::PERSONNAGE_ENDORMI;
    }
    
    $perso->timeEndormi = time() + ($this->atout * 6) * 3600;
    
    return self::PERSONNAGE_ENSORCELE;
  }
}