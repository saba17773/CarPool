<?php
    $app->get("/register", function() {
        echo RenderView("register");
    });
    $app->get("/hr-approve-register", function() {
        echo RenderView("hr-approve-register");
    });
    $app->get("/login", function() {
        echo RenderView("login");
    });
    $app->get("/logout", function() {
        $db = db();
        if(isset($_SESSION["loggedmail"])){
            // $InsertlogApp = sqlsrv_query($db,
            //     "INSERT INTO [EA_APP].[dbo].[TB_LOG_APP] (EMP_CODE,USER_NAME,HOST_NAME,LOGOUT_DATE,PROJECT_NAME)
            //     VALUES (?,?,?,?,?)",
            //     array(
            //         $_SESSION["loggedempid"],
            //         $_SESSION["loggedmail"],
            //         gethostbyaddr($_SERVER['REMOTE_ADDR']),
            //         date('Y-m-d H:i:s'),
            //         'Car Pool'
            //     )
            // );
        }

        session_destroy();
        echo'<script>';
	    echo 'location.href="./login"';
	    echo'</script>';
    });
    $app->get("/show-calendar", function() {
        echo RenderView("json");
    });
    $app->get("/", function() {
        echo RenderView("reserve-car");
    });
    $app->get("/manage", function() {
        echo RenderView("manage");
    });
    $app->get("/home", function() {
        echo RenderView("home");
    });
    $app->get("/home-update", function() {
        echo RenderView("home-update");
    });
    $app->get("/list-email", function() {
        echo RenderView("list-email");
    });
    $app->get("/forgetpassword", function() {
        echo RenderView("forget");
    });
    $app->get("/alert-forget", function() {
        echo RenderView("alert-forget");
    });
    $app->get("/account", function() {
        echo RenderView("account");
    });
    $app->get("/user", function() {
        echo RenderView("user");
    });
    $app->get("/cartype", function() {
        echo RenderView("cartype");
    });
    $app->get("/car", function() {
        echo RenderView("car");
    });
    $app->get("/driver", function() {
        echo RenderView("driver");
    });
    $app->get("/approve-mg", function() {
        echo RenderView("approve-mg");
    });
    $app->get("/approve-mghr", function() {
        echo RenderView("approve-mghr");
    });
    $app->get("/permission", function() {
        echo RenderView("permission");
    });
    $app->get("/department", function() {
        echo RenderView("department");
    });
    $app->get("/company", function() {
        echo RenderView("company");
    });
    $app->get("/menugroup", function() {
        echo RenderView("menugroup");
    });
    $app->get("/colorpick", function() {
        echo RenderView("colorpick");
    });
    
    
