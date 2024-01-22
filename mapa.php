<!DOCTYPE html>
<html lang="en">
<head>
  <script src="//unpkg.com/react/umd/react.production.min.js"></script>
  <script src="//unpkg.com/react-dom/umd/react-dom.production.min.js"></script>
  <script src="//unpkg.com/@babel/standalone"></script>

  <script src="//unpkg.com/react-globe.gl"></script>

  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EcoGuardian</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="Fotos/FavIcon.png" />
</head>

<style>
  .modal {
  width: 20%;
  height: 35%;
  background-color: #49393b  ;
  border-radius: 20px;
  z-index: 2;
  position: absolute;
  left: 5%;
  top: 30%;
  display: none;
  align-items: center;
 }

 .modal-content {
  margin: 15% auto;
  width: 80%;
  height: 70%;
  justify-content: center;
 }

 #buttons{
    height: 0px;
    width: 100%;
    background-color: #341C1C;
    list-style-type: none;

    
 }

 /* Button Style */
 .button {
      display: inline-block;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
      color: #fff;
      background-color: #6c6061;
      border: 2px solid #6c6061;
      cursor: pointer;
      list-style-type: none;
 }

 #buttons button {
  margin: 30px; /* Adjust as needed */
 }

 /* Hover Effect */
 .button:hover {
      background-color: #564E4E;
      border-color: #564E4E;
  }
 .button-image {
    width: 60px;
    height: 60px;
 }

 .button-position{
   position: absolute;
   top: 26%;
   left: 82%;
   z-index: 1;
 }

 .modal2 {
  width: 20%;
  height: 25%;
  background-color: #49393b  ;
  border-radius: 20px;
  z-index: 2;
  position: absolute;
  left: 5%;
  top: 70%;
  align-items: center;
  display: none;
 }

 .modal-content2 {
  margin: 5% ;
  width: 80%;
  height: 70%;
  justify-content: center;
 }

 .box2{
  width: 100%;
  height: 70vh;
  background-color: #504136;
  text-align: center;
  padding-top: 1%;
  z-index: 1;
  position: relative;
 }

 .tercio {
  width: 25%;
  height: 65%;
  background-color: #51291E;
  float: left;
  margin: 4%;
  border-radius: 20px;
 }

 .tercio p {
  color: white;
  font-size: 10px;
  text-align: justify;
  padding: 5%;
 }

 .color-box {
  width: 10%;
  height: 30px;
  border-radius: 20%;
  margin: 5%;
 }

 #color-bajo1 {
  background-color: green;
 }
 #color-bajo2 {
  background-color: lightgreen;
 }
 #color-bajo3 {
  background-color: blue;
 }
 #color-moderado1 {
  background-color: orange;
 }
 #color-moderado2 {
  background-color: yellow;
 }
 #color-moderado3 {
  background-color: lightblue;
 }
 #color-alto1 {
  background-color: red;
 }
 #color-alto2 {
  background-color: purple;
 }
 #color-alto3 {
  background-color: black;
 }
 .color-container {
  display: flex;
  align-items: center;
 }
 .color-info {
  margin-left: 10px;
  width: 90%;
 }
</style>

