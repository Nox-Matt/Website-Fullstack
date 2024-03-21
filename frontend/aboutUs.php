<!DOCTYPE html>
<html>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Russo+One&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Hanalei+Fill&display=swap");
</style>

<head>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noxmourth || All About Gaming</title>
    <style>
        .controller {
  padding: 20px;
  height: 160px;
  width: 160px;
  border-radius: 80%;
}
h1.title {
  transition: 0.5s;
  color: rgb(255, 255, 255);
  background: rgb(52, 16, 48);
  position: relative;
  opacity: 80%;
  text-align: center;
  padding-bottom: 20px;
}
h1.title-1 {
  size: 2em;
  transition: 0.5s;
  color: rgb(11, 10, 10);
  position: relative;
  opacity: 90%;
  text-align: center;
  padding-bottom: 20px;
}
.container-aboutme {
  display: grid;
  align-items: center;
  grid-template-columns: 1fr 1fr 1fr;
  column-gap: 5px;
}
img.potrait {
  align-content: right;
  max-width: 100%;
  max-height: 100%;
  width: 100%px;
  border-radius: 10%;
  border: 5px solid rgb(147, 147, 147);
}
p.text {
  font-size: 24px;
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
}
a.goLink {
  padding: 20px 20px;
  display: inline-block;
  color: #000000;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-decoration: none;
  font-size: 1em;
  overflow: hidden;
}
/*creating animation effect*/
a.goLink:hover {
  color: rgb(255, 255, 255);
  background: #000000;
  box-shadow: 0 0 50px #000000;
  transition: 0.5s;
  text-transform: uppercase;
  text-decoration: none;
}

    </style>
</head>
<body class="aboutMe-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 boxpage">
                <div class="container-fluid"></div>
                <div class="container-fluid">
                    <h2><u>Who Am I?</u></h2>
                    <p class="text">
                        Hey, my name is Andreas Matthew. Iam currently 20 Years Old
                        <br />
                        <br />
                        Iam one of the Informatic Students in, Universitas Krida Wacana
                        for their 2020 Class, Currently taking the third semester, in the
                        course.
                        <br />
                        Iam making this website as an assignment for my final project in
                        Web Developing course, as requirement to pass the final bar.
                        <br />
                        <br />
                        Hope you Enjoy Your Stay
                    </p>
                </div>
                <a href="somethingfun.php" class="goLink">Thank you For Visiting</a>
                <br>
                <a href="adminRequest.php" class="goLink">Want to be an admin?</a>
            </div>
            <div class="col-4 boxpage">
                <h1 class="neonText-Update">My Potrait</h1>
                <br />
                <img class="potrait" src="../img/Andreas-Potrait.png" />
            </div>
        </div>
    </div>
</body>
<br>
<br>
<br>
<br>
<br>
<footer class="bg-dark text-center text-white">
    <?php include("../components/footer.php"); ?>
</footer>
</html>