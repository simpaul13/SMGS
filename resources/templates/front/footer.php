    <script>
        $(function() {

            if ("<?php echo $_SESSION['message'] ?>") {

                Swal.fire({
                    icon: '<?php echo $_SESSION['icon'] ?>',
                    title: '<?php echo $_SESSION['title'] ?>',
                    text: '<?php echo $_SESSION['message'] ?>',
                })

            }
        });
    </script>
    </body>

    </html>