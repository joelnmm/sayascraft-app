@extends('layouts.mail-base')
@section('content')
<div style="display: inline-block;">
    <div style="text-align:left;">
        <p>New contact info</p>
    </div>

    <h2 style="text-align:left;">Contact details</h2>
    <table style="width: 600px; text-align:right; margin-bottom:40px; border-bottom:1px solid #ccc;">
            <tr>
                <th>Name</th>
                <td>{{ $input['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $input['email']}}</td>
            </tr>
            <tr>
                <th>Subject</th>
                <td>{{ $input['subject'] }}</td>
            </tr>
            <tr>
                <th>Message</th>
                <td>{{ $input['message']}}</td>
            </tr>
    </table>
</div>

@endsection
