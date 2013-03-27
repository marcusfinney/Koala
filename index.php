<!doctype html>
<html lang="en">
    <head>
        <title>DataDoc | Login</title>
        <link rel="stylesheet" href="css/style.css">
    <head>

    <body>
        <h1>DataDoc</h1>
        <form method="post" action="checklogin.php">
        <table>
            <tr>
                <td>Association:</td>
                <td>
                    <select name="association">
                        <option value="Doctors">Doctor</option>
                        <option value="Nurses">Nurse</option>
                        <option value="Patients">Patient</option>
                        <option value="Admins">Admin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Login"></td>
                <!-- THIS CURRENTLY GOES NOWHERE -->
                <td><a class="small" href="">Forgot username or password?</a></td>
            </tr>
        </table>
        </form>
    </body>
</html>
