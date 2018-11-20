<html>
    <head>
        <style>
            /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            Our Code World
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
          <?php
                  $url = site_url('TrialBalance/connect');
                  $ch  = curl_init();
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_URL, $url);
                  $result = curl_exec($ch);
                  curl_close($ch);
                  $obj = json_decode($result, true);

                  $ReportName = $obj["Reports"]["Report"]["ReportName"];
                  $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
                  $Row        = $obj["Reports"]["Report"]["Rows"]["Row"];

          ?>
          <table width="100%" cellspacing="0" cellpadding="0" >
            <?php
                    foreach ($Row as $key => $value){
                        if ($value['RowType'] == "Header") {
                            $cellheader = $value['Cells']['Cell'];
            ?>
            <tr class="<?php
                            echo $value['RowType'];
            ?>">
               <td>Account Type</td>
            <?php
                            foreach ($cellheader as $key => $cellexpand) {
            ?>
                  <td><?php
                                echo $cellexpand['Value'];
            ?></td>
            <?php
                            }
            ?>

            </tr>
            <?php
                        } elseif (isset($value['Title'])) {
                            $getRow = $value['Rows']['Row'];

                            foreach ($getRow as $key => $cellvalue) {

                                if ($cellvalue['RowType'] == "Row") {
                                    $getCells = $cellvalue['Cells']['Cell'];
                                    echo "<tr>";
                                    echo "<td>" . $value['Title'] . "</td>";
                                    foreach ($getCells as $key => $cellvaluesmany) {
                                        if (isset($cellvaluesmany['Value'])) {
                                            echo "<td>" . $cellvaluesmany['Value'] . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                                    }

                                    echo "<tr>";
                                }

                            }

                        } else {
            ?>
                <tr>
                    <td>&nbsp;</td>
                    <?php
                            $celltotal = $value['Rows']['Row']['Cells']['Cell'];
                            foreach ($celltotal as $key => $cellprint) {
                                echo "<td>" . $cellprint['Value'] . "</td>";
                            }

            ?>


                </tr>
                <?php
                        }
                      }
            ?>
          </table>

        </main>
    </body>
</html>
