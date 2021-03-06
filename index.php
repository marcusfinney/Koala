<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
    <head>

    <body>
        <div class="container login-content">
            <h1>Well-Check Clinic Login</h1>
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
                        <small><a href="index.php?status=forgotpassword">Forgot password?</a></small>
                    </div>
                </div>

            </form>

            <!-- <table class="table table-striped">
                <tr class="success">
                    <td>slfj</td>
                    <td>sldjf</td>
                </tr>
                <tr class="error">
                    <td>lsdjflsdjfldsjf</td>
                    <td>example stuff</td>
                </tr>
            </table> -->
            
        </div>

        <?php
        	if ($_GET and $_GET["error"] == "unauthorized") {echo '<script>alert("You must be logged to view that page.")</script>';}
			if (isset($_SESSION['username'])){die();}
			
			if (isset($_GET))
            {
                if (isset($_GET["status"]) and $_GET["status"] == "forgotpassword")
                {
                    echo '<script>alert("Please contact your doctor or call (734)358-9617 for assistance.")</script>';
                }
            }
        ?>
    </body>
</html>