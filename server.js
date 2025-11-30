const express = require('express');
const { Pool } = require('pg');
const cors = require('cors');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

// Conexión a PostgreSQL
const pool = new Pool({
  connectionString: process.env.DATABASE_URL,
  ssl: process.env.NODE_ENV === 'production' ? { rejectUnauthorized: false } : false
});

// Crear tabla si no existe
const initDatabase = async () => {
  try {
    await pool.query(`
      CREATE TABLE IF NOT EXISTS registros (
        id SERIAL PRIMARY KEY,
        apellidos VARCHAR(255) NOT NULL,
        primer_nombre VARCHAR(255) NOT NULL,
        segundo_nombre VARCHAR(255),
        detalles TEXT NOT NULL,
        hobbies VARCHAR(100) NOT NULL,
        seguro BOOLEAN DEFAULT false,
        auto BOOLEAN DEFAULT false,
        acceso BOOLEAN DEFAULT false,
        bicicleta BOOLEAN DEFAULT false,
        herramientas BOOLEAN DEFAULT false,
        medios_digitales JSONB DEFAULT '[]',
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `);
    console.log('✅ Tabla de registros creada/verificada');
  } catch (error) {
    console.error('❌ Error creando tabla:', error);
  }
};

initDatabase();

// Rutas de la API
app.get('/api/registros', async (req, res) => {
  try {
    const result = await pool.query('SELECT * FROM registros ORDER BY fecha_creacion DESC');
    res.json(result.rows);
  } catch (error) {
    console.error('Error en GET /api/registros:', error);
    res.status(500).json({ error: 'Error al obtener registros' });
  }
});

app.post('/api/registros', async (req, res) => {
  try {
    const {
      apellidos,
      primerNombre,
      segundoNombre,
      detalles,
      hobbies,
      seguro,
      auto,
      acceso,
      bicicleta,
      herramientas,
      mediosDigitales
    } = req.body;

    const query = `
      INSERT INTO registros 
      (apellidos, primer_nombre, segundo_nombre, detalles, hobbies, seguro, auto, acceso, bicicleta, herramientas, medios_digitales)
      VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)
      RETURNING *
    `;
    
    const values = [
      apellidos,
      primerNombre,
      segundoNombre || '',
      detalles,
      hobbies,
      seguro || false,
      auto || false,
      acceso || false,
      bicicleta || false,
      herramientas || false,
      JSON.stringify(mediosDigitales || [])
    ];

    const result = await pool.query(query, values);
    res.status(201).json(result.rows[0]);
  } catch (error) {
    console.error('Error en POST /api/registros:', error);
    res.status(400).json({ error: 'Error al crear registro' });
  }
});

app.delete('/api/registros/:id', async (req, res) => {
  try {
    await pool.query('DELETE FROM registros WHERE id = $1', [req.params.id]);
    res.json({ message: 'Registro eliminado' });
  } catch (error) {
    console.error('Error en DELETE /api/registros:', error);
    res.status(500).json({ error: 'Error al eliminar registro' });
  }
});

// Ruta de salud
app.get('/api/health', (req, res) => {
  res.json({ 
    status: 'OK', 
    message: 'Servidor funcionando correctamente',
    timestamp: new Date().toISOString()
  });
});

// Servir frontend
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

app.listen(PORT, '0.0.0.0', () => {
  console.log(`🚀 Servidor corriendo en puerto ${PORT}`);
  console.log(`📊 Entorno: ${process.env.NODE_ENV || 'development'}`);
});
