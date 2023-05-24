<form class="form-area contact-form" id="myForm"
      action="{{route('contactMsgSubmit')}}"
      method="post">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <label class="primary_label">{{__('frontend.Name')}}</label>
            <input name="name" placeholder="{{__('frontend.Enter Name')}}"
                   onfocus="this.placeholder = ''"
                   onblur="this.placeholder = '{{__('frontend.Enter Name')}}'"
                   class="primary_input mb_20" type="text" required
                   value="{{old('name')}}">
            <span class="text-danger"
                  role="alert">{{$errors->first('name')}}</span>

            <label
                class="primary_label">{{__('frontend.Email Address')}}</label>
            <input name="email" required
                   placeholder="{{__('frontend.Type e-mail address')}}"
                   pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                   onfocus="this.placeholder = ''"
                   onblur="this.placeholder = '{{__('frontend.Type e-mail address')}}'"
                   class="primary_input mb_20"
                   type="email" value="{{old('email')}}">
            <span class="text-danger"
                  role="alert">{{$errors->first('email')}}</span>
            <label class="primary_label">{{__('frontend.Subject')}}</label>
            <input name="subject" required
                   placeholder="{{__('frontend.Enter your subject')}}"
                   onfocus="this.placeholder = ''"
                   onblur="this.placeholder = '{{__('frontend.Enter your subject')}}'"
                   class="primary_input mb_20" type="text"
                   value="{{old('subject')}}">
            <span class="text-danger"
                  role="alert">{{$errors->first('subject')}}</span>
        </div>
        <div class="col-lg-12">
            <label class="primary_label">{{__('frontend.Message')}}</label>
            <textarea required class="primary_textarea mb-0" name="message"
                      placeholder="{{__('frontend.Write your message')}}"
                      onfocus="this.placeholder = ''"
                      onblur="this.placeholder = '{{__('frontend.Write your message')}}'"
            >{{old('message')}}</textarea>
            <span class="text-danger"
                  role="alert">{{$errors->first('message')}}</span>
        </div>

        <div class="col-12 mt_10 mb_20">


            @if(saasEnv('NOCAPTCHA_FOR_CONTACT')=='true')
                <input type="hidden" name="hasCaptcha"
                       value="{{saasEnv('NOCAPTCHA_FOR_CONTACT')}}">
                @if(saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                    {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                    {!! NoCaptcha::renderJs() !!}
                @else
                    {!! NoCaptcha::display() !!}
                    {!! NoCaptcha::renderJs() !!}
                @endif

                @if ($errors->has('g-recaptcha-response'))
                    <span class="text-danger"
                          role="alert">{{$errors->first('g-recaptcha-response')}}</span>
                @endif
            @endif


        </div>
        <div class="col-lg-12 text-left">
            <div class="alert-msg"></div>


            @if(saasEnv('NOCAPTCHA_FOR_CONTACT')=='true' && saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                <button type="button"
                        class="g-recaptcha theme_btn small_btn submit-btn w-100 text-center"
                        data-sitekey="{{saasEnv('NOCAPTCHA_SITEKEY')}}"
                        data-size="invisible"
                        data-callback="onSubmit"
                >
                    {{__('frontend.Send Message')}}
                </button>

                <script src="https://www.google.com/recaptcha/api.js"
                        async
                        defer></script>
                <script>
                    function onSubmit(token) {
                        document.getElementById("myForm").submit();
                    }
                </script>
            @else

                <button type="submit"
                        class="theme_btn small_btn submit-btn w-100 text-center">
                    {{__('frontend.Send Message')}}
                </button>
            @endif

        </div>
    </div>
</form>
