@component('mail::message')
{{-- Verification from <a href="laptoponrent.biz">laptoponrent.biz</a> --}}

Hello {{$data['name']}},<br/>
<h3>Thank you for your registration.  Please click a verification link below to complete the registration.</h3><br/>
<a href="{{url('/verification/'.$data['rand_id'])}}">CLICK HERE VERIFY</a><br/><br/>


Thanks,<br/>
<a href="laptoponrent.biz">laptoponrent.biz</a> team
@endcomponent

