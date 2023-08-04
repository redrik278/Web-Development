<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Insert form</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="display">
            <form action="insert.php" method="post" name="insertform">
                <p>
                  <label for="name" id="preinput"> USER NAME : </label>
                  <input type="text" name="username" placeholder="Enter your name" id="inputid"/>
                </p>
                <p>
                  <label  for="email" id="preinput"> EMAIL ID : </label>
                  <input type="email" name="usermail" placeholder="Enter your Email" id="inputid" />
                </p>
                <p>
                  <label for="mobile" id="preinput"> MOBILE NUMBER : </label>
                  <input type="text" name="usermobile" placeholder="Enter your mobile number" id="inputid" />
                </p>
                <p>
                  <input type="submit" name="send" value="Submit" id="inputid"  />
                </p>
            </form>
        </div>

        <?php include('table.php'); ?>

    </body>
</html>