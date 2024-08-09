@if ($message)
     
    <div id="alert-component" class="alert alert-{{ $type }} alert-dismissible fade show " role="alert" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 99050;">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            var alert = document.getElementById('alert-component');
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    </script>
@endif