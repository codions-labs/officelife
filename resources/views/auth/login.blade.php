@extends('app')

@section('content')
<div class="ph2 ph0-ns">
    <div class="cf mt4 mw7 center br3 mb3 bg-white box">
        <div class="fn fl-ns w-50-ns pa3">
            Login
        </div>
        <div class="fn fl-ns w-50-ns pa3">
            <!-- Form Errors -->
            <errors :errors="$page.errors" />

            <form>
                <input name="'email'" label="$t('auth.register_email')" required="true" />
                <input name="'password'" type="password" label="$t('auth.register_password')" required="true" />

                <!-- Actions -->
                <div class="flex-ns justify-between">
                    <loading-button :classes="'btn add w-auto-ns w-100 mb2 pv2 ph3'" :state="loadingState" :text="$t('auth.login_cta')" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection