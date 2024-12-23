<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$str_cod_empresa = 'cod_empresa';
if ($_SESSION[$str_cod_empresa] == NULL) {
    header("Location:../index.php");
}
?>
<html lang="en" class="no-js">


    <?php include('../../corpo/header.php'); ?>
    <link rel="stylesheet" href="../../../includes/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../../../css/style_crud.css" >
    <link rel="stylesheet" href="../../../css/jquery.bootstrap.message.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>

    <?php include('../../corpo/banner.php'); ?>

    <div class="wrapper">
        <div class="canvas">
            <!-- Aqui fica o menu escondido -->

            <?php include('../../corpo/menu.php'); ?>


            <div class="container">

                <div class="table-wrapper">

                    <div class="table-wrapper-scroll-y" >

                        <!-- line chart canvas element -->
                        <canvas id="buyers" width="600" height="400"></canvas>
                        <!-- pie chart canvas element -->
                        <canvas id="countries" width="600" height="400"></canvas>
                        <!-- bar chart canvas element -->
                        <canvas id="income" width="600" height="400"></canvas>


                    </div>
                </div>
            </div>     


        </div>			
    </div>

    <?php include('../../corpo/footer.php'); ?>
    <script src="../../../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
    <script src="../../../js/jquery.validate.min.js"></script>
    <script src="../../../includes/js/bootstrap.min.js" ></script>
    <script src="../../../js/bootbox.js"></script>
    <script>
        // line chart data
        var buyerData = {
            labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho"],
            datasets: [
                {
                    fillColor: "rgba(172,194,132,0.4)",
                    strokeColor: "#ACC26D",
                    pointColor: "#fff",
                    pointStrokeColor: "#9DB86D",
                    data: [203, 156, 99, 251, 305, 247]
                }
            ]
        }
        // get line chart canvas
        var buyers = document.getElementById('buyers').getContext('2d');
        // draw line chart
        new Chart(buyers).Line(buyerData);
        // pie chart data
        var pieData = [
            {
                value: 20,
                color: "#878BB6"
            },
            {
                value: 40,
                color: "#4ACAB4"
            },
            {
                value: 10,
                color: "#FF8153"
            },
            {
                value: 30,
                color: "#FFEA88"
            }
        ];
        // pie chart options
        var pieOptions = {
            segmentShowStroke: false,
            animateScale: true
        }
        // get pie chart canvas
        var countries = document.getElementById("countries").getContext("2d");
        // draw pie chart
        new Chart(countries).Pie(pieData, pieOptions);
        // bar chart data
        var barData = {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
                {
                    fillColor: "#48A497",
                    strokeColor: "#48A4D1",
                    data: [456, 479, 324, 569, 702, 600]
                },
                {
                    fillColor: "rgba(73,188,170,0.4)",
                    strokeColor: "rgba(72,174,209,0.4)",
                    data: [364, 504, 605, 400, 345, 320]
                }
            ]
        }
        // get bar chart canvas
        var income = document.getElementById("income").getContext("2d");
        // draw bar chart
        new Chart(income).Bar(barData);
    </script>
</body>
</html>