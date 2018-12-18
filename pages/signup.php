<?php include_once('./header.php') ?>
    <style>
        .wrapper{
            width: 70%;
            margin: 100px auto;
            
        }
        input,.btn, a{
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            margin: 5px 0;
            opacity: 0.85;
            display: inline-block;
            font-size: 17px;
            line-height: 20px;
            text-decoration: none; /* remove underline from anchors */
            }

        input:hover,
            .btn:hover {
            opacity: 1;
            }


        .header{
            text-align: center;
        }        
    </style>
    <div class="container">
        <div class="wrapper">
            <h2 class="header">Sign up</h2>
            <form action="./models/verify_signup.php" method="post">
                <div class="from-group">
                    <input class="from-control" name="username" placeholder="username"></input>
                </div>
                <div class="from-group">
                    <input class="from-control" name="password" type="password" placeholder="password"></input>
                </div>
                <button class="btn btn-primary" type="submit">Sign up</button>
                <a href="./login.php">Back to log in page</a>
            </form>
        </div>
    </div>
<?php include_once('./footer.php') ?>