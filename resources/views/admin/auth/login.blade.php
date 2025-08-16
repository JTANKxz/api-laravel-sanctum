<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamFlix Admin - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'amoled': '#000000',
                        'netflix-red': '#E50914',
                        'dark-gray': '#121212',
                        'medium-gray': '#1a1a1a',
                        'light-gray': '#242424'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
            color: #e5e5e5;
        }

        .login-container {
            background-color: #1a1a1a;
            /* Usando medium-gray para o container de login */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
        }

        .input-field {
            background-color: #333;
            /* Tom um pouco mais claro para os campos de input */
            border: 1px solid #444;
            color: #e5e5e5;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            width: 100%;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #E50914;
            box-shadow: 0 0 0 2px rgba(229, 9, 20, 0.5);
        }

        .btn-primary {
            background-color: #E50914;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #B20710;
        }

        .link-text {
            color: #b3b3b3;
            transition: color 0.2s ease;
        }

        .link-text:hover {
            color: #e5e5e5;
        }
    </style>
</head>

<body class="bg-amoled flex items-center justify-center min-h-screen">
    <div class="login-container">
        <div class="flex items-center justify-center mb-8">
            <div class="text-netflix-red text-4xl">
                <i class="fas fa-play-circle"></i>
            </div>
            <span class="logo-text ml-3 text-3xl font-bold whitespace-nowrap">StreamFlix Admin</span>
        </div>
        <h1 class="text-2xl font-bold text-white text-center mb-6">Fazer Login</h1>
        <form action="{{ route('admin.login.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="sr-only">Endereço de e-mail</label>
                <input type="email" id="email" name="email"
                    class="input-field" placeholder="Endereço de e-mail" required>
            </div>
            <div>
                <label for="password" class="sr-only">Senha</label>
                <input type="password" id="password" name="password"
                    class="input-field" placeholder="Senha" required>
            </div>
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input type="checkbox" id="remember-me" name="remember-me"
                        class="h-4 w-4 text-netflix-red border-gray-600 rounded focus:ring-netflix-red">
                    <label for="remember-me" class="ml-2 text-gray-400">Lembrar de mim</label>
                </div>
                <a href="#" class="link-text">Precisa de ajuda?</a>
            </div>
            <div>
                <button type="submit" class="btn-primary">Entrar</button>
            </div>
        </form>
        <div class="mt-8 text-center text-gray-400">
            <p>Novo por aqui? <a href="#" class="link-text text-netflix-red font-medium hover:underline">Assine
                    agora.</a></p>
        </div>
    </div>
</body>

</html>