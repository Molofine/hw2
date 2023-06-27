<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carinterest - Iscriviti</title>
        <script> BASE_URL = "{{ url('/') }}/" </script>
        <script src='{{ url("js/signup.js") }}' defer='true'></script>
        <link rel='stylesheet' href='{{ url('css/signup.css') }}'>
        <link rel='stylesheet' href='{{ url('css/checkbox.css') }}'>
        <link rel="preconnect" href='{{ url('https://fonts.googleapis.com') }}'>
        <link rel="preconnect" href='{{ url("https://fonts.gstatic.com") }}' crossorigin>
        <link href='{{ url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap") }}' rel="stylesheet">
        <link href='{{ url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap") }}' rel="stylesheet">
    </head>

    <body>
        <main>
            <img id='logo' src='{{ url("img/logo.png") }}'>
            <h2>Carinterest</h2>
            <h3>Crea un account per accedere. È gratuito!</h3>
            <form method='post' enctype="multipart/form-data" autocomplete="off">

                @csrf

                <label>Nome Utente*<input type='text' name='username' value="{{ old("username") }}"></label>
                    
                    <p id='username_error'>

                        @if(in_array("username", $empty ?? []))• Devi inserire il tuo nome utente
                        @elseif(in_array("username", $invalid ?? []))• Deve contenere tra le 2 e le 15 lettere, numeri o '_'
                        @elseif(in_array("username", $used ?? []))• Username già in uso
                        @endif

                    </p>    

                <label>Email*<input type='text' name='email' value="{{ old("email") }}"></label>

                    <p id='email_error'>

                        @if(in_array("email", $empty ?? []))• Devi inserire la tua email
                        @elseif(in_array("email", $invalid ?? []))• Email non valida
                        @elseif(in_array("email", $used ?? []))• Email già in uso
                        @endif

                    </p>

                <label>Conferma Email*<input type='text' name='confirm_email' value="{{ old("confirm_email") }}"></label>

                    <p id='confirm_email_error'>

                        @if(in_array("confirm_email", $empty ?? []))• Devi confermare la tua email
                        @elseif(in_array("confirm_email", $invalid ?? []))• Le email non coincidono
                        @endif

                    </p>

                <label>Password*<input type='password' name='password' value="{{ old("password") }}"></label>
                    
                    <p id='password_error'>

                        @if(in_array("password", $empty ?? []))• Devi inserire la tua password
                        @elseif(in_array("password", $invalid ?? []))• Deve contenere almeno 8 caratteri di cui almeno un numero (no speciali)
                        @endif

                    </p>

                <label>Conferma Password*<input type='password' name='confirm_password' value="{{ old("confirm_password") }}"></label>
                    
                    <p id='confirm_password_error'>

                        @if(in_array("confirm_password", $empty ?? []))• Devi confermare la tua password
                        @elseif(in_array("confirm_password", $invalid ?? []))• Le password non coincidono
                        @endif

                    </p>

                    <label class="container">
                        <input type='checkbox' name='show_password'>
                        <span class="checkmark"></span>
                        <span>Mostra Password</span>
                    </label>
                    
                <label>Nome<input type='text' name='name' value="{{ old("name") }}"></label>
                    <p></p>

                <label>Cognome<input type='text' name='surname' value="{{ old("surname") }}"></label>

                <em>(*) Campi obbligatori</em>   

            <label id='check' class="container">
                <input type='checkbox' name='allow' value="1"> 

                <span class="checkmark"></span>
                <div>Accetto i <a href='{{ url("terms") }}'> Termini e Condizioni d'Uso</a> di Carinterest</div>
            </label>

                <p id='allow_error'>

                    @if(in_array("allow", $empty ?? []))• Devi accettare i Termini e Condizioni
                    @endif

                </p>

            <label id='submit'><input type='submit' value="REGISTRATI"></label>
            </form>
            
            <div>Hai un account? <a href='{{ url("login") }}'>Accedi</a></div>
        </main>
    </body>
</html>