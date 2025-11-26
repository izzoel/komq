<!DOCTYPE html>
<html>

<head>
    <title>Admin Verification</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-image: url('{{ asset('images/quiz-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const name = "admin";
        Swal.fire({
            title: "Sst.. Passwordnya?",
            text: "Masukkan password untuk akses sistem KOMQ",
            input: "password",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "Login",
            showLoaderOnConfirm: true,
            preConfirm: async (password) => {
                try {
                    const response = await $.ajax({
                        url: "/login",
                        method: "POST",
                        data: {
                            name: name,
                            password: password,
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        dataType: "json",
                    });

                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(() => {
                            window.location.href = "/admin";
                        });
                    } else {
                        Swal.showValidationMessage(`Password Salah!`);
                    }
                } catch (error) {
                    let msg = "Terjadi kesalahan. Silakan coba lagi.";

                    if (error.responseJSON?.message) {
                        msg = error.responseJSON.message;
                    } else if (error.statusText) {
                        msg = "Error: " + error.statusText;
                    }

                    Swal.showValidationMessage(msg);
                }

            },
        });
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {

        @if (isset($gagal))
        Swal.fire({
        icon: "error",
        title: "Password salah!",
        confirmButtonText: "Coba lagi"
        }).then(() => askPassword());
        @else
        askPassword();
        @endif

        });

        function askPassword() {
        Swal.fire({
        title: "Masukkan Password Admin",
        input: "password",
        inputPlaceholder: "Password",
        allowOutsideClick: false,
        confirmButtonText: "Verifikasi"
        }).then(result => {
        if (result.value !== null) {
        let form = document.createElement('form');
        form.method = 'GET'; // GET supaya tidak reload POST ulang
        form.action = "/admin";

        let pass = document.createElement('input');
        pass.type = 'hidden';
        pass.name = 'pass';
        pass.value = result.value;

        form.appendChild(pass);
        document.body.appendChild(form);
        form.submit();
        }
        });

        });
        }
    </script> --}}

</body>

</html>
