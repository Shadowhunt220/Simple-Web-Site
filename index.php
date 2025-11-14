# Simple-Web-Site
A demostration on a school project
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema CRUD - Catálogo de Registros</title>
  <style>
    :root {
      --primary-color: #4CAF50;
      --secondary-color: #45a049;
      --danger-color: #f44336;
      --warning-color: #ff9800;
      --light-gray: #f5f5f5;
      --dark-gray: #333;
      --border-radius: 8px;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f0f2f5;
      color: var(--dark-gray);
      line-height: 1.6;
      padding: 20px;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    header {
      text-align: center;
      margin-bottom: 30px;
      padding: 20px;
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
      color: var(--primary-color);
      margin-bottom: 10px;
    }
    
    .subtitle {
      color: #666;
      font-size: 1.1rem;
    }
    
    .main-content {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 20px;
    }
    
    @media (max-width: 768px) {
      .main-content {
        grid-template-columns: 1fr;
      }
    }
    
    .form-section, .records-section {
      background-color: white;
      border-radius: var(--border-radius);
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
      margin-bottom: 15px;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
    }
    
    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }
    
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--primary-color);
    }
    
    input:valid {
      border-color: var(--primary-color);
    }
    
    input:invalid {
      border-color: var(--danger-color);
    }
    
    textarea {
      min-height: 120px;
      resize: vertical;
    }
    
    .checkbox-group {
      margin-top: 10px;
    }
    
    .checkbox-item {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }
    
    input[type="checkbox"] {
      appearance: none;
      -webkit-appearance: none;
      height: 1.5em;
      width: 1.5em;
      background-color: #d5d5d5;
      border-radius: 0.25em;
      cursor: pointer;
      display: inline-block;
      vertical-align: middle;
      outline: none;
      margin-right: 10px;
      flex-shrink: 0;
    }
    
    input[type="checkbox"]:checked {
      background-color: var(--primary-color);
      position: relative;
    }
    
    input[type="checkbox"]:checked::after {
      content: "✓";
      color: white;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }
    
    .btn-group {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }
    
    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: background-color 0.3s;
      flex: 1;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: var(--secondary-color);
    }
    
    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #5a6268;
    }
    
    .btn-danger {
      background-color: var(--danger-color);
      color: white;
    }
    
    .btn-danger:hover {
      background-color: #d32f2f;
    }
    
    .btn-warning {
      background-color: var(--warning-color);
      color: white;
    }
    
    .btn-warning:hover {
      background-color: #e68900;
    }
    
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .search-box {
      display: flex;
      gap: 10px;
    }
    
    .search-box input {
      flex: 1;
    }
    
    .card {
      border: 1px solid #ddd;
      border-radius: var(--border-radius);
      margin: 10px 0;
      padding: 15px;
      background-color: var(--light-gray);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    
    .card-title {
      font-weight: bold;
      font-size: 1.1rem;
      color: var(--dark-gray);
    }
    
    .card-actions {
      display: flex;
      gap: 5px;
    }
    
    .btn-sm {
      padding: 5px 10px;
      font-size: 0.8rem;
    }
    
    .card-body {
      font-size: 14px;
    }
    
    .card-body p {
      margin-bottom: 5px;
    }
    
    .no-records {
      text-align: center;
      padding: 20px;
      color: #666;
    }
    
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    
    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: var(--border-radius);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
    }
    
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .close {
      font-size: 1.5rem;
      cursor: pointer;
      color: #666;
    }
    
    .close:hover {
      color: var(--dark-gray);
    }
    
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>Sistema CRUD - Catálogo de Registros</h1>
      <p class="subtitle">Gestión completa de registros con operaciones de crear, leer, actualizar y eliminar</p>
    </header>
    
    <div class="main-content">
      <section class="form-section">
        <h2>Formulario de Registro</h2>
        <form id="registroForm">
          <div class="form-group">
            <label for="segundo">Apellidos:</label>
            <input type="text" id="segundo" name="segundo" placeholder="Escribe tus apellidos" required>
          </div>
          
          <div class="form-group">
            <label for="primero">Primer Nombre:</label>
            <input type="text" id="primero" name="primero" placeholder="Escribe tu Primer Nombre" required>
          </div>
          
          <div class="form-group">
            <label for="dos">Segundo Nombre:</label>
            <input type="text" id="dos" name="dos" placeholder="Escribe tu Segundo Nombre" required>
          </div>
          
          <div class="form-group">
            <label for="area">Detalles:</label>
            <textarea id="area" name="area" rows="10" cols="15" required>Número de Identificación:
