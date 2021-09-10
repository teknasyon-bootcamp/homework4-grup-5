<?php

require_once "post.class.php";
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>POST SAYFASI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>



    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card mt-3 bg-light">

                    <div class="row">
                        <div class="col-4 card-body ">
                            <h2>POST</h2>
                            Aşağıdaki listede post başlıklarına tıklayarak post içeriğine ulaşabilirsiniz.<br>
                            <br>


                            <?php

                            $db = new Post();





                            ?>

                            <!--ÇOKLU SATIRLARDAKİ VERİLERİN ÇEKİLMESİ-->
                            <h5>POST LİSTESİ | <a class="text-danger text-decoration-none" href="manage.php">Yönetim sayfasına git</a></h5>

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">POST BAŞLIĞI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $myQuery = $db->getRows("SELECT*FROM posts");






                                    foreach ($myQuery as $items) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $items->post_id ?></th>
                                            <td><a class="text-dark text-decoration-none" href="<?= $_SERVER['PHP_SELF'] . "?postid=" . $items->post_id ?>"><?php echo $items->post_title ?></a></td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="mx-auto col-6 card-body">

                            <!-- INFO MESAJ GÖSTERİMLERİ BAŞLANGIÇ-->
                            <?php
                            if (isset($_GET["info"])) {
                                echo '<h5 class="bg-dark text-warning p-3 ">' . $_GET["info"] . '</h5><br>';
                            }
                            ?>
                            <!-- INFO MESAJ GÖSTERİMLERİ BİTİŞ-->

                            <?php

                            if (isset($_GET["postid"])) {
                                echo '<h5 class="bg-dark text-light p-3 ">POST İÇERİĞİ</h5><br>';
                                $getID = $_GET["postid"];
                                $myQuery = $db->getRow("SELECT*FROM posts WHERE post_id=? ", array($getID));
                                if (!$myQuery->post_id) {
                                    $message = "Böyle bir post yok!";
                                    header("Location: index.php?info=$message");
                                }
                                echo "<h4>" . $myQuery->post_title . "</h4><hr>";
                                echo $myQuery->post_content;
                            }

                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>