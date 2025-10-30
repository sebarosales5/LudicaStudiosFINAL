// Lista de tipos de dinosaurios
const DINO_TYPES = [
  { key: 'trex', img: '../Otros/fotos/dino_rojo.png' },
  { key: 'triceratops', img: '../Otros/fotos/dino_amarillo.png' },
  { key: 'stegosaurus', img: '../Otros/fotos/dino_azul.png' },
  { key: 'brontosaurus', img: '../Otros/fotos/dino_morado.png' },
  { key: 'parasaurus', img: '../Otros/fotos/dino_verde.png' },
  { key: 'spinosaurus', img: '../Otros/fotos/dino_naranja.png' }
];

let dinoCounter = 0;

// Renderizar pool de dinosaurios - siempre uno de cada tipo
function renderDinoPool() {
  const container = document.getElementById('player0-dinoPool');
  container.innerHTML = '';

  // Siempre mostrar uno de cada tipo
  DINO_TYPES.forEach((dino, idx) => {
    const wrapper = document.createElement('div');
    wrapper.className = 'dino';
    wrapper.setAttribute('draggable', 'true');
    wrapper.id = `dino-source-${dino.key}`;
    wrapper.dataset.dinoType = dino.key;
    
    const img = document.createElement('img');
    img.src = dino.img;
    img.alt = dino.key;
    img.className = 'img-fluid';
    wrapper.appendChild(img);
    container.appendChild(wrapper);

    wrapper.addEventListener('dragstart', e => {
      // Guardar el tipo de dinosaurio que se está arrastrando
      e.dataTransfer.setData('text/plain', dino.key);
      e.dataTransfer.setData('source', 'pool');
      wrapper.classList.add('dragging');
    });

    wrapper.addEventListener('dragend', () => {
      wrapper.classList.remove('dragging');
    });
  });
}

