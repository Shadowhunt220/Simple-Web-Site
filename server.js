const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const path = require('path');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware - CORREGIDO para Render
app.use(cors({
  origin: process.env.NODE_ENV === 'production' 
    ? ['https://simple-web-site.onrender.com', 'http://localhost:3000'] 
    : '*'
}));
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));

// Servir archivos estáticos - RUTA CORREGIDA para Render
app.use(express.static(path.join(__dirname, 'frontend')));

// Conexión a MongoDB
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/mediadb', {
  useNewUrlParser: true,
  useUnifiedTopology: true,
})
.then(() => console.log('✅ Conectado a MongoDB'))
.catch(err => {
  console.error('❌ Error conectando a MongoDB:', err);
  process.exit(1);
});

// Esquema de la base de datos
const registroSchema = new mongoose.Schema({
  apellidos: String,
  primerNombre: String,
  segundoNombre: String,
  detalles: String,
  hobbies: String,
  seguro: Boolean,
  auto: Boolean,
  acceso: Boolean,
  bicicleta: Boolean,
  herramientas: Boolean,
  mediosDigitales: [{
    tipo: String,
    url: String,
    plataforma: String,
    titulo: String
  }],
  fechaCreacion: { type: Date, default: Date.now }
});

const Registro = mongoose.model('Registro', registroSchema);

// Rutas de la API (mantener igual)
app.get('/api/registros', async (req, res) => {
  try {
    const registros = await Registro.find().sort({ fechaCreacion: -1 });
    res.json(registros);
  } catch (error) {
    console.error('Error en GET /api/registros:', error);
    res.status(500).json({ error: 'Error al obtener registros' });
  }
});

app.post('/api/registros', async (req, res) => {
  try {
    const nuevoRegistro = new Registro(req.body);
    await nuevoRegistro.save();
    res.status(201).json(nuevoRegistro);
  } catch (error) {
    console.error('Error en POST /api/registros:', error);
    res.status(400).json({ error: 'Error al crear registro' });
  }
});

app.delete('/api/registros/:id', async (req, res) => {
  try {
    await Registro.findByIdAndDelete(req.params.id);
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

// Servir frontend - RUTA CORREGIDA
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'frontend/index.html'));
});

// Manejo de errores global
app.use((err, req, res, next) => {
  console.error('Error no manejado:', err);
  res.status(500).json({ error: 'Error interno del servidor' });
});

app.listen(PORT, '0.0.0.0', () => {
  console.log(`🚀 Servidor corriendo en puerto ${PORT}`);
  console.log(`📊 Entorno: ${process.env.NODE_ENV || 'development'}`);
});

