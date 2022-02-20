    <script>
        $(function() {

            if ("<?php echo $password; ?>" == "incorrect") {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Username or Password Incorrect'
                })

            } else if ("<?php echo $completesignup; ?>" == "registered") {

                Swal.fire({
                    icon: 'success',
                    title: 'Successful',
                    text: 'You Have Successfully Registered'
                })

            } else if ("<?php echo $completesignup; ?>" == "inscribe") {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'It seems ready have registered'
                })

            } else if ("<?php echo $completesignup; ?>" == "username") {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'It Seems username have been Taken'
                })

            } else if ("<?php echo $completesignup; ?>" == "email") {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'It Seems email have been Taken'
                })

            }
        });
    </script>
    </body>

    </html>