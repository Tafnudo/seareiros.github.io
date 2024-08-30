document.getElementById('image-upload-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const weatherCondition = document.getElementById('weather-condition').value;
    const imageFiles = document.getElementById('image-upload').files;

    if (imageFiles.length === 0) {
        alert('Por favor, selecione uma ou mais imagens.');
        return;
    }

    Array.from(imageFiles).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const base64Image = e.target.result;

            // Simula o upload da imagem para um servidor ou armazenamento.
            localStorage.setItem(`image-${weatherCondition}-${index}`, base64Image);
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('upload-status').textContent = 'Imagens carregadas com sucesso!';
});
