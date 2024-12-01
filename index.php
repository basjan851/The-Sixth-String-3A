<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for layout */
        html, body {
            height: 100%;
        }
        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1; /* Fills remaining space between header and footer */
        }
        .standard-height {
            min-height: 600px; /* Adjust this to your standard size */
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->
    <header class="bg-primary text-white p-3">
        <h1>Header</h1>
    </header>

    <!-- Content -->
    <main class="content">
        <div class="container standard-height">
            <h2>Page Content</h2>
            <p>
                This content will expand if it exceeds the standard height of 600px.
                Add more content here to see the effect.
            </p>
            <p>More content...</p>
            <p>More content...</p>

        </div>
    </main>d

    <!-- Footer -->
    <footer class="bg-dark text-white p-3">
        <p class="mb-0">Footer Content</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>