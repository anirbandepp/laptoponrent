    @extends('adminlte::page')

    @section('title', 'Password Change')

    @section('content_header')
        <h1>Password Change</h1>
    @stop

    @section('content')
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <form action="{{ route('password.changes') }}" method="post">
                            @csrf
                            {{-- Password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('adminlte::adminlte.password') }}">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Password confirmation field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="{{ trans('adminlte::adminlte.retype_password') }}">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Confirm password reset button --}}
                            <button type="submit"
                                class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                                <span class="fas fa-sync-alt"></span>
                                {{ __('adminlte::adminlte.reset_password') }}
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
        <script>
            console.log('Hi!');
        </script>
    @stop
