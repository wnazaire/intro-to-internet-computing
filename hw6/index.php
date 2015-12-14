<html>
<head>
    <title>Wavelength/Frequency to Color Calculator</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./css/tweaks.css">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" />
    
    <!--Favicon-->
    <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16"/>
</head>
<body>
    <div class="container">
        <div class="col-md-5 col-md-offset-3">
            <div class="col-lg-12 text-center">
                 <form class="form-horizontal" action="index.php" method="POST">
                     <h1>Wavelength/Frequency to Color Calculator</h1> <br>
                    <div class="form-group">
                        <label for="wave_prop">Wave Property</label>
                        <input type="text" id="wave_prop" name="wave_prop" class="form-control" required autofocus>
                    </div>

                    <div class="form-group"> 
                        <div class="checkbox-inline">
                            <label for="wavelength">Wavelength (nm) to Color</label>
                            <input type="radio" name="calculate" id="wavelength" value="wavelength" checked>
                         </div>

                         <div class="checkbox-inline">
                            <label for="frequency">Frequency (10<sup>12</sup> Hz) to Color</label>
                            <input type="radio" name="calculate" id="frequency" value="frequency">
                         </div>
                     </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>         
<?php
function sanitizeString($str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}

function fromWavelength($wave)
{
    $out = 0;
    
    if (($wave <= 780) and ($wave >= 650))
    {
        $out = "Red";
    }
    else if (($wave <= 650) and ($wave >= 590))
    {
        $out = "Orange";
    }
    else if (($wave <= 590) and ($wave >= 570))
    {
        $out = "Yellow";
    }
    else if (($wave <= 570) and ($wave >= 510))
    {
        $out = "Green";
    }
    else if (($wave <= 510) and ($wave >= 475))
    {
        $out = "Blue";
    }
    else if (($wave <= 475) and ($wave >= 445))
    {
        $out = "Indigo";
    }
    else if (($wave <= 445) and ($wave >= 400))
    {
        $out = "Violet";
    }
    
    return $out;                                //If out === 0 then value is out of bounds
}

function fromFrequency($freq)
{
    $out = 0;
    
    if (($freq >= 380) and ($freq <= 460))
    {
        $out = "Red";
    }
    else if (($freq >= 460) and ($freq <= 510))
    {
        $out = "Orange";
    }
    else if (($freq >= 510) and ($freq <= 525))
    {
        $out = "Yellow";
    }
    else if (($freq >= 525) and ($freq <= 590))
    {
        $out = "Green";
    }
    else if (($freq >= 590) and ($freq <= 630))
    {
        $out = "Blue";
    }
    else if (($freq >= 630) and ($freq <= 675))
    {
        $out = "Indigo";
    }
    else if (($freq >= 675) and ($freq <= 7500))
    {
        $out = "Violet";
    }
    
    return $out;                                //If out === 0 then value is out of bounds
}
                
function colorOutput($res, $out)
{
    $class;
    
    switch ($res)
    {
        case "Red":
            $class = "red";
            break;
        case "Orange":
            $class = "orange";
            break;
        case "Yellow":
            $class = "yellow";
            break;
        case "Green":
            $class = "green";
            break;
        case "Blue":
            $class = "blue";
            break;
        case "Indigo":
            $class = "indigo";
            break;
        case "Violet":
            $class = "violet";
            break;
    }
    
    return "<h3 class=".$class.">".$out."</h3><br>";
}

if(isset($_POST['wave_prop']))
{
    // sanitize wave property
    $wave_prop = sanitizeString($_POST['wave_prop']);
    
    $output = "Error!";
    $result;
    
    // business logic
    if(isset($_POST['calculate']) && $_POST['calculate'] === 'wavelength')
    {
        $result = fromWavelength($wave_prop);
        $output = $wave_prop . " nm is " . $result;
    }
    else if(isset($_POST['calculate']) && $_POST['calculate'] === 'frequency')
    {
        $result = fromFrequency($wave_prop);
        $output = $wave_prop . " x 10<sup>12</sup> Hz is " . $result;       
    }
    
    if ($result === 0)                          //If result === 0 then value is out of bounds
    {
        echo "<h3>Value not is in visible spectrum<h3><br>";
    }
    else
    {
        echo colorOutput($result, $output);
    }
}
?>
                <div class="img-responsive">
                     <div class="center-block">
                         <a href="./img/visible_spectrum_larger.png">
                            <img src="./img/visible_spectrum.png" alt="Visible Sprectrum" width=439 height=141>
                             <h6>Click to enlarge image</h6>
                         </a>
                     </div>
                </div>
                <a href="../index.html">
                    <i class="fa fa-home fa-2x"></i>
                </a>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
