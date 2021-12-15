<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Markdown Example Larabit</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.4.x/dist/typography.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="grid grid-cols-2 gap-x-2 h-screen">
    <div class="border">
        <textarea id="markdown" class="h-full w-full outline-none"></textarea>
    </div>
    <div class="border">
        <div id="html" class="prose"></div>
    </div>
</div>
<script>
    let markdownTextarea = () => document.querySelector('#markdown');
    let convert          = () => {
        let markdown = markdownTextarea().value;
        axios.post('/markdown', {markdown})
            .then(response => {
                document.querySelector('#html').innerHTML = response.data;
            });

        localStorage.setItem('markdown', markdown);
    }

    let init = () => {
        markdownTextarea().value = localStorage.getItem('markdown');
        setInterval(convert, 200);
    }

    init();

</script>
</body>
</html>
