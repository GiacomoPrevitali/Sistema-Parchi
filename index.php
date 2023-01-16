<!DOCTYPE html>
<html>
    <head>
        <title>Sistema Parchi</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
  </head>
</head>
<body>




<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form method="GET" action="index.php">
        <select name="Nome_Parco" class="btn btn-outline-success"">
        <?php
            $ip= '127.0.0.1';
            $username='root';
            $password='';
            $database='sistem';

            $connection=new mysqli($ip,$username,$password,$database);
            if ($connection->connect_error) {
                die('C\'è stato un errore: ' . $connection->connect_error);
            }
            $sql ='SELECT Nome_Parco FROM parco';
            $result =$connection->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo  '<option >' . $row['Nome_Parco'] .'</option>';
                }
            }
        ?>
        </select>
            <button class="btn btn-outline-success" type="submit">Cerca</button>
        </form>
    </div>
  </div>
</nav>








<form method="GET" action="index.php">
<select name="Specie_Richiesta" class="btn btn-outline-success"">
  <?php
  if(isset($_REQUEST['Nome_Parco'])){
    $ip= '127.0.0.1';
    $username='root';
    $password='';
    $database='sistem';
  
    $connection=new mysqli($ip,$username,$password,$database);
    if ($connection->connect_error) {
        die('C\'è stato un errore: ' . $connection->connect_error);
    }
    $sql='SELECT DISTINCT Id_Specie FROM animale WHERE Id_Parco="'.$_REQUEST['Nome_Parco'].'"';
    $result =$connection->query($sql);
    
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
      
        echo  '<option >'.$row['Id_Specie'].'</option>';
        //$count=count($s);
      }
    }else{
        echo  '<option >'."Nessun utente trovato".'</option>';
    }
    
  }
  ?>
</select>
<input type="hidden" name="Nome_Parco" value="<?php echo $_REQUEST['Nome_Parco']; ?>">
<button class="btn btn-outline-success" type="submit">Cerca</button>
</form>



<?php
if(isset($_REQUEST['Specie_Richiesta'])){
  $ip= '127.0.0.1';
  $username='root';
  $password='';
  $database='sistem';

  $connection=new mysqli($ip,$username,$password,$database);
  if ($connection->connect_error) {
      die('C\'è stato un errore: ' . $connection->connect_error);
  }
  $sql='SELECT Data_Nascita FROM animale WHERE Id_Specie="'.$_REQUEST['Specie_Richiesta'].'" AND Id_Parco="'.$_GET['Nome_Parco'].'"';
  $result =$connection->query($sql);
  $year=0;
      $month=0;
      $day=0;
      $count=0;
  if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
    
      $data_iniziale = new DateTime($row['Data_Nascita']); 
      $data_finale = new Datetime(date('m.d.y'));
      
      $diff = $data_finale->diff($data_iniziale);
      $year=+$diff->y;
      $month=+$diff->m;
      $day=$day+$diff->d;
      $count++;
      //echo $count;
    }
    $tot=$year*365+$month*30+$day;
    if($count==1){
      echo "In questo parco è presente: ". $count. " esemplare di ".$_REQUEST['Specie_Richiesta']. " con un'età di ".$tot/$count;
    }else{
    echo "In questo parco sono presenti: ". $count. " esemplari di ".$_REQUEST['Specie_Richiesta']. " con un'età media di ".$tot/$count;
    }
    
  }else{
      echo  '<option >'."Nessun utente trovato".'</option>';
  }
  
}


?>
</body>
</html>