function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('time').textContent = `${hours}:${minutes}`;
}

function fetchWeather() {
    const apiKey = 'SUA_API_KEY';
    const city = 'SUA_CIDADE';
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=pt_br`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const weather = data.weather[0].description;
            const temp = Math.round(data.main.temp);
            document.getElementById('weather').textContent = `${weather}, ${temp}°C`;
            updateImageBasedOnWeather(data.weather[0].main);
        })
        .catch(error => console.error('Erro ao obter dados do clima:', error));
}

function updateImageBasedOnWeather(weatherCondition) {
    const imageDisplay = document.getElementById('image-display');
    let imageUrl = '';

    switch (weatherCondition) {
        case 'Clear':
            imageUrl = 'images/clear.jpg';
            break;
        case 'Clouds':
            imageUrl = 'images/clouds.jpg';
            break;
        case 'Rain':
            imageUrl = 'images/rain.jpg';
            break;
        case 'Snow':
            imageUrl = 'images/snow.jpg';
            break;
        default:
            imageUrl = 'images/default.jpg';
    }

    imageDisplay.innerHTML = `<img src="${imageUrl}" alt="Clima">`;
}

setInterval(updateTime, 1000);
fetchWeather();
