<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sixth String</title>
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

    <header class="p-3 text-bg-dark">
        <div class="container">

            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <img src="assets/images/png-clipart-guitar.png" alt="Guitar logo" width="60" height="60">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">About</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
                </form>

                <div class="text-end">
                    <button type="button" class="btn btn-outline-light me-2">Login</button>
                    <button type="button" class="btn btn-warning">Sign-up</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">
        <div class="container standard-height">
            <h2>Home Page</h2>


        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white p-4">
        <p class="mb-0">Footer Content</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>