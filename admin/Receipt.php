<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Receipt</title>
    <link rel="icon" href="../img/Header-Pic/rommel-logo-v3.svg">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .receipt {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-logo {
            max-height: 50px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table th,
        .table td {
            background-color: #fff;
        }

        .table>:not(caption)>*>* {
            border: none;
        }


        .table>tbody {
            border-top: 1px solid #c8c3be;
            border-bottom: 1px solid #c8c3be;
        }

        .logo-top .img-fluid {
            width: 30%;
        }

        .dashed-line {
            border: 2px dashed gray;
        }

        .p-num {
            font-size: 3rem;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="receipt">


        <div class="text-center logo-top mb-4">
            <img class="img-fluid" src="img/rommel-logo-v3.svg" alt="Logo" class="company-logo" />

            <p class="mb-0">

                MQ68+36P, Onjianco Street, Guimba, Nueva Ecija<br>
                Phone number: +639 1234 5678
                <br>
                VAT REG TIN: 123445678
            </p>


        </div>



        <div class="row mb-4">
            <div class="col-md-6 d-grid">

                <h1>INVOICE</h1>
                <small>No. #123456</small>


                <br>

                <h6>Bill To:</h6>
                <p class="mb-0">
                    John Doe<br>
                </p>
            </div>

            <div class="col-md-6 d-grid text-end">
                <p class="mb-0">
                    Date: March 4, 2024


                </p>
                <div>
                    <h6>Payment Method:</h6>
                    <p class="mb-0">Gcash
                    </p>
                </div>


            </div>


        </div>

        <!-- Items Table -->
        <table class="table  mb-4">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th class="text-center">Downpayment(50%)</th>
                    <th class="text-end"> Payment</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Graduate</td>
                    <td class="text-center"> &#8369;500</td>
                    <td class="text-end"> &#8369;500.00</td>
                    <td class="text-end"> &#8369;1000.00</td>
                </tr>

            </tbody>
        </table>

        <hr class="dashed-line">
        <div class="text-center py-4">
            <h3>APPOINTMENT NUMBER</h3>
            <span class="p-num">#4</span>


            <!-- <div class="d-flex justify-content-flex-start ">
                <p class="mb-0">
                    Date: March 4, 2024
                </p>
                <br>
                <p class="mb-0">
                    Time: 2:00 PM
                </p>
            </div> -->

        </div>



        <!-- Footer -->
        <div class="mt-4 pt-4 border-top text-center text-muted">
            <p>Thank you for your purchase!</p>
            <p>If you have any questions, contact us at support@company.com</p>
        </div>




    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>