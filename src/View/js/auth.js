/**
 * Bout de code issu d'une template - Dessine et anime les formes géométriques dans le login 
 * https://codepen.io/m2creates/pen/EEvGgW
*/

// Initialisation de Paper.js sur la fenêtre et configuration du canvas HTML - paper.js sert à animer des vecteurs graphiques sur des canvas html
paper.install(window);
paper.setup(document.getElementById("canvas"));

// Déclaration des variables Paper.js
var canvasWidth,
  canvasHeight,
  canvasMiddleX,
  canvasMiddleY;

// Groupe pour contenir les formes
var shapeGroup = new Group();

// Tableau pour stocker les positions des formes
var positionArray = [];

// Fonction pour obtenir les dimensions du canvas
function getCanvasBounds() {
  // Obtention des dimensions actuelles du canvas
  canvasWidth = view.size.width;
  canvasHeight = view.size.height;
  canvasMiddleX = canvasWidth / 2;
  canvasMiddleY = canvasHeight / 2;

  // Définition des positions des formes
  var position1 = {
    x: (canvasMiddleX / 2) + 100,
    y: 100,
  };

  var position2 = {
    x: 200,
    y: canvasMiddleY,
  };

  var position3 = {
    x: (canvasMiddleX - 50) + (canvasMiddleX / 2),
    y: 150,
  };

  var position4 = {
    x: 0,
    y: canvasMiddleY + 100,
  };

  var position5 = {
    x: canvasWidth - 130,
    y: canvasHeight - 75,
  };

  var position6 = {
    x: canvasMiddleX + 80,
    y: canvasHeight - 50,
  };

  var position7 = {
    x: canvasWidth + 60,
    y: canvasMiddleY - 50,
  };

  var position8 = {
    x: canvasMiddleX + 100,
    y: canvasMiddleY + 100,
  };

  // Ajout des positions au tableau
  positionArray = [position3, position2, position5, position4, position1, position6, position7, position8];
};

/* ====================== *
 * Création des formes     *
 * ====================== */
function initializeShapes() {
  // Obtention des dimensions du canvas
  getCanvasBounds();

  // Données des chemins des formes
  /*
    Les lettres et les chiffres ont des significations spécifiques :

    'M' le point de départ du chemin
    'L' une ligne qui se dessine absolument, en utilisant les coordonnées absolues
    'z' la fermeture du chemin, en reliant le dernier point au premier

    'M 100 100 L 200 100 L 200 200 L 100 200 Z', // Forme 1: exemple de carré
    'M 300 300 L 400 400 L 300 400 Z', // Forme 2: exemple de triangle
  */
  var shapePathData = [
    'M0,0l64,219L29,343l535,30L478,37l-133,4L0,0z',
    'M0,65l16,138l96,107l270-2L470,0L337,4L0,65z',
    'M331.9,3.6l-331,45l231,304l445-156l-76-196l-148,54L331.9,3.6z',
    'M389,352l92-113l195-43l0,0l0,0L445,48l-80,1L122.7,0L0,275.2L162,297L389,352',
    'M 50 100 L 300 150 L 550 50 L 750 300 L 500 250 L 300 450 L 50 100',
    'M 700 350 L 500 350 L 700 500 L 400 400 L 200 450 L 250 350 L 100 300 L 150 50 L 350 100 L 250 150 L 450 150 L 400 50 L 550 150 L 350 250 L 650 150 L 650 50 L 700 150 L 600 250 L 750 250 L 650 300 L 700 350 '
  ];

  // Création de chaque forme
  for (var i = 0; i < shapePathData.length; i++) {
    var headerShape = new Path({
      strokeColor: 'rgba(36, 36, 36, 0.5)',
      strokeWidth: 2,
      parent: shapeGroup,
    });
    // Configuration des données du chemin SVG et positionnement de la forme
    headerShape.pathData = shapePathData[i];
    headerShape.scale(2);
    headerShape.position = positionArray[i];
  }
};

// Initialisation des formes
initializeShapes();

/* ====================== *
 * Animation               *
 * ====================== */
// Animation des formes en rotation
view.onFrame = function paperOnFrame(event) {
  if (event.count % 4 === 0) {
    for (var i = 0; i < shapeGroup.children.length; i++) {
      if (i % 2 === 0) {
        shapeGroup.children[i].rotate(-0.1);
      } else {
        shapeGroup.children[i].rotate(0.1);
      }
    }
  }
};

// Réorganisation des formes lors du redimensionnement de la fenêtre
view.onResize = function paperOnResize() {
  getCanvasBounds();

  for (var i = 0; i < shapeGroup.children.length; i++) {
    shapeGroup.children[i].position = positionArray[i];
  }

  // Ajustement de l'opacité en fonction de la largeur du canvas
  if (canvasWidth < 700) {
    shapeGroup.children[3].opacity = 0;
    shapeGroup.children[2].opacity = 0;
    shapeGroup.children[5].opacity = 0;
  } else {
    shapeGroup.children[3].opacity = 1;
    shapeGroup.children[2].opacity = 1;
    shapeGroup.children[5].opacity = 1;
  }
};

// Sélection des éléments HTML pour les liens d'enregistrement et de connexion
var registerLink = document.querySelector('.registerLink');
var loginLink = document.querySelector('.loginLink');

// Animation de l'élément HTML lors du clic sur le lien d'enregistrement
registerLink.addEventListener('click', function () {
  $('.animation1').animate({
    'marginLeft': '50%' // Déplacer vers la droite
  }, 0);
});

// Animation de l'élément HTML lors du clic sur le lien de connexion
loginLink.addEventListener('click', function () {
  $('.animation1').animate({
    'marginLeft': '0%' // Déplacer vers la gauche
  }, 0);
});

// Récupérer le paramètre get pour afficher l'animation à gauche ou droite après le click des submit
// J'ai suivi cette documentation pour récupérer un paramètre en get en javascript https://www.sitepoint.com/get-url-parameters-with-javascript/
const urlParams = new URLSearchParams(window.location.search);

const slide = urlParams.get('slide')

if (slide === 'right') {
  $('.animation1').css({
    'marginLeft': '50%',
    'transition': 'none'
  });

  setTimeout(() => {
    $('.animation1').css('transition', 'ease all 0.3s 0.2s');
  }, 100);
}