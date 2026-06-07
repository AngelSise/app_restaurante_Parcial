<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$filtro = $_GET['filtro'] ?? 'todos';

if ($filtro === 'activos') {
    $stmt = $pdo->query("SELECT * FROM usuarios WHERE estado = 'activo'");
} elseif ($filtro === 'inactivos') {
    $stmt = $pdo->query("SELECT * FROM usuarios WHERE estado = 'inactivo'");
} else {
    $stmt = $pdo->query("SELECT * FROM usuarios");
}

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - La Mesa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Georgia', serif;
            background-color: #1a0a00;
            color: #f0d080;
            min-height: 100vh;
        }

        header {
            background-color: #2c1500;
            border-bottom: 2px solid #c8860a;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            color: #c8860a;
            font-size: 22px;
            letter-spacing: 2px;
        }

        header span {
            color: #a07040;
            font-size: 14px;
        }

        .btn-logout {
            background-color: #4a0a0a;
            color: #ff8080;
            border: 1px solid #cc3333;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Georgia', serif;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-logout:hover { background-color: #6a1010; }

        .container {
            padding: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Georgia', serif;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 1px;
            transition: background-color 0.2s;
        }

        .btn-crear {
            background-color: #c8860a;
            color: #1a0a00;
            font-weight: bold;
        }
        .btn-crear:hover { background-color: #e5a020; }

        .btn-filtro {
            background-color: #2c1500;
            color: #c8860a;
            border: 1px solid #c8860a55;
        }
        .btn-filtro:hover, .btn-filtro.activo {
            background-color: #c8860a22;
            border-color: #c8860a;
        }

        .btn-editar {
            background-color: #1a3a5c;
            color: #80c0ff;
            border: 1px solid #4080cc55;
            padding: 6px 12px;
            font-size: 12px;
        }
        .btn-editar:hover { background-color: #1a3a5c99; }

        .btn-eliminar {
            background-color: #4a0a0a;
            color: #ff8080;
            border: 1px solid #cc333355;
            padding: 6px 12px;
            font-size: 12px;
        }
        .btn-eliminar:hover { background-color: #6a1010; }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2c1500;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(200, 134, 10,
