@extends('customer.main')
@section('title', 'User Dashboard')
@section('content')
    @include('customer.navbar')
    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Rental List</div>
                    <div class="card-body">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subscription Start</th>
                                    <th scope="col">Subscription End</th>
                                    <th scope="col">Rent</th>
                                    <th scope="col">Agreement</th>
                                    <th scope="col">Show all rental details</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($rental['item'])}} --}}
                            @if (empty($rental))
                                <tr>
                                    <th colspan="6" class="text-center h3 p-5">No subscription assigned!</th>
                                </tr>
                            @else
                                @foreach ($rental as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ empty($item->subscription_date) ? ' Not Availble' : date('d M, Y', strtotime($item->subscription_date)) }}
                                        </td>
                                        <td>
                                            {{ empty($item->subscription_date_end) ? ' Until Cancelled' : date('d M, Y', strtotime($item->subscription_date_end)) }}
                                        </td>
                                        <td>&#8377; {{ number_format($item->total_amount, 2) }}/{{ $item->time_period }}</td>
                                        <td>
                                            <a href="{{ route('customer.rental.show', $item->id) }}">
                                                {!! (empty($item->agreement_sign)
                                                    ? '<b class="text-danger">Click to sign</b>'
                                                    : '<b class="text-success">Singed on ' .
                                                        date('d M, Y h:m:s', str_replace(['sign/agreement_', '.png'], '', $item->agreement_sign))) . '</b>' !!}
                                        </td>
                                        </a>
                                        <td>
                                            <a href="{{ route('customer.rental.show', $item->id) }}">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
