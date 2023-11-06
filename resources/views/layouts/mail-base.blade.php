<!DOCTYPE html>
<html lang="en" style="justify-content: center;">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Order Confirmation</title>
    </head>

    <header id="header" style="background-color: #ad0c0c; height:100px;">
        <div style="padding-top:5px; padding-left:10px;">
            <a href="https://sayascraft.com/" style=" color:white; font-size: 15px; font-family: 'Montserrat', sans-serif; text-decoration:none; -webkit-text-stroke-width: 0.5px; -webkit-text-stroke-color: black;">
                <h1>Saya's Craft<span></span></h1>
            </a>
        </div>
    </header>
    <!-- End Header -->


    <!-- Page Content  -->
    <div id="content" style="text-align: center">
        <!-- Here goes the content of each mail -->
        @yield('content')

    </div>


   <!-- ======= Footer ======= -->
   <footer style="background-color: #ad0c0c; height:fit-content; color:white; padding:10px 10px 10px 10px; margin-top:20px;">

    <div class="container">

        <div >
            <a href="https://sayascraft.com/" style="text-decoration:none; color:white;">
            <strong>Saya's Craft</strong>
            </a>
            <p>Handmade crafts from Ecuador. Create your own bracelet or shop our variety of textile crafts that we have for you</p>
        </div>

        <table style="width:100%;">
            <td>
                <div style="text-align:center;">
                    <h4>Contact Us</h4>
                    <p style="color:white;">
                        <strong>Phone:</strong> +1 3104866870<br>
                        <strong>Email:</strong> <a style="color:black">sayasecucraft@gmail.com</a><br>
                    </p>
                </div>
            </td>

            <td>
                <div>
                    <h4 >Location</h4>
                    <p>
                        Los Angeles, LA <br>
                        United States <br>
                    </p>
                    <!-- <p>
                        Otavalo<br>
                        Ecuador <br>
                    </p> -->
                </div>
            </td>
        </table>

    </div>

    <div style="text-align:center;">
        <div class="copyright">
            &copy; Copyright <strong><span>Saya's Craft</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a style="text-decoration:none; color:white;" href="https://sayascraft.com/">Vstudios</a>
        </div>
    </div>

    </footer><!-- End Footer -->

</html>