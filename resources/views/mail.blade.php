@extends('layouts.master')

@section('content')
<table style="width: 100%; max-width: 600px; margin: auto; border-collapse: collapse; font-family: Arial, sans-serif; color: #444; border: 1px solid #ddd;">
    <tr>
        <td style="background-color: #0066cc; padding: 20px; text-align: center; color: #fff;">
            <h1 style="margin: 0; font-size: 24px;">Welcome to Bulletin Board, <span style="font-weight: bold;">{{ $mailData['name'] }}</span>!</h1>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px; background-color: #f9f9f9; text-align: center;">
            <p style="font-size: 16px; margin: 0;">Your username is: <strong>{{ $mailData['name'] }}</strong></p>
            <p style="font-size: 14px; margin: 10px 0;">To get started, please reset your password using the link below.</p>
            <a href="{{ route('resetpassword.get', ['token' => $mailData['token'], 'email' => $mailData['email']]) }}" style="display: inline-block; background-color: #28a745; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; margin-top: 20px;">Reset Password</a>
            <p style="font-size: 14px; margin-top: 20px; color: #666;">If you did not request this email, please ignore it.</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px; background-color: #f8f8f8; text-align: center;">
            <p style="font-size: 14px; margin: 0; color: #999;">Thanks for joining and have a great day!</p>
            <p style="font-size: 14px; margin: 0; color: #999;">The Bulletin Board Team</p>
        </td>
    </tr>
</table>
@endsection
