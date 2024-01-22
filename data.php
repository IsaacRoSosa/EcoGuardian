<?php 

$username = "root";
$password = "";
$database = "ecoguardian";

try {
  $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
  die("ERROR: Could not connect. " . $e->getMessage());
}

?>

<style>
  #header2{
    position : relative;
  }

  #sidemenu{
    position : relative;
  }



  #header8{
    width: 100%;
    height: 100vh;
    background-color: #4A4B2F;
    position: relative;
    padding-top: 50px;
  }
  

  .forestStatus{

  margin-top: 80px;
 }



  .forestStatusBox{
    position: relative;
    width: 350px;
    height: 200px;
    background-color: #273B09;
    border-radius: 10px;
    margin: 0 auto;
    margin-top: 50px;
    text-align: center;
    color: white;
    font-size: 20px;
    padding-top: 50px;
    
  }

  .latest-data {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  padding: 20px;
}

.data-box {
  width: 200px;
  border: 1px solid #4b644a;
  border-radius: 10px;
  padding: 20px;
  margin: 10px;
  text-align: center;
  background-color: #89a894;
  
}

.data-box img {
  width: 100%;
  height: auto;
}

.data-box p {
  margin-top: 10px;
}

</style>

<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="style.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EcoGuardian Data</title>
    <link rel="icon" type="image/png" href="Fotos/FavIcon.png" />

  </head>
  <body>
   <!-- Header-->
     <div id="header2">
      <h1>EcoGuardian</h1>
      <nav>
        <ul id="sidemenu">
          <li><a href="data.php">DATA </a></li>
          <li><a href="index.html">HOME</a></li>
          <li><a href="mapa.php">MAPA</a></li>
        </ul>
      </nav>
    </div>

    <!-- Forest Status-->

    <?php
          $username = "root";
          $password = "";
          $database = "ecoguardian";

      try {
          $pdo = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Obtener el estado donde la ID sea 1
          $stmt = $pdo->prepare("SELECT estado FROM dispositivos_ecoguardianes WHERE id = 35");
          $stmt->execute();
          $estadoData = $stmt->fetch();

          $estadoTextual = 'Desconocido';
          $color = 'black';

          if ($estadoData) {
              $estado = $estadoData['estado'];

              switch ($estado) {
                  case 'verde_fuerte':
                  case 'verde_claro':
                  case 'azul':
                      $estadoTextual = 'Riesgo bajo';
                      $color = ($estado === 'verde_fuerte') ? 'green' : (($estado === 'verde_claro') ? 'lightgreen' : 'blue');
                      break;
                  case 'amarillo':
                  case 'naranja':
                  case 'celeste':
                      $estadoTextual = 'Riesgo moderado';
                      $color = ($estado === 'amarillo') ? 'yellow' : (($estado === 'naranja') ? 'orange' : 'lightblue');
                      break;
                  case 'rojo':
                  case 'morado':
                      $estadoTextual = 'Riesgo alto';
                      $color = ($estado === 'rojo') ? 'red' : 'purple';
                      break;
              }
          }

      } catch(PDOException $e) {
          die("ERROR: Could not execute query. " . $e->getMessage());
      }
  ?>
    <div id="header8">
      <div class="forestStatus">
        <div class="forestStatusBox" style="background-color: <?php echo $color; ?>">
          <h2>Estado del Bosque</h2>
          <p>El bosque se encuentra en un estado: </p>
          <h4><?php echo $estadoTextual; ?></h4>
          <p>Color: <?php echo $color; ?> </p>
         
        </div>
      </div>


