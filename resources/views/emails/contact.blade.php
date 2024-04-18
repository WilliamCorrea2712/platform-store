<!DOCTYPE html>
<html>
<head>
    <title>Novo Contato</title>
</head>
<body>
    <h2>Novo contato recebido</h2>
    <p><strong>Nome:</strong> {{ is_string($name) ? $name : '' }}</p>
    <p><strong>E-mail:</strong> {{ is_string($email) ? $email : '' }}</p>
    <p><strong>Mensagem:</strong> {{ is_string($message) ? $message : '' }}</p>
</body>
</html>
