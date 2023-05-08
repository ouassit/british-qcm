<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your App Title Here</title>
    <base href="/">
    <link rel="stylesheet" src="{{ asset('client/styles.css') }}" />
</head>
<body>
    <app-root></app-root>
    <script src="{{ asset('client/runtime.js') }}"></script>
    <script src="{{ asset('client/polyfills.js') }}"></script>
    <script src="{{ asset('client/vendor.js') }}"></script>
    <script src="{{ asset('client/main.js') }}"></script>
</body>
</html>
