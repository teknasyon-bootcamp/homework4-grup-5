<?php

require_once "post.class.php";
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>POST YÖNETİM SAYFASI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>



    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card mt-3 bg-light">
                    <div class="row">
                        <div class="col-4 card-body ">
                            <h2>POST YÖNETİM SAYFASI</h2>
                            Aşağıdaki listede post başlıklarına tıklayarak post içeriğine ulaşabilir ve gerekli düzenlemeleri yapabilirsiniz.<br>
                            <br>


                            <?php

                            $db = new Post();

                            //php2.members tablosuna VERİ EKLEME
                            if (isset($_POST["mySubmit"])) {
                                $postTitle = $_POST["post_title"];
                                $postContent = $_POST["post_content"];




                                $add = $db->Insert("INSERT INTO posts(post_title,post_content) VALUES (?,?)", array($postTitle, $postContent));


                                if ($add) {
                                    $message = "Kayıt Eklendi";
                                    header("Location: manage.php?info=$message");
                                } else {
                                    $message = "Kayıt Eklenemedi";
                                    header("Location: manage.php?info=$message");
                                }
                            }

                            //odev.posts tablosuna VERİ UPDATE
                            if (isset($_POST["mySubmitUpdate"])) {
                                $postID = $_POST["post_id"];
                                $postTitle = $_POST["post_title"];
                                $postContent = $_POST["post_content"];

                                $update = $db->Update("UPDATE posts SET
                                    post_title=?,
                                    post_content=?
                                    WHERE post_id=?
                                    ", array($postTitle, $postContent,  $postID));


                                if ($update) {
                                    $message = "Kayıt Güncellendi";
                                    header("Location: manage.php?info=$message&postid=$postID");
                                } else {
                                    $message = "Kayıt Güncellenemedi";
                                    header("Location: manage.php?info=$message&postid=$postID");
                                }
                            }


                            //odev.posts tablosuna VERİ DELETE
                            if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["post"])) {

                                $postID = $_GET["post"];
                                echo $postID . " sad";
                                $delete = $db->Delete("DELETE FROM posts
                                    WHERE post_id=?
                                    ", array($postID));

                                if ($delete) {
                                    $message = "Post Silindi";
                                    header("Location: manage.php?info=$message");
                                } else {
                                    $message = "Post Silinemedi";
                                    header("Location: manage.php?info=$message");
                                }
                            }


                            ?>

                            <!--ÇOKLU SATIRLARDAKİ VERİLERİN ÇEKİLMESİ-->
                            <h5>POST LİSTESİ | <a class="text-danger text-decoration-none" href="index.php">Ana sayfaya git</a> | <a href="<?= $_SERVER['PHP_SELF'] ?>?action=create"><button class="btn btn-success">POST OLUŞTUR</button></a> | <a href="<?= $_SERVER['PHP_SELF'] ?>"><button class="btn btn-success">TEMİZLE</button></a></h5>

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
                                            <td><a class="text-dark text-decoration-none" href="<?= $_SERVER['PHP_SELF'] . "?action=edit&post=" . $items->post_id ?>"><?php echo $items->post_title ?></a></td>
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


                            <!-- NEW FORM BAŞLANGIÇ -->
                            <?php
                            if (isset($_GET["action"]) && $_GET["action"] == "create") {
                                echo '<h5 class="bg-dark text-light p-3 ">POST OLUŞTUR</h5><br>';

                            ?>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">


                                    <div class="form-group row">
                                        <label for="post_title" class="col-sm-2 col-form-label">Başlık</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="post_title" id="post_title" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="post_content" class="col-sm-2 col-form-label">İçerik</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="post_content" id="post_content" value="">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="mySubmit">Yeni Post Oluştur</button>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                            <!--NEW FORM BİTİŞ -->


                            <!-- UPDATE FORM BAŞLANGIÇ -->
                            <?php
                            if (isset($_GET["post"]) && isset($_GET["action"])) {
                                echo '<h5 class="bg-dark text-light p-3 ">POST GÜNCELLE</h5><br>';

                                $getID = isset($_GET["post"]) ? intval($_GET["post"]) : null;

                                $posts = $db->getRow("SELECT*FROM posts WHERE post_id=?", array($getID));

                            ?>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">


                                    <input type="hidden" class="form-control" name="post_id" id="post_id" value="<?php echo $posts->post_id ?>">



                                    <div class="form-group row">
                                        <label for="post_title" class="col-sm-2 col-form-label">Başlık</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="post_title" id="post_title" value="<?php echo $posts->post_title ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="post_content" class="col-sm-2 col-form-label">İçerik</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="post_content" id="post_content" value="<?php echo $posts->post_content ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="mySubmitUpdate">Güncelle</button>

                                        </div>
                                    </div>
                                </form>
                                <a href="<?= $_SERVER['PHP_SELF'] ?>?action=delete&post=<?php echo $posts->post_id ?>"><button class="btn btn-danger">Sil</button></a>
                            <?php
                            }
                            ?>
                            <!--UPDATE BİTİŞ  -->
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>