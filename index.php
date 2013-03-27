<!doctype html>
<html lang="en">
    <head>
        <title>Login | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/style.css">
    <head>

    <body>
        <h1>Welcome to Well-Check Clinic</h1>
        <!-- displays error message if checklogin.php did not pass login -->
        <?php
            if ($_GET and $_GET["error"] == "incorrectlogin") {
                echo '<p class="error">Incorrect username and/or password.</p>';
            }
        ?>
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

        <!-- alternate method to display incorrect login error using an alert box -->
        <?php
            // if ($_GET and $_GET["error"] == "incorrectlogin") {
            //     echo '<script>alert("Incorrent username and/or password")</script>';
            // }
        ?>
    </body>
</html>