<body>

  <div id="header2">
    <h1>EcoGuardian</h1>
    <nav>
      <ul id="sidemenu">
        <li><a href="data.php">DATA </a></li>
        <li><a href="index.html">HOME</a></li>
        <li><a href="mapa.html">MAPA</a></li>
      </ul>
    </nav> 
  </div>
  
    <div id="myModal" class="modal">
      <div class="modal-content" id="modal-content">
        <!-- Aquí se mostrará la información del marcador -->
      </div>
    </div>

    <div id="myModal2" class="modal2">
      <div class="modal-content" id="modal-content2">
        <!-- Aquí se mostrará la información del marcador -->
      </div>
    </div>


  <div class="button-position">
    <ul id="buttons">
        <li>
          <button class="button" onclick="filterMarkers('Riesgo bajo')">
          <img src="Fotos/FireGreen.png" class="button-image"alt="">
          </button></li>
        <li><button class="button" onclick="filterMarkers('Riesgo Moderado')"> <img src="Fotos/FireOrange.png" class="button-image"alt=""></button> </li>
        <li><button class="button" onclick="filterMarkers('Riesgo ALTO')"> <img src="Fotos/FireRed.png" class="button-image"alt=""></button> </li>
     </ul>
  </div>

    


  <div id="globeViz"></div>

  <div class="box2">
    <h1>INFORMACIÓN SOBRE COLORES</h1>

    <div class="tercio">
      <h2>RIESGO BAJO</h2>
      <div class="color-container">
        <div id="color-bajo1" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p>Cuando la temperatura es moderada (menor o igual a 25°C), la humedad es alta (mayor o igual al 60%), las concentraciones de gas son bajas (menos de 100 ppm), y la humedad del suelo es baja. Bajo estas condiciones, el riesgo de incendio es bajo, ya que el entorno es fresco y húmedo, lo que dificulta la propagación del fuego.
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-bajo2" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p>Similar al verde fuerte, pero con humedad baja (menos del 40%). Aunque la temperatura sea moderada y las concentraciones de gas sean bajas, la humedad más baja sugiere una menor probabilidad de incendio.
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-bajo3" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p> Temperatura moderada (menor o igual a 25°C), humedad del aire moderada (entre 40% y 60%) y alta humedad del suelo. Bajo estas condiciones, el riesgo de incendio es bajo ya que tanto el ambiente como el suelo tienen una humedad favorable para prevenir incendios.
          </p>
      </div>
      </div>
    </div>

    
    <div class="tercio">
      <h2>RIESGO MODERADO</h2>
      <div class="color-container">
        <div id="color-moderado1" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p>Similar al amarillo, pero con humedad del aire ligeramente más baja (menos del 40%). Indica un riesgo moderado debido a la disminución de la humedad, lo que puede facilitar la combustión.
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-moderado2" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p> Con temperatura moderada (entre 25°C y 30°C), humedad moderada (entre 40% y 60%), concentraciones de gas bajas y humedad baja en el suelo, representa un riesgo moderado de incendio. Aunque la humedad del aire sea moderada, la baja humedad del suelo puede contribuir al riesgo.
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-moderado3" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p>Temperatura moderada (menor o igual a 25°C), baja humedad del aire (menos del 40%) y alta humedad del suelo. Aunque el suelo esté húmedo, la baja humedad del aire sugiere un riesgo moderado debido a la sequedad del ambiente.
          </p>
        </div>
      </div>
    </div>

    <div class="tercio">
      <h2>RIESGO ALTO</h2>
      <div class="color-container">
        <div id="color-alto1" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p>Esta categoría indica un riesgo alto de incendio. Se da en temperaturas ALTAS (mayores a 32°C), humedad relativamente baja (menos del 40%), altas concentraciones de gas (más de 100 ppm) y alta humedad en el suelo. Estas condiciones sugieren un entorno propenso a la rápida propagación del fuego
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-alto2" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p> Temperatura ALTA (mayores a 32°C), humedad alta (más del 60%), altas concentraciones de gas (más de 100 ppm) y baja humedad del suelo. Aunque la humedad ambiental sea alta, las altas concentraciones de gas y la baja humedad del suelo aumentan el riesgo de incendio.
          </p>
        </div>
      </div>

      <div class="color-container">
        <div id="color-alto3" class="color-box"></div>
        <div id="color-info-bajo" class="color-info">
          <p> ESTADO DEL ECOGUARDIAN DESCONOCIDO
          </p>
        </div>
      </div>
    </div>
   

  </div>

  <?php 
   $username = "root";
   $password = "";
   $database = "ecoguardian";

    try {
      $pdo = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT * FROM dispositivos_ecoguardianes";
      $stmt = $pdo->query($sql);

      $latitudes = array();
      $longitudes = array();
      $estados = array();

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $latitudes[] = $row['latitud'];
          $longitudes[] = $row['longitud'];
          $estados[] = $row['estado'];
      }
    } catch(PDOException $e) {
      die("ERROR: Could not execute $sql. " . $e->getMessage());
    }

   $pdo = null; // Cerrar conexión
  ?>

 

  <script>
    function filterMarkers(estado) {
      const markers = document.getElementsByClassName('marker');
      let count = 0;
      let ids = [];

      for (let i = 0; i < markers.length; i++) {
        const marker = markers[i];
        const markerEstado = marker.dataset.estado;
        if (markerEstado === estado) {
          marker.style.display = 'block';
          count++;

          const id = marker.dataset.id;
          ids.push(id);
        } else {
          marker.style.display = 'none';
        }
      }

      const modal = document.getElementById('myModal2');
      const modalContent = document.getElementById('modal-content2');

      let modalHTML = `<h2>${count} ecoguardianes en estado ${estado}</h2>`;
     

      modalContent.innerHTML = modalHTML;
      modal.style.display = 'block';
 }


  </script>
  <script type="text/jsx">

   const latitudes = <?php echo json_encode($latitudes); ?>;
   const longitudes = <?php echo json_encode($longitudes); ?>;
   const estados = <?php echo json_encode($estados); ?>;
   const pointsData = [];
       

   // Esta función se llamará al hacer clic en un marcador
    const handleMarkerClick = (data) => {
      const modal = document.getElementById('myModal');
      const modalContent = document.getElementById('modal-content');

      // Asigna la información del marcador al contenido del modal
      modalContent.innerHTML = `
        <h2>Información del marcador</h2>
        <br>
        <p>ID: ${data.id}</p>
        <p>Latitud: ${data.lat}</p>
        <p>Longitud: ${data.lng}</p>
        <p>Estado: ${data.estado}</p>
      `;

      // Muestra el modal
      modal.style.display = 'block';
     };


    const markerSvg = `<svg viewBox="-4 0 36 36">
      <path fill="currentColor" d="M14,0 C21.732,0 28,5.641 28,12.6 C28,23.963 14,36 14,36 C14,36 0,24.064 0,12.6 C0,5.641 6.268,0 14,0 Z"></path>
      <circle fill="black" cx="14" cy="14" r="7"></circle>
    </svg>`;
    for (let i = 0; i < latitudes.length; i++) {
  let estadoTextual, color;
  switch (estados[i]) {
    case 'verde_fuerte':
      estadoTextual = 'Riesgo bajo';
      color = 'green';
      break;
    case 'verde_claro':
      estadoTextual = 'Riesgo bajo';
      color = 'lightgreen';
      break;
    case 'azul':
      estadoTextual = 'Riesgo bajo';
      color = 'blue';
      break;
    case 'amarillo':
      estadoTextual = 'Riesgo Moderado';
      color = 'yellow';
      break;
    case 'naranja':
      estadoTextual = 'Riesgo Moderado';
      color = 'orange';
      break;
    case 'celeste':
      estadoTextual = 'Riesgo Moderado';
      color = 'lightblue';
      break;
    case 'rojo':
      estadoTextual = 'Riesgo ALTO';
      color = 'red';
      break;
    case 'morado':
      estadoTextual = 'Riesgo ALTO';
      color = 'purple';
      break;
    default:
      estadoTextual = 'Desconocido';
      color = 'black';
  }

  pointsData.push({
    id: i,
    lat: latitudes[i],
    lng: longitudes[i],
    estado: estadoTextual,
    size: 20,
    color: color
  });
}

    ReactDOM.render(
      <Globe
        globeImageUrl="//unpkg.com/three-globe/example/img/earth-day.jpg"
        backgroundColor="#a49e8d"
        htmlElementsData={pointsData}
        htmlElement={d => {
          const el = document.createElement('div');
          el.className = 'marker'; // Agrega esta línea
          el.dataset.estado = d.estado; // Almacena el estado textual
          el.innerHTML = markerSvg;
          el.style.color = d.color;
          el.style.width = `${d.size}px`;
          el.style['pointer-events'] = 'auto';
          el.style.cursor = 'pointer';
          el.onclick = () => handleMarkerClick(d); // Llamará a la función con los datos del marcador al hacer clic
          return el;
          
        }}
      />,
      document.getElementById('globeViz')
    );
  </script>
</body>
</html>
