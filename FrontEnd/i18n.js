(function(){
  const translations = {
    es: {
      'offcanvas.title.logged': 'Bienvenido',
      'offcanvas.title.guest': 'Para continuar, registrate o inicia sesión.',
      'cta.auth': 'Registrate o Inicia Sesión',
      'nav.admin': 'Gestionar usuarios',
      'nav.logout': 'Cerrar sesión',
      'modal.title': 'Bienvenido',
      'tabs.register': 'Registrarse',
      'tabs.login': 'Iniciar sesión',
      'form.name': 'Nombre',
      'form.email': 'Correo',
      'form.password': 'Contraseña',
      'greeting.helloName': '👋 Hola, {name}',
      'btn.register': 'Registrarse',
      'btn.login': 'Iniciar sesión',
      'offcanvas.guest.desc': '¡Ganarás acceso a nuestros otros proyectos, así como también a novedades de nuestra empresa y podrás jugar a los juegos que ya tenemos!',
      'carousel.slide1.title': '¡Bienvenido a Draftosaurus!',
      'carousel.slide1.desc': 'El juego más divertido de dinosaurios.',
      'carousel.slide2.title': '¡Conoce del juego!',
      'carousel.slide2.desc': 'Tu objetivo en Draftosaurus es crear el parque de dinosaurios que atraiga a la mayor cantidad de visitantes.\nPara ello, tienes que seleccionar e intercambiar dinosaurios, y colocarlos en recintos que tienen algunas restricciones de colocación.\nCada turno, uno de los jugadores lanza el dado, lo cual limita en qué recintos pueden colocar sus dinosaurios el resto de jugadores.\nDraftosaurus es un juego de selección e intercambio rápido y ligero en el que no tienes una mano de cartas que pasar (después de seleccionar una), sino un montón de dinosaurios en la palma de tu mano.',
      'carousel.slide3.title': 'Detalles del juego',
      'carousel.slide3.desc1': 'Desarrollado por Antoine Bauza, Corentin Lebrat, Ludovic Maublanc, Theo Riviere',
      'carousel.slide3.desc2': 'Ilustrado por Jiahui Eva Gao, Roman Kucharski, Vipin Alex Jacob',
      'buttons.play': 'Jugar',
      'buttons.score': 'Puntuación',
      'buttons.visitWeb': '¡Visita nuestra web!',
      'buttons.download.es': 'Descargar PDF con instrucciones en español',
      'buttons.download.en': 'Descargar PDF con instrucciones en inglés',
  'carousel.prev': 'Anterior',
  'carousel.next': 'Siguiente',
  'datos.text': 'Ludica Studios trabaja para que los mejores juegos de mesa estén a tu alcance, ¡Sin instalaciones y sin gastos!',
  'footer.links.title': 'Links',
  'footer.links.ludica': 'Página de LudicaStudios',
  'footer.links.github': 'GitHub',
  'footer.links.instagram': 'Instagram',
  'footer.links.x': 'Cuenta de X',
  'footer.ludica.main': 'Pagina principal',
  'footer.brand.designed': 'Diseñado y construido con todo el esfuerzo de nuestro <a href="FrontEnd/ludica.php">equipo</a> y con la ayuda de nuestros <a href="https://chatgpt.com"> contribuidores</a>.',
  'footer.brand.version': 'Actualmente v1.0.0.',
  'footer.brand.updatedBy': 'Actualizado por <a href="https://github.com/sebarosales5" target="_blank" rel="noopener">sebarosales5</a>.',
      // Sumario modal
      'buttons.summary': 'Sumario',
      'modal.summary.title': 'Sumario',
      'modal.summary.objectiveTitle': 'Objetivo',
      'modal.summary.objectiveDesc': 'Elije dinosaurios y colócalos en diferentes zonas para conseguir el mayor número de puntos.',
      'modal.summary.gameplayTitle': 'Jugabilidad',
      'modal.summary.gameplayDesc': 'Se elige el lado del tablero: verano (nivel inicial) o invierno (nivel experto)\n El juego consta de 2 rondas (4 para 2 jugadores)\nCada jugador saca 6 dinosaurios de la bolsa.\n  El jugador con el dado de colocación lo lanza.\n  Cada jugador elige un dinosaurio y lo coloca en su zoo al mismo tiempo, siguiendo las reglas del dado de colocación (excepto el rodillo, que puede colocarse en cualquier lugar).\n  A continuación, cada jugador descarta uno de los dinosaurios restantes (puedes imaginar que lo han prestado a un zoológico de mascotas en el extranjero)\n  Cada jugador pasa su bolsa de dinosaurios y su dado de colocación (si lo tenía) a su izquierda.\n Repite hasta que todos los dinosaurios estén colocados.\n Después de 2 rondas, se procede a la puntuación.\n Al final del juego habrán colocado 12 dinosaurios: 6 en la ronda 1, 6 en la ronda 2.\n En caso de empate, gana el jugador que tenga menos T-Rex. Si siguen empatados, los jugadores se reparten la victoria.\n Hay 6 especies de dinosaurios, distribuidos de la siguiente manera:\n 5p: 60 dinos. 10 x 6 especies diferentes\n 4p: 48 dinos. 8 x 6 especies diferentes\n 3p: 36 dinos. 6 x 6 especies diferentes\n 2p: 48 dinos. 8 x 6 especies diferentes',
      'modal.summary.dieTitle': 'Dado de colocación',
      'modal.summary.dieDesc': 'Pastizales/bosques: Debes colocar el dinosaurio en una zona de pradera(marrón)/bosque(verde).\n Patio de comidas/Café: Debes colocar el dinosaurio en un área a la izquierda/derecha.\nCorral vacío: Debes colocar al dinosaurio en un corral vacío.\n Cuidado con el T-Rex: Debes colocar al dinosaurio en un corral sin T-Rex (rojo).',
      'modal.summary.boardTitle': 'Tablero',
      'modal.summary.boardDesc': 'Cada zoológico tiene 6 corrales y un río.\nRío: No se trata como un corral. Cada dinosaurio en él proporciona 1 punto.\nT-Rex: Cada corral con al menos 1 T-Rex en él aporta 1 punto extra.',
      'common.close': 'Cerrar',
      // Accordion
      'accordion.one.title': 'Objetivo',
      'accordion.one.body': '<strong>En Draftosaurus,</strong> Elegir dinosaurios y colocarlos en diferentes zonas para conseguir el mayor número de puntos es la clave de la victoria.',
      'accordion.two.title': 'Dinosaurios',
      'accordion.two.body': '<strong>Hay 6 tipos diferentes de dinosaurios.</strong> Dependiendo de la cantidad de jugadores, se aumenta o resta el número de dinosaurios que existirán dentro de la bolsa.',
      'accordion.three.title': 'Las zonas del zoo y el dado de colocación',
      'accordion.three.body': '<strong>Son la clave para aumentar los puntos.</strong> Factores como la cantidad de T-Rex, la zona que habilite el dado y el dinosaurio que tengas disponible para colocar, permitirán al jugador alcanzar la mayor cantidad de puntos posibles.'
      ,
      // Historial
      'nav.history': 'Historial de partidas',
      'nav.back': 'Volver',
      'history.title': 'Historial de partidas',
      'history.empty': 'Todavía no registraste partidas.',
      'history.matchIdPrefix': 'Partida #',
      'history.winners': 'Ganador(es):',
      'history.player': 'Jugador',
      'history.points': 'Puntos',
      'history.you': 'Tú',
      'history.winner': 'Ganador'
    },
    en: {
      'offcanvas.title.logged': 'Welcome',
      'offcanvas.title.guest': 'To continue, sign up or log in.',
      'cta.auth': 'Sign up or Log in',
      'nav.admin': 'Manage users',
      'nav.logout': 'Log out',
      'modal.title': 'Welcome',
      'tabs.register': 'Sign up',
      'tabs.login': 'Log in',
      'form.name': 'Name',
      'form.email': 'Email',
      'form.password': 'Password',
      'greeting.helloName': '👋 Hi, {name}',
      'btn.register': 'Sign up',
      'btn.login': 'Log in',
      'offcanvas.guest.desc': 'You\'ll gain access to our other projects, company news, and you\'ll be able to play the games we\'ve already published!',
      'carousel.slide1.title': 'Welcome to Draftosaurus!',
      'carousel.slide1.desc': 'The most fun dinosaur game.',
      'carousel.slide2.title': 'Learn about the game!',
      'carousel.slide2.desc': 'Your goal in Draftosaurus is to create the dinosaur park that attracts the most visitors.\nTo do so, you must select and exchange dinosaurs, and place them in enclosures that have some placement restrictions.\nEach turn, one of the players rolls the die, which limits in which enclosures the other players can place their dinosaurs.\nDraftosaurus is a fast and light drafting game where you don\'t pass a hand of cards (after selecting one), but a handful of dinosaurs.',
      'carousel.slide3.title': 'Game details',
      'carousel.slide3.desc1': 'Developed by Antoine Bauza, Corentin Lebrat, Ludovic Maublanc, Theo Riviere',
      'carousel.slide3.desc2': 'Illustrated by Jiahui Eva Gao, Roman Kucharski, Vipin Alex Jacob',
      'buttons.play': 'Play',
      'buttons.score': 'Score',
      'buttons.visitWeb': 'Visit our website!',
      'buttons.download.es': 'Download PDF with instructions in Spanish',
      'buttons.download.en': 'Download PDF with instructions in English',
  'carousel.prev': 'Previous',
  'carousel.next': 'Next',
  'datos.text': 'Ludica Studios works to bring the best board games to you, with no installs and no costs!',
  'footer.links.title': 'Links',
  'footer.links.ludica': 'LudicaStudios page',
  'footer.links.github': 'GitHub',
  'footer.links.instagram': 'Instagram',
  'footer.links.x': 'X account',
  'footer.ludica.main': 'Home page',
  'footer.brand.designed': 'Designed and built with all the effort of our <a href="FrontEnd/ludica.php">team</a> and with the help of our <a href="https://chatgpt.com"> contributors</a>.',
  'footer.brand.version': 'Currently v1.0.0.',
  'footer.brand.updatedBy': 'Updated by <a href="https://github.com/sebarosales5" target="_blank" rel="noopener">sebarosales5</a>.',
      // Summary modal
      'buttons.summary': 'Summary',
      'modal.summary.title': 'Summary',
      'modal.summary.objectiveTitle': 'Objective',
      'modal.summary.objectiveDesc': 'Choose dinosaurs and place them in different zones to score the most points.',
      'modal.summary.gameplayTitle': 'Gameplay',
      'modal.summary.gameplayDesc': 'Choose the board side: summer (beginner) or winter (expert).\nThe game has 2 rounds (4 for 2 players).\nEach player draws 6 dinosaurs from the bag.\nThe player with the placement die rolls it.\nEach player chooses a dinosaur and places it in their zoo at the same time, following the placement die rules (except the roller, which can be placed anywhere).\nThen each player discards one of the remaining dinosaurs (imagine it was lent to a petting zoo abroad).\nEach player passes their bag of dinosaurs and the placement die (if they had it) to their left.\nRepeat until all dinosaurs are placed.\nAfter 2 rounds, proceed to scoring.\nBy the end, each player will have placed 12 dinosaurs: 6 in round 1, 6 in round 2.\nIn case of a tie, the player with fewer T-Rex wins. If still tied, players share victory.\nThere are 6 species of dinosaurs, distributed as follows:\n5p: 60 dinos. 10 x 6 different species\n4p: 48 dinos. 8 x 6 different species\n3p: 36 dinos. 6 x 6 different species\n2p: 48 dinos. 8 x 6 different species',
      'modal.summary.dieTitle': 'Placement die',
      'modal.summary.dieDesc': 'Pastures/Forests: Place the dinosaur in a pasture (brown)/forest (green).\nFood court/Café: Place the dinosaur in an area on the left/right.\nEmpty pen: Place the dinosaur in an empty pen.\nBeware of the T-Rex: Place the dinosaur in a pen without a T-Rex (red).',
      'modal.summary.boardTitle': 'Board',
      'modal.summary.boardDesc': 'Each zoo has 6 pens and a river.\nRiver: Not treated as a pen. Each dinosaur in it provides 1 point.\nT-Rex: Each pen with at least 1 T-Rex in it provides 1 extra point.',
      'common.close': 'Close',
      // Accordion
      'accordion.one.title': 'Objective',
      'accordion.one.body': '<strong>In Draftosaurus,</strong> choosing dinosaurs and placing them in different zones to get the most points is the key to victory.',
      'accordion.two.title': 'Dinosaurs',
      'accordion.two.body': '<strong>There are 6 different types of dinosaurs.</strong> Depending on the number of players, the number of dinosaurs in the bag increases or decreases.',
      'accordion.three.title': 'Zoo zones and the placement die',
      'accordion.three.body': '<strong>They are the key to increasing points.</strong> Factors such as the number of T-Rex, the zone enabled by the die, and the dinosaur available to place will allow the player to reach the highest possible score.'
      ,
      // History
      'nav.history': 'Match history',
      'nav.back': 'Back',
      'history.title': 'Match history',
      'history.empty': "You haven't recorded any matches yet.",
      'history.matchIdPrefix': 'Match #',
      'history.winners': 'Winner(s):',
      'history.player': 'Player',
      'history.points': 'Points',
      'history.you': 'You',
      'history.winner': 'Winner'
    }
  };

  function t(key, lang, params={}){
    const dict = translations[lang] || translations.es;
    let str = dict[key] || key;
    Object.keys(params).forEach(p=>{
      str = str.replace(new RegExp('\\{' + p + '\\}', 'g'), params[p]);
    });
    return str;
  }

  function translatePage(lang){
    document.documentElement.setAttribute('lang', lang);
    const nodes = document.querySelectorAll('[data-i18n]');
    nodes.forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (!key) return;
      const params = {};
      // Common param example: name
      const nameParam = el.getAttribute('data-i18n-name');
      if (nameParam) params.name = nameParam;
      const value = t(key, lang, params);
      if (el.hasAttribute('data-i18n-html')) {
        el.innerHTML = value.replace(/\n/g, '<br>');
      } else {
        el.textContent = value;
      }
    });

    // Update toggle label to show target language
    const toggle = document.getElementById('langToggle');
    if (toggle) {
      toggle.textContent = lang === 'es' ? 'EN' : 'ES';
    }

    try { localStorage.setItem('lang', lang); } catch(e) {}
  }

  window.__i18n = { t, translatePage };
})();
