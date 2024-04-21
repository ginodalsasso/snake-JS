<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake JS</title>
    <style>
        canvas {
            border: 2px solid;
        }
    </style>
</head>

<body>
    <canvas width="400" height="400"></canvas>

    <script>
        // Sélection du canvas et obtention du contexte 2D
        const canvas = document.querySelector("canvas");
        //contexte de la fenêtre dans laquelle nous allons interagir en 2d du coup
        const context = canvas.getContext("2d");

        // Taille d'une "case" dans le jeu
        let box = 20;

        //initialisation du serpent
        let snake = [];

        // 0 soit la tête du serpent situé au centre sur l'axe x et y (10 x 20 = 200 soit la moitié de 400px du canva)
        snake[0] = {
            x: 10 * box,
            y: 10 * box
        };

        // Position de la nourriture, générée aléatoirement
        let food = {
            x: Math.floor(Math.random() * 15 + 1) * box,
            y: Math.floor(Math.random() * 15 + 1) * box
        }

        let score = 0; // Score du joueur

        // Variable pour stocker la direction du serpent
        let d

        document.addEventListener('keydown', direction);

        function direction(event) {
            // Déterminer la direction en fonction de la touche pressée
            let key = event.keyCode;
            if (key == 37 && d != "RIGHT") {
                d = "LEFT";
            } else if (key == 38 && d != 'DOWN') {
                d = "UP";
            } else if (key == 39 && d != 'LEFT') {
                d = "RIGHT";
            } else if (key == 40 && d != 'UP') {
                d = "DOWN";
            }
        }

        function draw() {
            context.clearRect(0, 0, 400, 400);
            // Dessine le serpent
            for (let i = 0; i < snake.length; i++) {
                context.fillStyle = (i == 0) ? "green" : "white"
                context.fillRect(snake[i].x, snake[i].y, box, box)
                context.strokeStyle = "red"
                context.strokeRect(snake[i].x, snake[i].y, box, box)
            }
            // Dessine la nourriture
            context.fillStyle = "orange";
            context.fillRect(food.x, food.y, box, box);

            // Met à jour la position du serpent en fonction de la direction
            let snakeX = snake[0].x
            let snakeY = snake[0].y
            //on décrémente ou incrémente d'une box(20px) à chaque action
            if (d == "LEFT") snakeX -= box;
            if (d == "UP") snakeY -= box;
            if (d == "RIGHT") snakeX += box;
            if (d == "DOWN") snakeY += box;
            // Vérifie si le serpent a mangé la nourriture
            if (snakeX == food.x && snakeY == food.y) {
                score++;
                // Génère une nouvelle position pour la nourriture
                food = {
                    x: Math.floor(Math.random() * 15 + 1) * box,
                    y: Math.floor(Math.random() * 15 + 1) * box
                }
            } else {
                //si le serpent n'a pas mangé, enlève la derniere partie
                snake.pop();
            }

            // Nouvelle tête du serpent
            let newHead = {
                x: snakeX,
                y: snakeY
            }

            // Vérifie les collisions avec les parois ou avec le serpent lui-même
            if (snakeX < 0 || snakeY < 0 || snakeX > 19 * box || snakeY > 19 * box || collision(newHead, snake)) {
                //stop le jeu si le serpent touche une paroi du canva ou lui même
                clearInterval(game);
                alert("Perdu !")
            }

            // Ajoute la nouvelle tête du serpent
            snake.unshift(newHead);

            // Affiche le score
            context.fillStyle = "red"
            context.font = "30px Arial"
            context.fillText(score, 1 * box, 2 * box)
        }

        // Vérifie les collisions avec le serpent lui-même
        function collision(head, array) {
            for (let g = 0; g < array.lenght; g++) {
                //si la tête touche un élément du corps alors return true
                if (head.x == array[g].x && head.y == array[g].y) {
                    return true;
                }
            }
            return false;
        }

        let game = setInterval(draw, 100)
    </script>
</body>

</html>