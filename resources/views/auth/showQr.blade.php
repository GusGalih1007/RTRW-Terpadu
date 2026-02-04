<center>
    <img id="qrImage" src="{{ asset('storage/' . $user->qrImage) }}" width="300" alt="{{ $user->username }}"><br>
    <button onclick="downloadQR()">Save</button><span>  </span><a href="{{ route('auth.login') }}"><button>Next</button></a>
</center>

<script>
function downloadQR() {
    const image = document.getElementById('qrImage');
    const link = document.createElement('a');
    link.href = image.src;
    link.download = '{{ $user->username }}_qr_code.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
