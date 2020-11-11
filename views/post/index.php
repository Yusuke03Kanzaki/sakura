  <!-- Page Header -->
  <header class="masthead" style="background-image: url('sakura/img/home-bg.jpg')">
  <!-- <img src="../../img/home-bg.jpg" alt=""> -->
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Clean Blog</h1>
            <span class="subheading">A Blog Theme by Start Bootstrap</span>
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
        <?php foreach ($statuses as $status): ?>
              <?php echo $this->render('post/status', array('status' => $status)); ?>
        <?php endforeach; ?>
        <div class="post-preview">
          <a href="<?php echo $base_url; ?>/post/sample">
            <h2 class="post-title">
              Man must explore, and this is exploration at its greatest
            </h2>
            <h3 class="post-subtitle">
              Problems look mighty small from 150 miles up
            </h3>
          </a>
          <p class="post-meta">Posted by
            <a href="#">Start Bootstrap</a>
            on September 24, 2019</p>
        </div>
        <hr>
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts</a>
        </div>
      </div>
    </div>
  </div>