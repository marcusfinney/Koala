<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
    <head>

    <body>
        <div class="container login-content">
            <h1>Sign-in to Well-Check Clinic</h1>
            <br>

            <form class="form-horizontal" method="post" action="checklogin.php">

                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" id="username" name="username" autofocus>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" id="password" name="password">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="association">Association</label>
                    <div class="controls">
                        <select id="association" name="association">
                            <option value="Doctors">Doctor</option>
                            <option value="Nurses">Nurse</option>
                            <option value="Patients">Patient</option>
                            <option value="Admins">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <!-- displays error message if checklogin.php did not pass login -->
                        <?php
                            if ($_GET and $_GET["error"] == "incorrectlogin") {
                                echo '<p class="label label-important fadeIn">Incorrect username and/or password.</p><br>';
                            }
                        ?>
                        <input class="btn btn-primary" type="submit" name="submit" value="Login">
                        <!-- THIS CURRENTLY GOES NOWHERE -->
                        <small><a href="">Forgot password?</a></small>
                    </div>
                </div>

            </form>
        </div>

        <?php
        	if ($_GET and $_GET["error"] == "unauthorized") {echo '<script>alert("You must be logged to view that page.")</script>';}
			if (isset($_SESSION['username'])){die();}
        ?>
    </body>
</html>