Ocupación:
Nivel:
Especialidades:</textarea>
          </div>
          
          <div class="form-group">
            <label for="hobbies">Escoge un hobby:</label>
            <select name="hobbies" id="hobbies" required>
              <option value="">--Seleccione uno--</option>
              <option value="jugar">Jugar Videojuegos</option>
              <option value="ver">Ver películas y/o series</option>
              <option value="música">Escuchar Música</option>
              <option value="leer">Lectura</option>
              <option value="armar">Armar Rompecabezas</option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Verificación:</label>
            <div class="checkbox-group">
              <div class="checkbox-item">
                <input type="checkbox" id="A" name="A" value="Seguro">
                <label for="A">Tengo seguro</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="B" name="B" value="Auto">
                <label for="B">Tengo auto</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="C" name="C" value="Acceso">
                <label for="C">Tengo acceso</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="D" name="D" value="Bicicleta">
                <label for="D">Tengo bicicleta</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="E" name="E" value="Herramientas">
                <label for="E">Tengo herramientas</label>
              </div>
            </div>
          </div>
          
          <div class="btn-group">
            <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
            <button type="button" class="btn btn-secondary" id="btnLimpiar">Limpiar</button>
          </div>
          
          <input type="hidden" id="editIndex" value="-1">
        </form>
      </section>
      
      <section class="records-section">
        <div class="section-header">
          <h2>Registros Guardados</h2>
          <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar registros...">
            <button class="btn btn-secondary" id="btnSearch">Buscar</button>
          </div>
        </div>
        
        <div id="dinamico">
          <div class="no-records">No hay registros guardados</div>
        </div>
      </section>
    </div>
  </div>
  
  <!-- Modal para ver detalles -->
  <div class="modal" id="detailsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Detalles del Registro</h3>
        <span class="close" id="closeDetails">&times;</span>
      </div>
      <div id="modalContent"></div>
    </div>
  </div>

  <script>
    // Base de datos simulada usando localStorage
    const DB_NAME = 'registros_crud';
    
    // Inicializar la aplicación
    document.addEventListener('DOMContentLoaded', function() {
      // Cargar registros al iniciar
      cargarRegistros();
      
      // Configurar eventos
      document.getElementById('btnGuardar').addEventListener('click', guardarRegistro);
      document.getElementById('btnLimpiar').addEventListener('click', limpiarFormulario);
      document.getElementById('btnSearch').addEventListener('click', buscarRegistros);
      document.getElementById('searchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') buscarRegistros();
      });
      document.getElementById('closeDetails').addEventListener('click', cerrarModal);
      
      // Cerrar modal al hacer clic fuera
      window.addEventListener('click', function(e) {
        const modal = document.getElementById('detailsModal');
        if (e.target === modal) {
          cerrarModal();
        }
      });
    });
    
    // Obtener registros de la base de datos
    function obtenerRegistros() {
      const registros = localStorage.getItem(DB_NAME);
      return registros ? JSON.parse(registros) : [];
    }
    
    // Guardar registros en la base de datos
    function guardarRegistros(registros) {
      localStorage.setItem(DB_NAME, JSON.stringify(registros));
    }
    
    // Guardar un nuevo registro o actualizar uno existente
    function guardarRegistro() {
      // Obtener datos del formulario
      const datos = {
        segundo: document.getElementById("segundo").value,
        primero: document.getElementById("primero").value,
        dos: document.getElementById("dos").value,
        area: document.getElementById("area").value,
        hobbies: document.getElementById("hobbies").value,
        A: document.getElementById("A").checked ? "Sí" : "No",
        B: document.getElementById("B").checked ? "Sí" : "No",
        C: document.getElementById("C").checked ? "Sí" : "No",
        D: document.getElementById("D").checked ? "Sí" : "No",
        E: document.getElementById("E").checked ? "Sí" : "No"
      };
      
      // Validar campos obligatorios
      if (datos.segundo === "" || datos.primero === "" || datos.dos === "" || 
          datos.area === "" || datos.hobbies === "") {
        alert("Todos los campos obligatorios deben llenarse");
        return;
      }
      
      // Obtener índice de edición
      const editIndex = parseInt(document.getElementById("editIndex").value);
      const registros = obtenerRegistros();
      
      if (editIndex === -1) {
        // Agregar nuevo registro
        registros.push(datos);
      } else {
        // Actualizar registro existente
        registros[editIndex] = datos;
        document.getElementById("editIndex").value = "-1";
        document.getElementById("btnGuardar").textContent = "Guardar";
      }
      
      // Guardar en la base de datos
      guardarRegistros(registros);
      
      // Recargar la vista
      cargarRegistros();
      
      // Limpiar formulario
      limpiarFormulario();
      
      alert(editIndex === -1 ? "Registro guardado exitosamente" : "Registro actualizado exitosamente");
    }
    
    // Cargar registros en la interfaz
    function cargarRegistros() {
      const registros = obtenerRegistros();
      const contenedor = document.getElementById('dinamico');
      
      if (registros.length === 0) {
        contenedor.innerHTML = '<div class="no-records">No hay registros guardados</div>';
        return;
      }
      
      contenedor.innerHTML = '';
      
      registros.forEach((registro, idx) => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
          <div class="card-header">
            <div class="card-title">${registro.primero} ${registro.dos} ${registro.segundo}</div>
            <div class="card-actions">
              <button class="btn btn-primary btn-sm" onclick="verRegistro(${idx})">Ver</button>
              <button class="btn btn-warning btn-sm" onclick="editarRegistro(${idx})">Editar</button>
              <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(${idx})">Eliminar</button>
            </div>
          </div>
          <div class="card-body">
            <p><strong>Hobby:</strong> ${obtenerTextoHobby(registro.hobbies)}</p>
            <p><strong>Seguro:</strong> ${registro.A}</p>
            <p><strong>Auto:</strong> ${registro.B}</p>
          </div>
        `;
        contenedor.appendChild(card);
      });
    }
    
    // Ver detalles de un registro
    function verRegistro(index) {
      const registros = obtenerRegistros();
      const registro = registros[index];
      
      const modalContent = document.getElementById('modalContent');
      modalContent.innerHTML = `
        <p><strong>Apellidos:</strong> ${registro.segundo}</p>
        <p><strong>Primer Nombre:</strong> ${registro.primero}</p>
        <p><strong>Segundo Nombre:</strong> ${registro.dos}</p>
        <p><strong>Detalles:</strong></p>
        <pre>${registro.area}</pre>
        <p><strong>Hobby:</strong> ${obtenerTextoHobby(registro.hobbies)}</p>
        <p><strong>Seguro:</strong> ${registro.A}</p>
        <p><strong>Auto:</strong> ${registro.B}</p>
        <p><strong>Acceso:</strong> ${registro.C}</p>
        <p><strong>Bicicleta:</strong> ${registro.D}</p>
        <p><strong>Herramientas:</strong> ${registro.E}</p>
      `;
      
      document.getElementById('detailsModal').style.display = 'flex';
    }
    
    // Editar un registro
    function editarRegistro(index) {
      const registros = obtenerRegistros();
      const registro = registros[index];
      
      // Llenar el formulario con los datos del registro
      document.getElementById("segundo").value = registro.segundo;
      document.getElementById("primero").value = registro.primero;
      document.getElementById("dos").value = registro.dos;
      document.getElementById("area").value = registro.area;
      document.getElementById("hobbies").value = registro.hobbies;
      document.getElementById("A").checked = registro.A === "Sí";
      document.getElementById("B").checked = registro.B === "Sí";
      document.getElementById("C").checked = registro.C === "Sí";
      document.getElementById("D").checked = registro.D === "Sí";
      document.getElementById("E").checked = registro.E === "Sí";
      
      // Configurar para edición
      document.getElementById("editIndex").value = index;
      document.getElementById("btnGuardar").textContent = "Actualizar";
      
      // Desplazar hacia el formulario
      document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Eliminar un registro
    function eliminarRegistro(index) {
      if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        const registros = obtenerRegistros();
        registros.splice(index, 1);
        guardarRegistros(registros);
        cargarRegistros();
        alert("Registro eliminado exitosamente");
      }
    }
    
    // Buscar registros
    function buscarRegistros() {
      const termino = document.getElementById("searchInput").value.toLowerCase();
      const registros = obtenerRegistros();
      const contenedor = document.getElementById('dinamico');
      
      if (termino === "") {
        cargarRegistros();
        return;
      }
      
      const resultados = registros.filter(registro => 
        registro.segundo.toLowerCase().includes(termino) ||
        registro.primero.toLowerCase().includes(termino) ||
        registro.dos.toLowerCase().includes(termino) ||
        registro.area.toLowerCase().includes(termino) ||
        obtenerTextoHobby(registro.hobbies).toLowerCase().includes(termino)
      );
      
      if (resultados.length === 0) {
        contenedor.innerHTML = '<div class="no-records">No se encontraron registros</div>';
        return;
      }
      
      contenedor.innerHTML = '';
      
      resultados.forEach((registro, idx) => {
        const originalIndex = registros.findIndex(r => 
          r.segundo === registro.segundo && 
          r.primero === registro.primero && 
          r.dos === registro.dos
        );
        
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
          <div class="card-header">
            <div class="card-title">${registro.primero} ${registro.dos} ${registro.segundo}</div>
            <div class="card-actions">
              <button class="btn btn-primary btn-sm" onclick="verRegistro(${originalIndex})">Ver</button>
              <button class="btn btn-warning btn-sm" onclick="editarRegistro(${originalIndex})">Editar</button>
              <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(${originalIndex})">Eliminar</button>
            </div>
          </div>
          <div class="card-body">
            <p><strong>Hobby:</strong> ${obtenerTextoHobby(registro.hobbies)}</p>
            <p><strong>Seguro:</strong> ${registro.A}</p>
            <p><strong>Auto:</strong> ${registro.B}</p>
          </div>
        `;
        contenedor.appendChild(card);
      });
    }
    
    // Limpiar formulario
    function limpiarFormulario() {
      document.getElementById("registroForm").reset();
      document.getElementById("editIndex").value = "-1";
      document.getElementById("btnGuardar").textContent = "Guardar";
    }
    
    // Cerrar modal
    function cerrarModal() {
      document.getElementById('detailsModal').style.display = 'none';
    }
    
    // Obtener texto del hobby
    function obtenerTextoHobby(valor) {
      const hobbies = {
        'jugar': 'Jugar Videojuegos',
        'ver': 'Ver películas y/o series',
        'música': 'Escuchar Música',
        'leer': 'Lectura',
        'armar': 'Armar Rompecabezas'
      };
      return hobbies[valor] || valor;
    }
  </script>
</body>
</html>