<?php
try {
    $sql = "SELECT * FROM ecoguardian.datos ORDER BY fecha DESC LIMIT 1";   
    $result = $pdo->query($sql);

    if($result->rowCount() > 0) {
        $latestData = $result->fetch();

        // Renombrar las variables para mayor claridad
        $latestHT = $latestData["temperatura"];
        $latestHA = $latestData["humedad"];
        $latestHTierra = $latestData["humedad_tierra"];
        $latestPPM = $latestData["ppm_gas"];

        // Resto de tu código
    }
} catch (PDOException $e) {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
?>


      <div class="latest-data">
        <div class="data-box">
          <img src="Fotos/HumT.png" alt="Tipo de dato 1">
          <p>Humedad de Tierra:   <?php echo $latestHTierra; ?></p>
        </div>
        <div class="data-box">
          <img src="Fotos/TempL.png" alt="Tipo de dato 2">
          <p>Temperatura:  <?php echo $latestHT; ?></p>
        </div>
        <div class="data-box">
          <img src="Fotos/HumL.png" alt="Tipo de dato 3">
          <p>Humedad: <?php echo $latestHA; ?></p></p>
        </div>
        <div class="data-box">
          <img src="Fotos/GasL.png" alt="Tipo de dato 4">
          <p>PPM de CO:  <?php echo $latestPPM; ?></p>
        </div>
      </div>
    </div>
    <div class="breaker2"></div>


    <!-- Filter options-->


      <!-- GrapH Display-->
    <div id="header3">
      <div class="graphDisplay">
         
        <div class="chartBox">
        <canvas id="chartHumedadTierra" ></canvas>
        </div>
        
      </div>

      <div class="graphDisplay">
        <div class="chartBox">
          <canvas id="chartHumedadAmbiente" ></canvas>
        </div>
      </div>

      <div class="graphDisplay">
        <div class="chartBox">
          <canvas id="temperaturaAmbiente" ></canvas>
        </div>
      </div>

      <div class="graphDisplay">
        <div class="chartBox">
          <canvas id="chartSensorGas" ></canvas>
        </div>
      </div>

    </div>
    <!-- Codigo de base de datos y graficos-->
        <?php 
        // Attempt select query execution
        try{
        $sql = "SELECT * FROM ecoguardian.datos";   
        $result = $pdo->query($sql);
        if($result->rowCount() > 0) {
            $humedadTierra = array();
            $labeldates = array();
            while($row = $result->fetch()) {
                $humedadTierra[] = $row["humedad_tierra"];
                $humedadAmbiente[] = $row["humedad"];
                $temperaturaAmbiente[] = $row["temperatura"];
                $Sensorppm[] = $row["ppm_gas"];
                $labeldates[] = $row["fecha"];
            }


        unset($result);
        } else {
            echo "No records matching your query were found.";
        }
        } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        
        // Close connection
        unset($pdo);
        ?>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>

        //Deserializacion de datos
        console.log(<?php echo json_encode($humedadTierra); ?>);
        const humedadTierra = <?php echo json_encode($humedadTierra); ?>;
        const humedadAmbiente = <?php echo json_encode($humedadAmbiente); ?>;
        const temperaturaAmbiente = <?php echo json_encode($temperaturaAmbiente); ?>;
        const Sensorppm = <?php echo json_encode($Sensorppm); ?>;
        const labeldates = <?php echo json_encode($labeldates); ?>;

      //Grafico Humedad Tierra
        //Data Block
        const dataHumedadTierra = {
        labels: labeldates,
                datasets: [{
                    label: 'Humedad Tierra',
                    data: humedadTierra,
                    borderWidth: 1,
                    tension: 0.1,
                    borderColor: 'rgb(2, 128, 148)'
                    
                }]
        };
        //Configutarion Blocks
        const configHumedadTierra = {
                type: 'line',
                data: dataHumedadTierra,
                options: {
                    scales: {
                        y: {
                          beginAtZero: true
                        }
                     }
                 }
        };

        //Render Blocks
        const chartHumedadTierra = new Chart(
            document.getElementById('chartHumedadTierra'),
            configHumedadTierra
        );
      //Grafico Humedad Aire
        //Data Block
        const dataHumedadAire = {
          labels: labeldates,
                datasets: [{
                    label: 'Humedad Ambiente',
                    data: humedadAmbiente,
                    borderWidth: 1,
                    tension: 0.1,
                    borderColor: 'rgb(167, 204, 237)'
               }]
        };
        //Configutarion Block
        const configHumedadAire = {
                type: 'line',
                data: dataHumedadAire,
                options: {
                    scales: {
                        y: {
                          beginAtZero: true
                        }
                     }
                 }
        };
        //Render Block
        const chartHumedadAire = new Chart(
            document.getElementById('chartHumedadAmbiente'),
            configHumedadAire
        );
      //Grafico Temperatura Ambiente
        //Data Block 
        const dataTemperaturaAmbiente = {
          labels: labeldates,
                datasets: [{
                    label: 'Temperatura Ambiente',
                    data: temperaturaAmbiente,
                    borderWidth: 1,
                    tension: 0.1,
                    borderColor: 'rgb(255, 99, 132)'
               }]
        };
        //Configutarion Block
        const configTemperaturaAmbiente = {
                type: 'line',
                data: dataTemperaturaAmbiente,
                options: {
                    scales: {
                        y: {
                          beginAtZero: true
                        }
                     }
                 }
        };
        //Render Block
        const chartTemperaturaAmbiente = new Chart(
            document.getElementById('temperaturaAmbiente'),
            configTemperaturaAmbiente
        );
      //Grafico Sensor Gas
        //Data Block
        const dataSensorGas = {
          labels: labeldates,
                datasets: [{
                    label: 'Sensor Gas',
                    data: Sensorppm,
                    borderWidth: 1,
                    tension: 0.1,
                    borderColor: 'rgb(255, 99, 132)'
               }]
        };
        //Configutarion Block
        const configSensorGas = {
                type: 'line',
                data: dataSensorGas,
                options: {
                    scales: {
                        y: {
                          beginAtZero: true
                        }
                     }
                 }
        };
        //Render Block
        const chartSensorGas = new Chart(
            document.getElementById('chartSensorGas'),
            configSensorGas
        );

        </script>

  
  </body>


</html>