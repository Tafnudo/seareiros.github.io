function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('time').textContent = `${hours}:${minutes}`;
}

function fetchWeather() {
    const apiKey = 'b5909a832e37482aa03171115243008';
    const city = 'Sorocaba';
    const url = `https://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${city}&lang=pt`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const weather = data.current.condition.text;
            const temp = Math.round(data.current.temp_c);
            document.getElementById('weather').textContent = `${weather}, ${temp}°C`;
            updateImageBasedOnWeather(data.current.condition.text);
        })
        .catch(error => console.error('Erro ao obter dados do clima:', error));
}

let images = [];
let currentImageIndex = 0;

function updateImageBasedOnWeather(weatherCondition) {
    images = [
        localStorage.getItem(`image-${weatherCondition}`) || 'images/default1.jpg',
        localStorage.getItem(`image-${weatherCondition}`) || 'images/default2.jpg',
        localStorage.getItem(`image-${weatherCondition}`) || 'images/default3.jpg',
    ];
    changeImage();
}

function changeImage() {
    const imageDisplay = document.getElementById('image-display');
    imageDisplay.innerHTML = `<img src="${images[currentImageIndex]}" alt="Clima">`;
    currentImageIndex = (currentImageIndex + 1) % images.length;
}

setInterval(changeImage, 5000); // Troca de imagem a cada 5 segundos
setInterval(updateTime, 1000);
fetchWeather();

// Modo Tela Cheia
const fullscreenBtn = document.getElementById('fullscreen-btn');
fullscreenBtn.addEventListener('click', function() {
    if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
    } else if (document.documentElement.webkitRequestFullscreen) { // Safari
        document.documentElement.webkitRequestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) { // IE11
        document.documentElement.msRequestFullscreen();
    }
    fullscreenBtn.style.display = 'none';
});
