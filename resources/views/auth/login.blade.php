<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>UPDS Online - Inicio de Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#f7f9fb] flex items-center justify-center min-h-screen" style="font-family: 'Hanken Grotesk', sans-serif;">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="bg-[#003360] p-6 text-center text-white relative">
            <h2 class="text-2xl font-bold tracking-tight">UPDS <span class="font-light text-sky-400">online</span></h2>
            <p class="text-xs text-white/70 mt-1 uppercase tracking-wider">Sistema de Consulta Académica</p>
        </div>
        
        <div class="p-8">
            <h3 class="text-lg font-semibold text-[#003360] mb-6 text-center">Seguimiento de Proyecto de Grado</h3>
            
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-4 rounded text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wide text-gray-600 mb-1">Correo Institucional</label>
                    <input type="email" name="email" class="w-full p-2.5 border border-gray-300 rounded focus:outline-none focus:border-[#003360] transition-colors" required value="{{ old('email') }}" placeholder="usuario@upds.edu">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wide text-gray-600 mb-1">Contraseña</label>
                    <input type="password" name="password" class="w-full p-2.5 border border-gray-300 rounded focus:outline-none focus:border-[#003360] transition-colors" required placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-[#003360] text-white py-2.5 rounded font-bold hover:bg-[#002244] transition-colors tracking-wide mt-2 shadow-sm">
                    INGRESAR
                </button>
            </form>
        </div>
    </div>
</body>
</html>