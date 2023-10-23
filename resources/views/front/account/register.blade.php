@extends('front.layouts.parent')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item">Register</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        <div class="login-form">
            <form action="{{route('account.processRegister')}}" method="post" name="registrationForm" id="registrationForm">
                @csrf
                <h4 class="modal-title">Register Now</h4>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{old('name')}}" placeholder="Name" id="name" name="name">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{  $errors->first('name')  }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{old('email')}}" placeholder="Email" id="email" name="email">
                    @if ($errors->has('email'))
                    <span class="text-danger">{{  $errors->first('email')  }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{old('phone')}}" placeholder="Phone" id="phone" name="phone">
                    @if ($errors->has('phone'))
                    <span class="text-danger">{{  $errors->first('phone')  }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                    @if ($errors->has('password'))
                    <span class="text-danger">{{  $errors->first('password')  }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{  $errors->first('password_confirmation')  }}</span>
                    @endif
                </div>
                <div class="form-group small">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div> 
                <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
            </form>			
            <div class="text-center small">Already have an account? <a href="{{route('account.login')}}">Login Now</a></div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script type="text/javascript">
    // $("#registrationForm").submit(function(event){
    //     event.preventDefault();

    //     $.ajax({
    //         url: '{{ route("account.processRegister") }}',
    //         type: 'post',
    //         data: $(this).serializeArray(),
    //         dataType: 'json',
    //         success: function(response){

    //         },
    //         error: function(jQXHR, exeption){
    //             console.log("Something went wrong");
    //         }
    //     });
    // });
    </script>
@endsection