// Configurar zonas de drop
function setupZones() {
  const zonas = document.querySelectorAll('.zona');
  
  zonas.forEach(zona => {
    zona.addEventListener('dragover', e => {
      e.preventDefault();
      
      // Verificar restricciones de capacidad
      const isSingleOccupancy = zona.id.endsWith('-zona2') || zona.id.endsWith('-zona3');
      const currentCount = zona.querySelectorAll('.dino').length;
      const isPraderaFull = zona.id.endsWith('-zona1') && currentCount >= 6;
      const isMontanaFull = zona.id.endsWith('-zona4') && currentCount >= 3;
      const isCostaFull = zona.id.endsWith('-zona6') && currentCount >= 6;

      if ((isSingleOccupancy && currentCount > 0) || isPraderaFull || isMontanaFull || isCostaFull) {
        e.dataTransfer.dropEffect = 'none';
        zona.classList.add('zona-invalida');
      } else {
        e.dataTransfer.dropEffect = 'move';
        zona.classList.add('zona-valida');
      }
    });

    zona.addEventListener('dragenter', e => {
      e.preventDefault();
    });

    zona.addEventListener('dragleave', () => {
      zona.classList.remove('zona-valida');
      zona.classList.remove('zona-invalida');
    });

    zona.addEventListener('drop', e => {
      e.preventDefault();
      
      // Verificar restricciones
      const isSingleOccupancy = zona.id.endsWith('-zona2') || zona.id.endsWith('-zona3');
      const currentCount = zona.querySelectorAll('.dino').length;
      const isPraderaFull = zona.id.endsWith('-zona1') && currentCount >= 6;
      const isMontanaFull = zona.id.endsWith('-zona4') && currentCount >= 3;
      const isCostaFull = zona.id.endsWith('-zona6') && currentCount >= 6;

      if ((isSingleOccupancy && currentCount > 0) || isPraderaFull || isMontanaFull || isCostaFull) {
        zona.classList.remove('zona-valida', 'zona-invalida');
        return;
      }

      const dinoKey = e.dataTransfer.getData('text/plain');
      const source = e.dataTransfer.getData('source');
      
      // Buscar el tipo de dinosaurio
      const dinoType = DINO_TYPES.find(d => d.key === dinoKey);
      if (!dinoType && source === 'pool') return;

      let dinoElement;
      
      if (source === 'pool') {
        // Crear nuevo dinosaurio desde el pool (infinito)
        dinoElement = document.createElement('div');
        dinoElement.className = 'dino placed';
        dinoElement.setAttribute('draggable', 'true');
        dinoElement.id = `dino-placed-${Date.now()}-${Math.random()}`;
        dinoElement.dataset.dinoType = dinoKey;
        
        const img = document.createElement('img');
        img.src = dinoType.img;
        img.alt = dinoType.key;
        img.className = 'img-fluid';
        dinoElement.appendChild(img);
      } else {
        // Viene de otra zona del tablero, mover el existente
        dinoElement = document.getElementById(dinoKey);
        if (!dinoElement) return;
        dinoElement.remove(); // Remover de zona anterior
      }

      // Posicionar en la zona
      if (getComputedStyle(zona).position === 'static') zona.style.position = 'relative';
      zona.appendChild(dinoElement);
      
      const zonaRect = zona.getBoundingClientRect();
      const dinoRect = dinoElement.getBoundingClientRect();
      const dinoWidth = dinoRect.width;
      const dinoHeight = dinoRect.height;
      
      let x = e.clientX - zonaRect.left - dinoWidth / 2;
      let y = e.clientY - zonaRect.top - dinoHeight / 2;
      
      x = Math.max(0, Math.min(x, zona.clientWidth - dinoWidth));
      y = Math.max(0, Math.min(y, zona.clientHeight - dinoHeight));
      
      dinoElement.style.position = 'absolute';
      dinoElement.style.left = x + 'px';
      dinoElement.style.top = y + 'px';

      zona.classList.remove('zona-valida');

      // Configurar drag para el elemento en el tablero
      dinoElement.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', this.id);
        e.dataTransfer.setData('source', 'board');
        this.classList.add('dragging');
      });

      dinoElement.addEventListener('dragend', function() {
        this.classList.remove('dragging');
      });

      // Actualizar estadísticas y puntajes
      updatePlayerStats();
      computeScoresForPlayer();
    });
  });
}

// Actualizar estadísticas
function updatePlayerStats() {
  const playerBoard = document.querySelector('.mapa[data-player-id="0"]');
  const dinosPlaced = playerBoard.querySelectorAll('.zona .dino').length;
  document.getElementById('player0-dinos-count').textContent = dinosPlaced;
}

// ---------------------- Funciones de Puntuación ----------------------

function calculateLagoScore(zonaElem) {
  if (!zonaElem) return 0;
  const dinos = zonaElem.querySelectorAll('.dino');
  return dinos.length;
}

function calculateMontanaScore(zonaElem) {
  if (!zonaElem) return 0;
  const dinos = zonaElem.querySelectorAll('.dino');
  return dinos.length === 3 ? 7 : 0;
}

function calculateCostaScore(zonaElem) {
  if (!zonaElem) return 0;
  const dinos = zonaElem.querySelectorAll('.dino');
  
  const species = new Set();
  dinos.forEach(d => {
    const img = d.querySelector('img');
    const key = img ? img.alt : 'unknown';
    species.add(key);
  });
  
  const speciesCount = species.size;
  const scoreTable = { 1: 1, 2: 3, 3: 6, 4: 10, 5: 15, 6: 21 };
  return scoreTable[speciesCount] || 0;
}

function calculateDesiertoScore(zonaElem) {
  if (!zonaElem) return 0;
  const dinos = zonaElem.querySelectorAll('.dino');
  
  const counts = {};
  dinos.forEach(d => {
    const img = d.querySelector('img');
    const key = img ? img.alt : 'unknown';
    counts[key] = (counts[key] || 0) + 1;
  });
  
  let totalScore = 0;
  Object.values(counts).forEach(count => {
    const pairs = Math.floor(count / 2);
    totalScore += pairs * 5;
  });
  
  return totalScore;
}

