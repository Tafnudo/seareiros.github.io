document.getElementById('image-upload-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const weatherCondition = document.getElementById('weather-condition').value;
    const imageFile = document.getElementById('image-upload').files[0];

    if (!imageFile) {
        alert('Por favor, selecione uma imagem.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const base64Image = e.target.result;

        // Simula o upload da imagem para um servidor ou armazenamento.
        localStorage.setItem(`image-${weatherCondition}`, base64Image);

        document.getElementById('upload-status').textContent = 'Imagem carregada com sucesso!';
    };
    reader.readAsDataURL(imageFile);
});
