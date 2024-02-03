<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php
    include("dbcon\connection.php");
    include("dbcon\session.php");
    ?>

    <div>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </div>

</body>

</html>