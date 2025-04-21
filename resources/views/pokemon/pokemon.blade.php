<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Capturar Pokémon</title>
</head>
<body>
    <button id="capturar">🎯 Capturar Pokémon Aleatório</button>

    <div id="resultado"></div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('capturar').addEventListener('click', async () => {
            try {
                const response = await axios.post("/capturar-aleatorio", {}, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const { pokemon, message } = response.data;

                document.getElementById('resultado').innerHTML = `
                    <p style="color:green;">${message}</p>
                    <div>
                        <strong>${pokemon.name}</strong><br>
                        <img src="${pokemon.sprite}" alt="${pokemon.name}"><br>
                        Tipo: ${pokemon.type}<br>
                        HP: ${pokemon.hp} | ATK: ${pokemon.attack} | DEF: ${pokemon.defense} | SPD: ${pokemon.speed}
                    </div>
                `;
            } catch (err) {
                console.error(err);
                document.getElementById('resultado').innerHTML = `<p style="color:red;">Erro ao capturar Pokémon.</p>`;
            }
        });
    </script>
</body>
</html>
