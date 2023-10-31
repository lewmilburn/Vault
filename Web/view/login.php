<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
    </head>
    <body>
        Login to Vault.

        <form action="/auth" method="post">
            <label for="user">Username</label>
            <input id="user" name="user">
            <br>
            <label for="pass">Password</label>
            <input id="pass" name="pass" type="password">
            <br>
            <button type="submit">Login</button>
        </form>
    </body>
</html>