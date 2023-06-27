<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carinterest - Login</title>
        <script src='{{ url("js/login.js") }}' defer='true'></script>
        <link rel='stylesheet' href='{{ url('css/login.css') }}'>
        <link rel='stylesheet' href='{{ url('css/checkbox.css') }}'>
        <link rel="preconnect" href='{{ url("https://fonts.googleapis.com") }}'>
        <link rel="preconnect" href='{{ url("https://fonts.gstatic.com") }}' crossorigin>
        <link href='{{ url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap") }}' rel="stylesheet">
        <link href='{{ url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap") }}' rel="stylesheet">
    </head>

    <body>
        <div id='left-side'>
            <img id='side-image' src='{{ url("https://www.theaa.com/~/media/the-aa/article-summaries/driving-advice/car-buyers-guide/car-tyres.jpg") }}'>
        </div>

        <div id='right-side'>
            <main>
                <img id='logo' src='{{ url("img/logo.png") }}'>
                <h2>Carinterest</h2>
                <h5>Benvenuto! Accedi inserendo le credenziali</h5>

                <form method='post'>

                    @csrf

                    <label>Nome Utente<input type='text' name='username' value="{{ old('username') }}"></label>

                    <p id='username_error'>

                        @if(in_array("username", $empty ?? []))• Devi inserire il tuo nome utente
                        @elseif(in_array("username", $invalid ?? []))• Username non corretto
                        @endif

                    </p>

                    <label>Password<input type='password' name='password' value="{{ old('password') }}"></label>

                    <p id='password_error'>
                        
                        @if(in_array("password", $empty ?? []))• Devi inserire la tua password
                        @elseif(in_array("password", $invalid ?? []))• Password non valida
                        @endif

                    </p>
                    
                    <label class="container">
                        <input type='checkbox' name='show_password'>
                        <span class="checkmark"></span>
                        <span>Mostra Password</span>
                    </label>

                    <label id='submit'><input type='submit' value="ACCEDI"></label>
                </form>
                <div id='signup'>Sei nuovo? <a href='{{ url("signup") }}'>Registrati</a></div>
            </main>
        </div>  
    </body>
</html>