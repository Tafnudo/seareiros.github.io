<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Indoor - Seareiros da Boa Vontade</title>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            color: #333;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
        }

        #slideshow {
            position: relative;
            width: 100%;
            height: calc(100% - 100px);
            overflow: hidden;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
            z-index: 1;
        }

        #barra-inferior {
            background-color: #333;
            color: #ffffff;
            text-align: center;
            padding: 10px 20px;
            position: relative;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        #hora {
            font-size: 2rem;
            margin: 0 10px;
            flex: 1 1 100px;
            text-align: center;
        }

        #avisos {
            font-size: 1.5rem;
            margin: 0 10px;
            flex: 2 1 200px;
            text-align: center;
        }

        #fullscreen-btn {
            font-size: 1.5rem;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            transition: background-color 0.3s;
        }

        #fullscreen-btn:hover {
            background-color: #45a049;
        }

        @media (max-width: 600px) {
            #barra-inferior {
                flex-direction: column;
                padding: 10px;
            }

            #hora, #avisos {
                flex: none;
                margin: 5px 0;
            }

            #fullscreen-btn {
                bottom: 10px;
                right: 10px;
                padding: 8px 16px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div id="slideshow">
        <?php
        // Obtém todas as imagens do diretório 'imagens'
        $dir = 'imagens/';
        $images = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // Se houver imagens, exibe-as
        if (count($images) > 0):
            foreach ($images as $index => $image):
                $activeClass = $index === 0 ? 'active' : '';
                echo "<img src='$image' class='slide $activeClass' alt='Slide $index'>";
            endforeach;
        else:
            echo "<div id='no-images-message'>Nenhuma imagem disponível.</div>";
        endif;
        ?>
    </div>
    <div id="barra-inferior">
        <div id="hora">--:--</div>
        <div id="avisos">
            <?php
            // Carrega o aviso do arquivo config.json
            $configFile = 'config.json';
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true);
                echo $config['aviso'] ?? 'Nenhum aviso disponível.';
            } else {
                echo 'Arquivo de configuração não encontrado.';
            }
            ?>
        </div>
    </div>
    <button id="fullscreen-btn" aria-label="Ativar Tela Cheia">Tela Cheia</button>

    <script>
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        const slideInterval = 5000;

        function mostrarSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        function atualizarHora() {
            const agora = new Date();
            const hora = agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('hora').innerText = hora;
        }

        function ativarTelaCheia() {
            const docElm = document.documentElement;
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen();
            } else if (docElm.webkitRequestFullscreen) {
                docElm.webkitRequestFullscreen();
            } else if (docElm.msRequestFullscreen) {
                docElm.msRequestFullscreen();
            }
        }

        document.getElementById('fullscreen-btn').addEventListener('click', () => {
            ativarTelaCheia();
            document.getElementById('fullscreen-btn').style.display = 'none';
        });

        setInterval(mostrarSlide, slideInterval);
        setInterval(atualizarHora, 1000);
        atualizarHora();
    </script>
</body>
</html>

