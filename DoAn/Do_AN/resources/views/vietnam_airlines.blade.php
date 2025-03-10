<!-- resources/views/vietnam_airlines.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Vietnam Airlines</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
</head>

<body class="font-roboto">
    @include('partials.header')

    <main>
        <section class="relative">
            <img src="https://storage.googleapis.com/a1aa/image/PZkvokKsyEKNQbLRS4fNUF2KroZx7WkpIa--mL4CEcc.jpg"
                alt="Cityscape with fireworks" class="w-full h-96 object-cover">
        </section>

        <section class="bg-teal-700 py-4">
            <div class="container mx-auto flex justify-center space-x-4">
                <a href="http://127.0.0.1:8000/search" class="inline-block bg-teal-800 text-white py-2 px-4 rounded hover:bg-teal-900 transition-colors">
                    MUA VÉ
                </a>
                <button class="bg-teal-800 text-white py-2 px-4 rounded">QUẢN LÝ ĐẶT CHỖ</button>
                <button class="bg-teal-800 text-white py-2 px-4 rounded">LÀM THỦ TỤC</button>
            </div>
        </section>

        @include('partials.flights')

        <section class="fixed bottom-4 right-4">
            <button class="bg-teal-700 text-white py-2 px-4 rounded-full flex items-center space-x-2">
                <i class="fas fa-comments"></i>
                <span>Chat với NEO</span>
            </button>
        </section>
    </main>

    @include('partials.footer')

</body>

</html>
