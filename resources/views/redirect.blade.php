<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <script>
    window.Shopify = {
        API_KEY: '{{ $API_KEY }}',
        SHOP_ORIGIN: '{{ $SHOP_ORIGIN }}',
        REDIRECT_URI: '{{ $REDIRECT_URI }}'
    };
    </script>

    <script src="{{ asset('vendor/shopify-app/redirect.js') }}" async></script>
</head>

<body>
    <div id="App" />
</body>

</html>
