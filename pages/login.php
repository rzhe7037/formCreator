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
            text-decoration: none; 
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
            <h2 class="header">Log in </h2>
            <form action="./models/verify_user.php" method="post">
                <div class="from-group">
                    <input class="from-control" name="username" placeholder="username"></input>
                </div>
                <div class="from-group">
                    <input class="from-control" type="password" name="password" placeholder="password"></input>
                </div>
                <button class="btn btn-primary" type="submit">Log in</button>
            </form>
            <h6>Haven't a account? Sign up here!</h6>
            <a href="./signup.php">Sign up</a>
        </div>
    </div>
<?php include_once('./footer.php') ?>