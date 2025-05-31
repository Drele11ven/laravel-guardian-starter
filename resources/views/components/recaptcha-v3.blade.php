<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: '{{ $action }}' })
                .then(function (token) {
                    document.getElementById('recaptcha-token').value = token;
                });
        });
    </script>
</div>