<?php

    class Connection{
        private $server;
        private $user;
        private $pass;
        private $database;
        private $port;
        private $link;

        function __construct(){
            $this->setConnect();
            $this->connect();
        }

        private function setConnect(){
            require_once 'conf.php';

            $this->server=$server;
            $this->user=$user;
            $this->pass=$pass;
            $this->database=$database;
            $this->port=$port;
        }

        private function connect(){
            //(server, user, pass, database) --> Es el orden a la hora de conectar la base de datos
            $this->link=mysqli_connect($this->server,$this->user,$this->pass,$this->database);

            /* if (!$this->link) {
                echo mysqli_error($this->link);
            } else {
                echo "Conexión Exitosa";
            } */
        }
        public function getConnect(){
            return $this->link;
        }

        public function close(){
            mysqli_close($this->link);
        }

        
    }

?>