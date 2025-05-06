{{-- resources/views/pembeli/pembayaran/snap.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <script type="text/javascript">
        window.onload = function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert('Pembayaran berhasil!');
                    window.location.href = "{{ url('/') }}";
                },
                onPending: function (result) {
                    alert('Menunggu pembayaran...');
                    window.location.href = "{{ url('/') }}";
                },
                onError: function (result) {
                    alert('Pembayaran gagal!');
                    window.location.href = "{{ url('/') }}";
                },
                onClose: function () {
                    alert('Transaksi dibatalkan.');
                }
            });
        }
    </script>
</body>
</html>
