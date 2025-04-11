<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

            * {
                margin: 0;
                padding: 0;
                font-family: Montserrat, sans-serif;
                font-weight: 400;
            }

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 90vh;
                background-color: #eeeeee;
            }
            .main {
                display: flex;
                flex-direction: column;
                width: 50%;
            }
            .main h1 {
                margin-bottom: 10px;
            }
            .footer {
                height: 10vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #eeeeee;
            }
            button {
                background: navy;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 10px;
                margin-top: 10px ;
                font-weight: 500;
                cursor: pointer;
            }

            button::hover {
                opacity: 0.9;
            }
            .form-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 500px;
            }
            .form-group {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;
                
            }

            .form-group input {
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 10px;
                outline: none;
            }
            h2, h1 {
                margin-bottom: 10px;
            }
            h1 {
                font-weight: 500;
            }
            .errors {
                display: flex;
                flex-direction: column;
                align-items: start;
                text-align: left;
                color: red;
                font-size: x-small;
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Stock System</h1>
            <h2>Welcome Back!</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="errors">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                
            @endif
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
                <p>Don't have an account? <a href="/register">Register Here</a></p>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>&copy; Stock System</p>
    </div>
    <script src="{{ asset('app.js') }}"></script>
</body>
</html>