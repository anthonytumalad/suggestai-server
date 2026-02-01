<!DOCTYPE html>
<html>
<head>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div
        id="app"
        data-form="{{ json_encode($form) }}"
        data-email="{{ $userEmail }}"
    >
    </div>
</body>
</html>
