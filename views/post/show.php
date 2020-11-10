  <!-- Page Header -->
  <header class="masthead" style="background-image: url('http://localhost/task/img/sample-post-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">
            <h1><?php echo $this->escape($status['post_title']); ?></h1>
            <h2><?php echo $this->escape($status['post_subtitle']); ?></h2>
            <span class="meta">Posted by
              <a href="#"><?php echo $this->escape($status['user_name']); ?></a>
              on <?php echo $this->escape($status['created_at']); ?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Post Content -->
  <article>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <?php echo $this->escape($status['body']); ?>

          <a href="#">
            <img class="img-fluid" src="http://localhost/task/img/post-sample-image.jpg" alt="">
          </a>
          <span class="caption text-muted">To go places and do things that have never been done before – that’s what living is all about.</span>

          <p>Placeholder text by
            <a href="http://spaceipsum.com/">Space Ipsum</a>. Photographs by
            <a href="https://www.flickr.com/photos/nasacommons/">NASA on The Commons</a>.</p>
          <form action="<?php echo $base_url; ?>/post/editing">
              <input type="submit" name='name' value="編集">
          </form>
          <form action="<?php echo $base_url; ?>/post/deletion">
              <input type="submit" name='name' value="削除">
          </form>
        </div>
      </div>
    </div>
  </article>