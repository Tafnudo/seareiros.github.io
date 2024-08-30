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
    const imageUrl = localStorage.getItem(`image-${weatherCondition}`);

    if (imageUrl) {
        imageDisplay.innerHTML = `<img src="${imageUrl}" alt="Clima">`;
    } else {
        imageDisplay.innerHTML = `<img src="images/default.jpg" alt="Clima">`;
    }
}

setInterval(updateTime, 1000);
fetchWeather();
