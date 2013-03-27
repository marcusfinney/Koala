<!doctype html>
<html lang="en">
    <head>
        <title>Doctor Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php
            session_start();
            echo "<h1>Dr. {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
        ?>

        <!-- need to create page for patient info -->
        <form method="post" action="">
            Select a patient: 
            <select name="Patients">
                <!-- need to access all patients a doctor has and put them here -->
                <option>placeholder</option>
            </select>
        </form>

        <p><a href="register.php"><button>Register a Patient</button></a></p>

        <p><a href="logout.php">Logout</a></p>

    </body>
</html>
