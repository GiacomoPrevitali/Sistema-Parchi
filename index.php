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
    $sql='SELECT Id_Specie FROM animale WHERE Id_Parco="'.$_REQUEST['Nome_Parco'].'"';
    $result =$connection->query($sql);
   
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            echo  '<p>'.$row['Id_Specie'].'</p>';
            
        }
    }else{
        echo "Nessun utente trovato";
    }
    
  }
  ?>
</body>
</html>    