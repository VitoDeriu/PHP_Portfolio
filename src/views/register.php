<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Register</h1>
    <form action="../controllers/register.php" method="POST">
        <label for="pseudo">pseudo</label>
        <input type="text" name="pseudo">
        <label for="email">email</label>
        <input type="text" name="email">
        <label for="password">password</label>
        <input type="password" name="password">
        <button type="submit">S'enregistrer</button>
    </form>
</body>
</html>