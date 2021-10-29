<?php 
class PDOConfig extends PDO
{ 
    protected $engine; 
    protected $host; 
    protected $database; 
    protected $user; 
    protected $pass;
    
    public function __construct($db,$user,$pw)
    { 
        if(isset($db) && isset($user)){
        $this->engine = 'mysql'; 
        $this->host = 'db'; 
        $this->database = $db;
        $this->user = $user; 
        $this->pass = $pw; 
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING) );
        } else {
            echo "Erreur de paramètres";
        }
    } 
} 
?>