<html>
<head>

<?php 
/// AÑADE EL CODIGO NECESARIO PARA PODER ACCEDER AL CONTENIDO DEL FICHERO performer.php
include 'performer.php';

function checkData($performer){
    $db = new DBManager();
    $flag = 0;
    $year = strval(input('birthDate'));
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
        $db->insertPerformer($performer);
   } else {
        $errors += 1;
        if($errors > 3){
            echo('What are you doing?');
        }
   } 
   
}
function avgHeight($performerArray){
    $db = new DBManager();
    $performerArray = $db->getPerformers();
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

function tallerWamen($performerArray){
    $db = new DBManager();
    $performerArray = $db->getPerformers();
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
?>

</head>


<body>


<?php

    /*
    // EJEMPLO de uso:
    
    $db = new DBManager();

    $performer = new Performer("unai", date("Y-m-d", strtotime("2000-03-01")), "male", 21, 1.81);

    $db->insertPerformer($performer);

    $performerArray = $db->getPerformers();

    echo "<ul>";
    foreach ($performerArray as $perf){
        echo "<li>$perf</li>";
    }
    echo "<ul>";
    */
    

?>
<form method="post" action=checkData()>
        <label for="name">Name</label>
        <input type="text" id="name" name=""><br>
        <label for="birthDate">Date of birth</label>
        <input type="date" id="birthDate"><br>
        <label for="Gender">Gender</label>
        <select id="gender" name="gender"> 
            <option value="Male" selected>Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>
        <label for="Height">Height (in cms)</label>
        <input type="number" id="Height" name="" value=""><br>
        <input type="submit" id="submit" name="">
    </form>

    <table class="">
        <thead>
            <tr>
                <td style="border: 1px solid;background-color:green">
                    <p>Average Height of all performers</p>
                </td>
                <td style="border: 1px solid;background-color:green">
                    <p>Percentage of performers taller than the average women</p>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid;background-color:red">
                    <p value=$avgHeight alt="There is no performers yet"></p>
                </td>
                <td style="border: 1px solid;background-color:red">
                    <p value=$percentage alt="There is no performers yet"></p>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="errors" id="errors" value="$errors" />
</body>

</html>