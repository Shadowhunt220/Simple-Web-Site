class MediaDatabase {
  constructor() {
    this.API_URL = 'https://simple-web-site-wxv9.onrender.com/api/registros';
    this.init();
  }

  init() {
    this.setupEventListeners();
    this.cargarRegistros();
  }

  setupEventListeners() {
    const form = document.getElementById('registroForm');
    form.addEventListener('submit', (e) => this.enviarFormulario(e));
  }

  async enviarFormulario(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const mediosDigitales = this.obtenerMediosDigitales();

    const registro = {
      apellidos: formData.get('apellidos'),
      primerNombre: formData.get('primerNombre'),
      segundoNombre: formData.get('segundoNombre'),
      detalles: formData.get('detalles'),
      hobbies: formData.get('hobbies'),
      seguro: formData.get('seguro') === 'true',
      auto: formData.get('auto') === 'true',
      acceso: formData.get('acceso') === 'true',
      bicicleta: formData.get('bicicleta') === 'true',
      herramientas: formData.get('herramientas') === 'true',
      mediosDigitales: mediosDigitales.filter(medio => 
        medio.tipo && medio.url && medio.plataforma
      )
    };

    try {
      await this.guardarRegistro(registro);
      e.target.reset();
      this.cargarRegistros();
      alert('✅ Registro guardado exitosamente');
    } catch (error) {
      alert('❌ Error al guardar el registro');
    }
  }

  obtenerMediosDigitales() {
    const medios = [];
    const medioItems = document.querySelectorAll('.medio-item');
    
    medioItems.forEach(item => {
      const tipo = item.querySelector('.medio-tipo').value;
      const url = item.querySelector('.medio-url').value;
      const plataforma = item.querySelector('.medio-plataforma').value;
      const titulo = item.querySelector('.medio-titulo').value;

      if (tipo && url) {
        medios.push({ tipo, url, plataforma, titulo });
      }
    });

    return medios;
  }

  async guardarRegistro(registro) {
    const response = await fetch(this.API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(registro)
    });

    if (!response.ok) {
      throw new Error('Error en la respuesta del servidor');
    }

    return await response.json();
  }

  async cargarRegistros() {
    const container = document.getElementById('registrosContainer');
    container.innerHTML = '<div class="loading">Cargando registros...</div>';

    try {
      const response = await fetch(this.API_URL);
      const registros = await response.json();
      
      this.mostrarRegistros(registros);
    } catch (error) {
      container.innerHTML = '<div class="error">❌ Error al cargar los registros</div>';
    }
  }

  mostrarRegistros(registros) {
    const container = document.getElementById('registrosContainer');
    
    if (registros.length === 0) {
      container.innerHTML = '<div class="loading">No hay registros guardados</div>';
      return;
    }

    container.innerHTML = registros.map(registro => `
      <div class="registro-card">
        <div class="registro-header">
          <div class="registro-title">
            ${registro.primerNombre} ${registro.segundoNombre} ${registro.apellidos}
          </div>
          <button class="btn-delete" onclick="app.eliminarRegistro('${registro._id}')">
            🗑️ Eliminar
          </button>
        </div>
        
        <div class="registro-body">
          <p><strong>📝 Detalles:</strong></p>
          <pre>${registro.detalles}</pre>
          
          <p><strong>🎯 Hobby:</strong> ${this.obtenerHobbyTexto(registro.hobbies)}</p>
          
          <div class="verificaciones">
            <p><strong>✅ Verificaciones:</strong></p>
            <div>🛡️ Seguro: ${registro.seguro ? 'Sí' : 'No'}</div>
            <div>🚗 Auto: ${registro.auto ? 'Sí' : 'No'}</div>
            <div>🔑 Acceso: ${registro.acceso ? 'Sí' : 'No'}</div>
            <div>🚲 Bicicleta: ${registro.bicicleta ? 'Sí' : 'No'}</div>
            <div>🛠️ Herramientas: ${registro.herramientas ? 'Sí' : 'No'}</div>
          </div>

          ${registro.mediosDigitales && registro.mediosDigitales.length > 0 ? `
            <div class="medios-list">
              <p><strong>🔗 Medios Digitales:</strong></p>
              ${registro.mediosDigitales.map(medio => `
                <a href="${medio.url}" target="_blank" class="medio-badge">
                  ${this.obtenerIconoMedio(medio.tipo)} ${medio.titulo || medio.plataforma}
                </a>
              `).join('')}
            </div>
          ` : ''}
        </div>
      </div>
    `).join('');
  }

  obtenerHobbyTexto(hobby) {
    const hobbies = {
      'jugar': '🎮 Jugar Videojuegos',
      'ver': '🎬 Ver películas/series',
      'música': '🎵 Escuchar Música',
      'leer': '📚 Lectura',
      'armar': '🧩 Armar Rompecabezas'
    };
    return hobbies[hobby] || hobby;
  }

  obtenerIconoMedio(tipo) {
    const iconos = {
      'imagen': '🖼️',
      'video': '🎥',
      'audio': '🎵',
      'documento': '📄'
    };
    return iconos[tipo] || '🔗';
  }

  async eliminarRegistro(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar este registro?')) {
      return;
    }

    try {
      await fetch(`${this.API_URL}/${id}`, { method: 'DELETE' });
      alert('✅ Registro eliminado');
      this.cargarRegistros();
    } catch (error) {
      alert('❌ Error al eliminar el registro');
    }
  }
}

// Funciones globales para el DOM
function addMedio() {
  const container = document.getElementById('mediosContainer');
  const nuevoMedio = document.createElement('div');
  nuevoMedio.className = 'medio-item';
  nuevoMedio.innerHTML = `
    <select class="medio-tipo" name="medioTipo">
      <option value="">Tipo de medio</option>
      <option value="imagen">🖼️ Imagen</option>
      <option value="video">🎥 Video</option>
      <option value="audio">🎵 Audio</option>
      <option value="documento">📄 Documento</option>
    </select>
    <input type="url" class="medio-url" placeholder="https://ejemplo.com" name="medioUrl">
    <select class="medio-plataforma" name="medioPlataforma">
      <option value="">Plataforma</option>
      <option value="YouTube">YouTube</option>
      <option value="Spotify">Spotify</option>
      <option value="Google Drive">Google Drive</option>
      <option value="Dropbox">Dropbox</option>
      <option value="Imgur">Imgur</option>
      <option value="Vimeo">Vimeo</option>
      <option value="SoundCloud">SoundCloud</option>
    </select>
    <input type="text" class="medio-titulo" placeholder="Título del medio" name="medioTitulo">
    <button type="button" class="btn-remove" onclick="removeMedio(this)">❌</button>
  `;
  container.appendChild(nuevoMedio);
}

function removeMedio(button) {
  button.closest('.medio-item').remove();
}

// Inicializar la aplicación
const app = new MediaDatabase();
