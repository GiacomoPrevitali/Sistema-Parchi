<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sistema Parchi</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
        <script type="text/javascript" src="script.js"></script>
  </head>
</head>
<body>

<center>
    
        <form method="GET" action="index.php">
        <select name="Nome_Parco" id="Nome_P" class="btn btn-outline-success">
        <option >Seleziona Parco</option>
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
       





<form method="GET" action="index.php">
<select name="Specie_Richiesta" id="i_specie" class="btn btn-outline-success"">
<option >Seleziona Specie</option>
  <?php
  if(isset($_GET['Nome_Parco'])){
    $_SESSION['N_Parco']=$_GET['Nome_Parco'];
    echo'<script>document.getElementById("Nome_P").value="'.$_SESSION["N_Parco"].'"</script>';
    $ip= '127.0.0.1';
    $username='root';
    $password='';
    $database='sistem';
  
    $connection=new mysqli($ip,$username,$password,$database);
    if ($connection->connect_error) {
        die('C\'è stato un errore: ' . $connection->connect_error);
    }
    $sql='SELECT DISTINCT Id_Specie FROM animale WHERE Id_Parco="'.$_SESSION['N_Parco'].'"';
    $result =$connection->query($sql);
    
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
      
        echo  '<option >'.$row['Id_Specie'].'</option>';
        
      }
    }else{
        echo  '<option >'."Nessun utente trovato".'</option>';
    }
  }
  ?>
</select>
<input   type="hidden"name="Nome_Parco" value="<?php if(isset($_GET['Nome_Parco'])){echo $_GET['Nome_Parco'];} ?>">
<button class="btn btn-outline-success" type="submit">Cerca</button>
</form>
 <br>


<?php
if(isset($_GET['Specie_Richiesta'])){
  $ip= '127.0.0.1';
  $username='root';
  $password='';
  $database='sistem';
  $_SESSION['specie'] = $_GET['Specie_Richiesta']; 
  echo'<script>document.getElementById("i_specie").value="'.$_SESSION["specie"].'"</script>';
  echo'<script>document.getElementById("Nome_P").value="'.$_SESSION["N_Parco"].'"</script>';
  //echo $_GET['Nome_Parco'];
  $connection=new mysqli($ip,$username,$password,$database);
  if ($connection->connect_error) {
      die('C\'è stato un errore: ' . $connection->connect_error);
  }
  $sql='SELECT Data_Nascita FROM animale WHERE Id_Specie="'.$_REQUEST['Specie_Richiesta'].'" AND Id_Parco="'.$_SESSION['N_Parco'].'"';
  $result =$connection->query($sql);
      $count=0;
      $e=0;
  if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
    
      $data_iniziale = new DateTime($row['Data_Nascita']); 
      $data_finale = new Datetime(date('m.d.y'));

      $diff = $data_finale->diff($data_iniziale);
      $diff = $diff->format('%y');
      $e = $e + $diff;
      $count++;
    }
    $media=$e/$count;
    $media=floor($media);
    if($count==1){
      echo "In questo parco è presente: ". $count. " esemplare di ".$_REQUEST['Specie_Richiesta']. " con un'età di ".$media. " anni";
    }else{
        echo "In questo parco sono presenti: ". $count. " esemplari di ".$_REQUEST['Specie_Richiesta']. " con un'età media di ".$media. " anni";
      }
    
    
  }else{
      echo  '<option >'."Nessun utente trovato".'</option>';
  }
  
}


?>
</center>
</body>
</html>