<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Relaxarc Travel - Iniciar Sesión') }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/efd43ec33f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('Login') }}</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {!! session('status') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('verifiedStatus'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('verifiedStatus') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" id="myfr">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="username"><i class="fas fa-user"></i></label>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control @error('username') is-invalid @enderror"
                                placeholder="{{ __('Username / Email') }}" id="username">
                            @error('username')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="password"><i class="fas fa-key"></i></label>
                            </div>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('Password') }}" id="password">
                            @error('password')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row align-items-center remember">
                            <input type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}><label class="pt-2 pl-1 remember"
                                for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn float-right login_btn"
                                id="btnfr">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        {{ __("Don't have an account?") }}<a href="{{ route('register') }}">{{ __('Register') }}</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/frontend/libraries/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <!-- Font Awesome library -->
    <script src="https://kit.fontawesome.com/efd43ec33f.js" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('click', function(e){
                if(e.target.id == 'btnfr'){
                    const form = document.querySelector('#myfr');
                    form.addEventListener('submit', function(ev){
                        const btn = document.querySelector('#btnfr');
                        btn.innerHTML = "{{ __('Please Wait ...') }}";
                        btn.style.fontWeight = 'bold';
                        btn.style.color = 'black';
                        btn.style.cursor = 'not-allowed';
                        btn.setAttribute('disable', 'disable');
                        return true;
                    });
                }
            });
    </script>
</body>

</html>
