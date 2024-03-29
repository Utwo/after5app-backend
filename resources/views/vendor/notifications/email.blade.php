﻿<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'table-wrap' => 'max-width:700px; margin: 0 auto',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

    /* Masthead ----------------------- */

    'email-masthead-left' => 'padding: 25px 0 25px 25px; background-color: #7874dc; border-radius: 5px 0 0 0;',
    'email-masthead-right' => 'padding: 25px 25px 25px 0; background-color: #7874dc; border-radius: 0 5px 0 0; text-align:right; color: #fff;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 #fff;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;border-radius: 0 0 5px 5px;',
    'email-body_inner' => 'width: 100%; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'width: 100%; max-width: 700px; margin: 25px auto 0; padding: 0 25px; border-top: 1px solid #EDEFF2; background: #F2F4F6; text-align: center;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #85879e; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #484848; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; min-height: 20px; padding: 10px 60px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 17px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #50e3c2;',
];
?>

<?php $fontFamily = 'font-family: Roboto, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
    <table width="100%" cellpadding="0" cellspacing="0" style="{{ $style['table-wrap'] }}">
        <tr>
            <td style="{{ $style['email-wrapper'] }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td style="{{ $style['email-masthead-left'] }}">
                            <a style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}" href="{{ config('app.url') }}" target="_blank">
                                <img border="0" src="http://after5app.co/assets/svg/logo.svg" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;width: 100%;max-width: 121px" width="121">
                            </a>
                        </td>
                        <td style="{{ $style['email-masthead-right'] }}">
                            <span>Boarding Pass Accepted!</span>
                            <img border="0" src="http://after5app.co/assets/svg/febee.svg" alt="Febee" title="Febee" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline !important;border: none;height: auto;width: 100%;max-width: 45px; vertical-align: middle; padding: 0 0 0 10px;" width="45">
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td colspan="2" style="{{ $style['email-body'] }}" width="100%">
                            <table style="{{ $style['email-body_inner'] }}" align="center" width="700" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <h1 style="{{ $style['header-1'] }}">
                                            @if (! empty($greeting))
                                                {{ $greeting }}
                                            @else
                                                @if ($level == 'error')
                                                    Whoops!
                                                @else
                                                    Hello!
                                                @endif
                                            @endif
                                        </h1>

                                        <!-- Intro -->
                                        @foreach ($introLines as $line)
                                            <p style="{{ $style['paragraph'] }}">
                                                {{ $line }}
                                            </p>
                                        @endforeach

                                        <!-- Action Button -->
                                        @if (isset($actionText))
                                            <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center">
                                                        <?php
                                                            switch ($level) {
                                                                case 'success':
                                                                    $actionColor = 'button--green';
                                                                    break;
                                                                case 'error':
                                                                    $actionColor = 'button--red';
                                                                    break;
                                                                default:
                                                                    $actionColor = 'button--blue';
                                                            }
                                                        ?>

                                                        <a href="{{ $actionUrl }}"
                                                            style="{{ $fontFamily }} {{ $style['button'] }} {{ $style[$actionColor] }}"
                                                            class="button"
                                                            target="_blank">
                                                            <b>{{ $actionText }}</b>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        <!-- Outro -->
                                        @foreach ($outroLines as $line)
                                            <p style="{{ $style['paragraph'] }}">
                                                {{ $line }}
                                            </p>
                                        @endforeach

                                        <!-- Salutation -->
                                        <p style="{{ $style['paragraph'] }}">
                                            Regards,<br>{{ config('app.name') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td colspan="2">
                            <!-- Sub Copy -->
                            @if (isset($actionText))
                                <table style="{{ $style['body_sub'] }}">
                                    <tr>
                                        <td style="{{ $fontFamily }}">
                                            <p style="{{ $style['paragraph-sub'] }} {{ $style['paragraph-center'] }}">
                                                If you’re having trouble clicking the "{{ $actionText }}" button,
                                                copy and paste the URL below into your web browser: <a style="{{ $style['anchor'] }}" href="{{ $actionUrl }}" target="_blank">
                                                    {{ $actionUrl }}
                                                </a>
                                            </p>
                                            <p style="{{ $style['paragraph-sub'] }} {{ $style['paragraph-center'] }}">
                                                &copy; {{ date('Y') }}
                                                <a style="{{ $style['anchor'] }}" href="{{ config('app.url') }}" target="_blank">{{ config('app.name') }}</a>.
                                                All rights reserved.
                                            </p>
                                        </td>
                                        <td style="width: 32px">
                                            <p style="{{ $style['paragraph-sub'] }} {{ $style['paragraph-center'] }}">
                                                <a style="{{ $fontFamily }}" href="{{ config('app.url') }}" target="_blank">
                                                    <img border="0" src="http://after5app.co/assets/png/facebook.png" alt="facebook" title="facebook page" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;width: 100%;max-width: 32px" width="32">
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
