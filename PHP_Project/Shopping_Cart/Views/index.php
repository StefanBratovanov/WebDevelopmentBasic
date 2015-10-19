<h3>Login</h3>
<form action="index.php/user/login" method="POST">
    <p><label for="username">Username:</label>
    <input type="text" name="username" id="username"/>
    </p>
    <p><label for="password">Password:</label>
    <input type="password" name="password" id="password"/>
    </p>
    <input type="submit" value="Login"/>
</form>

<hr/>
<hr/>
<hr/>

<h3>Register</h3>
<form action="index.php/user/register" method="POST">
    <p><label for="username">Username:</label>
        <input type="text" name="username" id="username"/>
    </p>
    <p><label for="password">Password:</label>
        <input type="password" name="password" id="password"/>
    </p>
    <input type="submit" value="Register"/>
</form>