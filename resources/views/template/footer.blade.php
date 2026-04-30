<footer class="main-footer">
    <div class="footer-left">
        &copy; {{ date('Y') }} SiEcoCycle
        <div class="bullet"></div>
        Login sebagai: <strong>{{ Auth::user()->name }}</strong>
    </div>
    <div class="footer-right">
        RW {{ Auth::user()->rw_name ?? '-' }}
    </div>
</footer>