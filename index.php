<?php

include "config.php";
include "vendor/autoload.php";

session_start();

$errMsg = "";
$errMsg1 = "";

if(isset($_SESSION['username1']) || isset($_SESSION['password'])){
    header("Location: status.php");
}

if(isset($_POST['submit'])){
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    $username = $con->real_escape_string($_POST['nomeutente']);
    $password = $con->real_escape_string($_POST['password']);

    if($username != "" || !empty($username)){
        if($password != "" || !empty($password)){
            if($con->query("SELECT * FROM tbl_users WHERE username='$username' AND password='$password' AND stato='0'")->num_rows == 1){
                $_SESSION['username1'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['self'] = 0;

                header("Location: auth.php");
            }else{
                $errMsg = "Credenziali errate!";
            }
        }else{
            $errMsg = "Completa tutti i campi!";
        }
    }else{
        $errMsg = "Completa tutti i campi!";
    }
}

if(isset($_POST['registrazione'])){
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    $nome = $con->real_escape_string($_POST['nome']);
    $cognome = $con->real_escape_string($_POST['cognome']);
    $telefono = $con->real_escape_string($_POST['telefono']);
    $email = $con->real_escape_string($_POST['email']);
    $sesso = $con->real_escape_string($_POST['sesso']);
    $nazionalita = $con->real_escape_string($_POST['nazionalita']);

    if($nome != "" || !empty($nome)){
        if($cognome != "" || !empty($cognome)){
            if($telefono != "" || !empty($telefono)){
                if($email != "" || !empty($email)){
                    if($nazionalita != "" || !empty($nazionalita)){
                        if($sesso != "" || !empty($sesso)){
                            if($con->query("SELECT * FROM tbl_registrazioni WHERE nome='$nome' AND cognome='$cognome' AND telefono='$telefono' AND email='$email' AND sesso='$sesso' AND nazionalita='$nazionalita' AND stato='0'")->num_rows == 0){
                                $username = openssl_random_pseudo_bytes(8);
                                $username = bin2hex($username);
                                $password = openssl_random_pseudo_bytes(8);
                                $password = bin2hex($password);
                                $_SESSION['username1'] = $username;
                                $_SESSION['password'] = $password;
                                $_SESSION['self'] = 1;
                                $con->query("INSERT INTO tbl_registrazioni(nome,cognome,telefono,email,sesso,nazionalita,stato,username,password) VALUES('$nome', '$cognome', '$telefono', '$email', '$sesso', '$nazionalita', '1', '$username', '$password')");
                                header("Location: auth.php");
                            }else{
                                $errMsg1 = "Account già esistente!";
                            }
                        }else{
                            $errMsg1 = "Completa tutti i campi!";
                        }    
                    }else{
                        $errMsg1 = "Completa tutti i campi!";
                    }
                }else{
                    $errMsg1 = "Completa tutti i campi!";
                }
            }else{
                $errMsg1 = "Completa tutti i campi!";
            }
        }else{
            $errMsg1 = "Completa tutti i campi!";
        }
    }else{
        $errMsg1 = "Completa tutti i campi!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>

    <!-- Bootstrap5 CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <title><?= $nomeportale; ?></title>
</head>
<body>
<!-- As a heading -->
<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1 text-center"><?= $nomeportale; ?></span>
  </div>
</nav>
<div class="d-flex">
    <form class="form-login" action="" method="post">
        
        <h1 class="h3 mb-3 font-weight-normal"><?= $nomeportale; ?> - </h1><h5>Accedi con le credenziali fornite dal personale</h5>
        <?php if($errMsg != ""){ ?>
            <div class="alert alert-danger"><h4><?= $errMsg ?></h4></div>
        <?php } ?>
        <!-- 'sr-only' will hide the text : 'Email Address'. So, 'Email Address' will be invisible -->
        <label for="nomeutente" class="sr-only">Nome Utente</label>
        <!-- 'autofocus' will highlight the input column initially -->
        <input 
            type="text" 
            id="nomeutente"
            name="nomeutente"
            class="form-control mb-2"
            placeholder="Nome Utente"
            required
            autofocus
        >
        <!-- 'sr-only' will hide the text : 'Password'. So, 'Password' will be invisible -->
        <label for="password" class="sr-only">Password</label>
        <input 
            type="password" 
            id="password"
            name="password"
            class="form-control mb-2"
            placeholder="Password"
            required
        >
        <p>Se non disponi delle credenziali chiedile al personale!</p>
        <!-- 'btn-block' will make the button wider -->
        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">
            Accedi
        </button><br><br><br>
        <img src="img/logo1.jpg">
    </form>
    <form class="form-login" action="" method="post">
        
        <h1 class="h3 mb-3 font-weight-normal"><?= $nomeportale; ?> - </h1><h5>Registra un nuovo account self</h5>
        <?php if($errMsg1 != ""){ ?>
            <div class="alert alert-danger"><h4><?= $errMsg1 ?></h4></div>
        <?php } ?>
        <!-- 'sr-only' will hide the text : 'Email Address'. So, 'Email Address' will be invisible -->
        <label for="nome" class="sr-only">Nome</label>
        <!-- 'autofocus' will highlight the input column initially -->
        <input 
            type="text" 
            id="nome"
            name="nome"
            class="form-control mb-2"
            placeholder="Il tuo Nome"
            required
            autofocus
        >
        <!-- 'sr-only' will hide the text : 'Password'. So, 'Password' will be invisible -->
        <label for="password" class="sr-only">Cognome</label>
        <input 
            type="text" 
            id="cognome"
            name="cognome"
            class="form-control mb-2"
            placeholder="Il tuo Cognome"
            required
        >
        <label for="telefono" class="sr-only">Numero di Telefono</label>
        <!-- 'autofocus' will highlight the input column initially -->
        <input 
            type="tel" 
            id="telefono"
            name="telefono"
            class="form-control mb-2"
            placeholder="Numero di Telefono"
            required
            autofocus
        >
        <!-- 'sr-only' will hide the text : 'Password'. So, 'Password' will be invisible -->
        <label for="email" class="sr-only">E-Mail</label>
        <input 
            type="email" 
            id="email"
            name="email"
            class="form-control mb-2"
            placeholder="Indirizzo Email"
            required
        >
        <label for="sesso" class="sr-only">Sesso</label>
        <!-- 'autofocus' will highlight the input column initially -->
        <select name="sesso" id="sesso" class="form-control mb-2" required>
            <option value="uomo">Uomo</option>
            <option value="donna">Donna</option>
            <option value="null">Preferisco non specificarlo</option>
        </select>
        <!-- 'sr-only' will hide the text : 'Password'. So, 'Password' will be invisible -->
        <label for="nazionalita" class="sr-only">Nazionalità</label>
        <select name="nazionalita" id="nazionalita" class="form-control mb-2" required>
            <option value="US">United States</option>
            <option value="CA">Canada</option>
            <option value="AF">Afghanistan</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo (Democratic Republic)</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="TP">East Timor</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="FX">France (European Territory)</option>
            <option value="GF">French Guiana</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea Bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard and McDonald Islands</option>
            <option value="VA">Holy See (Vatican)</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IL">Israel</option>
            <option value="IT"selected="selected">Italy</option>
            <option value="CI">Cote D&rsquo;Ivoire</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Laos</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macau</option>
            <option value="MK">Macedonia</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia</option>
            <option value="MD">Moldova</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="AN">Netherlands Antilles</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="KP">North Korea</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestinian Territory</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PF">Polynesia</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="GS">S. Georgia &amp; S. Sandwich Isls.</option>
            <option value="SH">Saint Helena</option>
            <option value="KN">Saint Kitts &amp; Nevis Anguilla</option>
            <option value="LC">Saint Lucia</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent &amp; Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="KR">South Korea</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania</option>
            <option value="TH">Thailand</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="UY">Uruguay</option>
            <option value="UM">USA Minor Outlying Islands</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela</option>
            <option value="VN">Vietnam</option>
            <option value="VG">Virgin Islands (British)</option>
            <option value="VI">Virgin Islands (USA)</option>
            <option value="WF">Wallis and Futuna Islands</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZR">Zaire</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
        </select>
        <!-- 'btn-block' will make the button wider -->
        <button class="btn btn-lg btn-primary btn-block" name="registrazione" type="submit">
            Registrati
        </button><br><br><br>
    </form>
</div>

    <main class="flex-shrink-0" style="margin-top: 100px;">
  <div class="container">
    <h5><?= $nomeportale; ?></h5>
  </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">&copy; <?= date("Y") ?> - Lentino Loris</span>
  </div>
</footer>

</body>
</html>
