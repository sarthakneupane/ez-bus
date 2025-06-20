<style>
    /* footer {
    position: fixed;
    height: 100px;
    bottom: 0;
    width: 100%;
} */
    .footer {
        /* position: fixed; */
        background-color: #2c2c2c;
        color: white;
        width: 100%;
        bottom: 0;
    }

    .footer a {
        color: #dcdcdc;
    }

    .footer a:hover {
        text-decoration: underline;
        color: #ffffff;
    }

    .footer .footer-title {
        font-size: 1.4rem;
        font-weight: bold;
    }

    .footer .footer-links {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .footer .copyright {
        border-top: 1px solid #444;
        padding-top: 10px;
        margin-top: 20px;
        font-size: 0.9rem;
    }
</style>



    <footer class="footer mt-5 pt-4 pb-2">
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap">
                <div>
                    <div class="footer-title">EZ-Bus</div>
                    <p class="mb-0">Your Destination, Our Determination.</p>
                </div>
                <div class="footer-links align-self-start">
                    <a href="{{ url('/about') }}" class="text-decoration-none">About Us</a>
                    <a href="#" class="text-decoration-none">Terms</a>
                    <a href="#" class="text-decoration-none">Privacy</a>
                </div>
            </div>
            <div class="text-center copyright mt-3">
                &copy; {{ date('Y') }} EZ-Bus. All rights reserved.
            </div>
        </div>
    </footer>

