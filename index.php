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
               <img src="assets/images/png-clipart-guitar.png" width="40" height="40" role="img">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Producten</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Over ons</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-light " placeholder="Zoek product" aria-label="Search">
                </form>

                <div class="d-flex align-items-center text-end">
                    <button type="button" class="btn btn-warning me-3">Aanmelden</button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
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