<style>
    #formparent {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #loginform {
        display: grid;

        input[type=text],
        input[type=password] {
            width: 100%;
            border: 2px solid #aaa;
            border-radius: 8px;
            margin: 8px 0;
            outline: none;
            padding: 8px;
            box-sizing: border-box;
            transition: .3s;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            border-color: dodgerBlue;
            box-shadow: 0 0 8px 0 dodgerBlue;
        }

        input[type=button],
        input[type=submit],
        input[type=reset],
        .formbutton {
            background-color: #007bff;
            border: none;
            color: black;
            padding: 16px 32px;
            border-radius: 8px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }

        label {
            float: left;
        }

        .vanillaalert {
            padding: 16px;
            border: thin solid #ffeeba;
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .va-warning {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        .va-error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

    }
</style>
<div id="formparent">
    <form id="loginform" action="/api/login.php" method="POST">
        <?php
        include(__DIR__.'/../helpers/alertrenderer.php');
        render_alerts(alerts: [
            array('trigger'=>'iw','type'=>'va-error','melding'=>'Ongeldige login of wachtwoord.'),
            array('trigger'=>'im','type'=>'va-warning','melding'=>'Door inactiviteit bent u automatisch uitgelogd. Log opnieuw in om verder te gaan.'),
            array('trigger'=>'ag','type'=>'va-warning','melding'=>'Account is geactiveerd, u kunt nu inloggen.')
        ]);
        ?>
        <center>
            <div style="max-width: 20vw;">
                <label for="email">E-mailadres</label>
                <input type="text" id="email" name="email" placeholder="" required>
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" placeholder="" required>
                <div style="text-align: center;">
                    <a class="formbutton" href="index.php?page=Registreren" style="background-color: grey">Registreren</a>
                    <button class="formbutton" type="submit">Inloggen</button>
                </div>
            </div>
        </center>
    </form>
</div>