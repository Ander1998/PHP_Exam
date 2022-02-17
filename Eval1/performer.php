<?php
    class Performer {

        private $name, $birthDate, $gendre, $age, $height;
        
        public function __construct ($name, $birthDate, $gendre, $age, $height){
            $this->name = $name;
            $this->birthDate = $birthDate;
            $this->gendre = $gendre;
            $this->age = $age;
            $this->height = $height;
        }

        public function getName(){
            return $this->name;
        }

        public function getBirthDate(){
            return $this->birthDate;
        }

        public function getGendre(){
            return $this->gendre;
        }

        public function getAge(){
            return $this->age;
        }

        public function getHeight(){
            return $this->height;
        }

        public function __toString(){
            return $this->getName() . ", " .$this->getBirthDate() . ", " . $this->getGendre() . ", " .  $this->getAge() . ", " . $this->getHeight() ;
        }

    }

    
    class DBManager {

        ////////////////////////////////
        // CAMBIAR ESTOS 3 PARÁMETROS //
        ////////////////////////////////

        private $servername = '127.0.0.1';
        private $username = 'root';
        private $schema = 'PHP_1';

        //////////////////////////////
        //////////////////////////////

        private $password = '';
        private $conn;

        function __construct(){

            // Create connection
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->schema);

            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            // echo "Connected successfully";
        }

        public function checkData($performer){
            $flag = 0;
            $year = strval($this->birthDate);
            $age = explode('-',$year, 2);
            $age = 2022 - strval($age);
            $height = ($this->height)/100;
            $errors = $this->errors;

           if(strlen($this->getName) < 2 or strlen($this->getName) > 15){
                $flag = 1;
           }    
           if(strval($year) < 01/01/1900) {
               $flag = 1;
           }
           if($this->gender != 'Male' or $this->gender != 'Female' or $this->gender != 'Other'){
                $flag = 1;
           }
           if(strval($age) < 1 or strval($age) > 110){
                $flag = 1;
           }
           if(strval($height) < 0.5 or strval($height) > 3){
               $flag = 1;
           }

           if($flag = 0){
                $performer = New Performer($this->name, $this->birthDate, $this->gendre, $age, $height);
                call_user_func('insertPerformer', $performer);
           } else {
                $errors += 1;
                if($errors > 3){
                    echo('What are you doing?');
                }
           } 
           
        }


        public function insertPerformer($performer) {
            $sql = "INSERT INTO performers (name, birth_date, gendre, age, height) VALUES (";
            $sql .= "'" . $performer->getName() . "',' " . $performer->getBirthDate() . "',' " . $performer->getGendre() . "', '" . 
                            $performer->getAge() . "', '" . $performer->getHeight() . "')";

            if ($this->conn->query($sql) === TRUE) {
                 echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }

        public function getPerformers(){
            
            $performerArray = array();

            if ($result = $this->conn->query("SELECT * FROM performers")) {
                // echo "Returned rows are: " . $result -> num_rows;

                foreach ($result as $row){
                    $name = $row['name'];
                    $birthDate = $row['birth_date'];
                    $gendre = $row['gendre'];
                    $age = $row['age'];
                    $height = $row['height'];

                    $performer = new Performer($name, $birthDate, $gendre, $age, $height);
                    $performerArray[] = $performer;
                }
                
                // Free result set
                $result -> free_result();
            }
            return $performerArray;
        }

        public function avgHeight($performerArray){
            $performerArray = array();
            $Height = 0;
            $countperformers = 0;
            $avgHeight = 0;

            foreach($performerArray as $performer)
            {
                if($performer['age'] > 25){
                    $Height += $performer['height'];
                    $countperformers += 1;
                }
            }
            $avgHeight = $Height / $countperformers;

            return $avgHeight;
        }

        public function tallerWamen($performerArray){
            $performerArray = array();
            $Height = 0;
            $countperfemales = 0;
            $avgHeight = 0;
            $taller = 0;
            $percentage = 0;

            foreach($performerArray as $performer)
            {
                if($performer['gender'] == 'Female'){
                    $Height += $performer['height'];
                    $countperfemales += 1;
                }
            }
            $avgHeight = $Height / $countperfemales;

            foreach($performerArray as $performer)
            {
                if($performer['height'] > $avgHeight){
                    $taller += 1;
                }
            }
            $percentage = $taller / count($performer);

            return $percentage;
        }
    }

?>
