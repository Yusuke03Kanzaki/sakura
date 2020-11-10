<!-- <?php session_start(); ?>
<?php $_SESSION['name'] = 'namae'; ?> -->
<!-- Page Header -->
<header class="masthead" style="background-image: url('../../img/about-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Editing</h1>
            <span class="subheading">Do you want to re-write the text?</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
</div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
      
        
        <form method="post" action="<?php echo $base_url; ?>/post/change">
        <textarea type='text' cols="60" rows="10" value="111" name="body"><?php foreach ($statuses as $status): ?> <?php echo $status; ?> <?php endforeach; ?></textarea>
        <button type="submit" class="btn btn-primary" id="sendMessageButton">SEND</button> 
          </form>
        <!-- Pager -->
        <!-- <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts</a> -->
        </div>
      </div>
    </div>
  </div>