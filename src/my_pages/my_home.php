<?php
require_once  '../class/sql.class.php';
require_once  '../class/session_start.php';

$title = 'my_home';
$js_source = ['../js/webcam.js', '../js/buttons_functions.js', '../js/delete_image.js'];

if (isset($_SESSION['user_id']))
{

 echo '<div id="alert"></div>';
  require_once 'nav_bar.php';
?>
<section>
<div class="usearea_container">
  <div class="image_publish">
    <div class="row">
      <img  src="" id="photo" alt="photo">
    </div>
    <div class="row buttons-row">
      <div class="buttons col-md-12">
        <button type="submit" id="publishbutton" class="col-md-6  btn-success" style="color:green" onclick="add_photogallery()"><b>Publish</b></button>
        <button type="submit" id="deletebutton" class="col-md-6  btn-danger" style="color:red" onclick="cancel_photogallery()"><b>Cancel</b></button>
      </div>
    </div>
  </div>
</div>
<div class="container">
<div class="col-md-6">
  <div class="row">
  <h1 class="extra_h1"style="color:brown"><b>camera
  
  <img style="float:right" src="../css_resources/images/giphy.gif" width="45">
  </b></h1>
    <div class="div_take_photo">
      <video id="video"></video>
      <canvas id="canvas"></canvas>
      <div class="buttons col-md-12">
        <button type="submit" id="startbutton" class="col-md-6 btn-primary"style="color:black"><b>Capture</b></button>
        <div id="upload_photo" class="col-md-6 btn-primary label-file">
        <label for="file"style="color:black"><b>Upload Image</b></label>
        <input type="file" class="input-file" name="pic" accept="image/png" id='file' src="" onchange="encodeImageFileAsURL(this)" onclick="this.value=null;">
        </div>
      </div>
    </div>
  </div>
  <div class="row filters">
  <h3 class="center"><strong>Choose your filter </strong></h3>
    <form class="form-horizontal " role="form">
      <div class="row" >
        <div class="col-md-3 col-xs-6">
          <img src="../css_resources/images/royal_frame.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio active" onclick="selectOnlyThis(this.id)" id="1"style="color:black"><b>royal frame</b></button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../css_resources/images/golden-vector.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="selectOnlyThis(this.id)" id="2"style="color:black"><b>golden vector</b></button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../css_resources/images/cat.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="selectOnlyThis(this.id)" id="3"style="color:black"><b>Cat</b></button>
          <input type="checkbox" name="src" class="hidden">
          </div>
        <div class="col-md-3 col-xs-6">
          <img src="../css_resources/images/heart_border.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="selectOnlyThis(this.id)" id="4"style="color:black"><b>Hearts border</b></button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../css_resources/images/step0004.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="selectOnlyThis(this.id)" id="5"style="color:black"><b>Heart</b></button>
          <input type="checkbox" name="src" class="hidden">
        </div>   
        <div class="col-md-3 col-xs-6">
          <img style="visibility:hidden"src="#" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="selectOnlyThis(this.id)" id="6"style="color:black"><b>empty frame</b></button>
          <input type="checkbox" name="src" id="6" class="hidden">
        </div>
      </div>
    </form>
  </div>
</div>

    <div class="col-md-6 last_photos">
<?php
  $query = '
    SELECT image_url, image_id
  FROM users
  INNER JOIN gallery ON users.user_id = gallery.user_id
  WHERE gallery.user_id=:user_id
  ORDER BY gallery.date_time_photo DESC
  LIMIT 6';

  $query = $pdo->prepare($query);
  $query->execute(
    array(
      ':user_id' => $_SESSION['user_id']
    )

  );
  $count = $query->rowCount();
 
  if ($count > 0)
  {
    $result = $query->fetchAll();
      foreach ($result as $row)
      {
        ?>
        <div class="col-md-6 col-xs-6"style="color:brown">
        <h1 style="font-family: brush script mt"><b>Photo</b> 
        <img style="float:right" src="../css_resources/images/giphy.gif" width="45">
        </h1>
        
        <a  href="<?php echo $row['image_url']?>">
       <img class="thumbnails" src="<?php echo $row['image_url']?>" alt="">
     </a>
        <button class="delete_last_photo" onclick="delete_image(<?php echo  $row['image_id'];?>)"style="color:red">Delete</button>
        </div>
        <?php
      }

    
  }
    ?>
  </div>
  </div>
</section>

<?php
require_once 'footer.php';
}
else
  header ('location: login_page.php');
?>
