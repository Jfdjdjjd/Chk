<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Painel Pro</title>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-blue-400">Painel de Testes</h1>
        
        <textarea id="lista" class="w-full h-32 bg-gray-800 border border-gray-700 rounded-lg p-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="CC|MM|AA|CVV"></textarea>
        
        <button onclick="iniciar()" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
            Iniciar Teste
        </button>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Aprovadas -->
            <div class="bg-gray-800 p-4 rounded-lg border-t-4 border-green-500">
                <h2 class="font-bold mb-3 text-green-400">Aprovadas</h2>
                <div id="aprovadas" class="space-y-2 text-sm"></div>
            </div>

            <!-- Reprovadas -->
            <div class="bg-gray-800 p-4 rounded-lg border-t-4 border-red-500">
                <h2 class="font-bold mb-3 text-red-400">Reprovadas</h2>
                <div id="reprovadas" class="space-y-2 text-sm"></div>
            </div>
        </div>
    </div>

    <script>
    function iniciar() {
        let texto = document.getElementById('lista').value;
        let linhas = texto.split('\n');
        
        linhas.forEach(linha => {
            if(linha.trim() === "") return;
            
            fetch('processar.php?lista=' + encodeURIComponent(linha))
                .then(res => res.text())
                .then(data => {
                    let div = document.createElement('div');
                    // Removi a classe 'truncate' e adicionei 'whitespace-pre-wrap'
                    // Isso força o texto a respeitar quebras de linha e ser exibido totalmente
                    div.className = "bg-gray-700 p-3 mb-2 rounded border-l-4 border-gray-500 text-xs shadow-sm break-words";
                    div.innerHTML = data;
                    
                    if(data.includes('Aprovada')) 
                        document.getElementById('aprovadas').appendChild(div);
                    else 
                        document.getElementById('reprovadas').appendChild(div);
                });
        });
    }
    </script>
</body>
</html>
