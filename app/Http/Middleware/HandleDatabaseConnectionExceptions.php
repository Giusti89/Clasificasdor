<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

class HandleDatabaseConnectionExceptions
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (PDOException $e) {
            // Verifica si el error es específicamente un error de conexión
            if ($e->getCode() == 2002) {
                // Loguea el error para referencia
                Log::error('Database connection error: ' . $e->getMessage());

                // Redirige a una página de error amigable
                return redirect()->route('errorPage')->with('error', 'No se puede conectar a la base de datos. Por favor, inténtelo más tarde.');
            }

            // Si no es un error de conexión, lanza la excepción de nuevo
            throw $e;
        }
    }
}
