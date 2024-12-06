@component('mail::message')

Hello {{$data['name']}},<br/>
<h3>Your new password is {{$data['rand_id']}}</h3>
<a href="{{url('/')}}">Click Me</a> to go to login page <br/><br/>

Thanks,<br/>
<a href="laptoponrent.biz">laptoponrent.biz</a> team
@endcomponent
