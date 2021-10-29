<?php
class Guerrier extends Personnage
{
  public function recevoirDegats($degats)
  {
   if ($this->degats >= 0 && $this->degats <= 25){
    $this->atout = 4;
   } elseif($this->degats > 25 && $this->degats <= 50) {
    $this->atout = 3;
   } elseif($this->degats > 50 && $this->dégats <= 75) {
    $this->atout = 2;
   } elseif($this->degats > 75 && $this->dégats <= 90) {
    $this->atout = 1;
   } else {
    $this->atout = 0;
   }
   $this->degats += ($degats - $this->atout);
   if ($this->degats >= 100){
    return self::PERSONNAGE_TUE;
   }
   return self::PERSONNAGE_FRAPPE;
  }
}



