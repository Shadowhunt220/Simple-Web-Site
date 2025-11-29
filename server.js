const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const path = require('path');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.static(path.join(__dirname, '../frontend')));

// Conexión a MongoDB
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/mediadb', {
  useNewUrlParser: true,
  useUnifiedTopology: true,
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
    tipo: String, // 'imagen', 'video', 'audio', 'documento'
    url: String,
    plataforma: String, // 'YouTube', 'Spotify', 'Google Drive', etc.
    titulo: String
  }],
  fechaCreacion: { type: Date, default: Date.now }
});

const Registro = mongoose.model('Registro', registroSchema);

// Rutas de la API
app.get('/api/registros', async (req, res) => {
  try {
    const registros = await Registro.find().sort({ fechaCreacion: -1 });
    res.json(registros);
  } catch (error) {
    res.status(500).json({ error: 'Error al obtener registros' });
  }
});

app.post('/api/registros', async (req, res) => {
  try {
    const nuevoRegistro = new Registro(req.body);
    await nuevoRegistro.save();
    res.status(201).json(nuevoRegistro);
  } catch (error) {
    res.status(400).json({ error: 'Error al crear registro' });
  }
});

app.delete('/api/registros/:id', async (req, res) => {
  try {
    await Registro.findByIdAndDelete(req.params.id);
    res.json({ message: 'Registro eliminado' });
  } catch (error) {
    res.status(500).json({ error: 'Error al eliminar registro' });
  }
});

// Servir frontend
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, '../frontend/index.html'));
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en puerto ${PORT}`);
});