function calculateBosqueScore(zonaElem) {
  if (!zonaElem) return 0;
  const dino = zonaElem.querySelector('.dino');
  if (!dino) return 0;
  
  const img = dino.querySelector('img');
  const key = img ? img.alt : 'unknown';

  // Revisar otras zonas
  const otherZonaIds = ['player0-zona1', 'player0-zona3', 'player0-zona4', 'player0-zona5', 'player0-zona6', 'player0-zona7'];
  for (const zid of otherZonaIds) {
    const z = document.getElementById(zid);
    if (!z) continue;
    const dinos = z.querySelectorAll('.dino');
    for (const d of dinos) {
      const i = d.querySelector('img');
      const k = i ? i.alt : 'unknown';
      if (k === key) return 0;
    }
  }
  
  return 7;
}

function calculateRioScore(zonaElem) {
  if (!zonaElem) return 0;
  const dino = zonaElem.querySelector('.dino');
  if (!dino) return 0;
  
  const img = dino.querySelector('img');
  const key = img ? img.alt : 'unknown';

  // En calculadora solo hay un jugador, siempre suma 7
  return 7;
}

function calculatePraderaScore(zonaElem) {
  if (!zonaElem) return 0;
  const dinos = zonaElem.querySelectorAll('.dino');
  const counts = {};
  
  dinos.forEach(d => {
    const img = d.querySelector('img');
    const key = img ? img.alt : 'unknown';
    counts[key] = (counts[key] || 0) + 1;
  });

  if (Object.keys(counts).length === 0) return 0;

  let maxCount = 0;
  Object.values(counts).forEach(c => { if (c > maxCount) maxCount = c; });

  const scoreTable = { 1: 2, 2: 4, 3: 8, 4: 12, 5: 18, 6: 24 };
  return scoreTable[maxCount] || 0;
}

// Calcular todas las puntuaciones
function computeScoresForPlayer() {
  const scores = {};
  
  scores.pradera = calculatePraderaScore(document.getElementById('player0-zona1'));
  scores.bosque = calculateBosqueScore(document.getElementById('player0-zona2'));
  scores.rio = calculateRioScore(document.getElementById('player0-zona3'));
  scores.montana = calculateMontanaScore(document.getElementById('player0-zona4'));
  scores.desierto = calculateDesiertoScore(document.getElementById('player0-zona5'));
  scores.costa = calculateCostaScore(document.getElementById('player0-zona6'));
  scores.lago = calculateLagoScore(document.getElementById('player0-zona7'));

  scores.total = Object.values(scores).reduce((s, v) => s + (v || 0), 0);

  // Actualizar UI
  document.getElementById('player0-puntuacion-pradera').textContent = scores.pradera;
  document.getElementById('player0-puntuacion-bosque').textContent = scores.bosque;
  document.getElementById('player0-puntuacion-rio').textContent = scores.rio;
  document.getElementById('player0-puntuacion-montana').textContent = scores.montana;
  document.getElementById('player0-puntuacion-desierto').textContent = scores.desierto;
  document.getElementById('player0-puntuacion-costa').textContent = scores.costa;
  document.getElementById('player0-puntuacion-lago').textContent = scores.lago;
  document.getElementById('player0-puntuacion').textContent = scores.total;

  console.log('Puntuaciones:', scores);
  return scores;
}

// Limpiar tablero
function limpiarTablero() {
  const zonas = document.querySelectorAll('.zona');
  zonas.forEach(zona => {
    zona.querySelectorAll('.dino').forEach(dino => dino.remove());
  });
  updatePlayerStats();
  computeScoresForPlayer();
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
  renderDinoPool();
  setupZones();
  
  document.getElementById('btn-limpiar').addEventListener('click', limpiarTablero);
  
  // Remover el botón de agregar dinosaurios ya que son infinitos
  const btnAgregar = document.getElementById('btn-agregar-dinos');
  if (btnAgregar) btnAgregar.style.display = 'none';
});
