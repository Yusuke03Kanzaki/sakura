<div class="post-preview">
<a href="<?php echo $base_url; ?>/post/<?php echo $this->escape($status['user_name']); ?>/status/<?php echo $this->escape($status['id']); ?>">　

            <h2 class="post-title">
              <?php echo $this->escape($status['post_title']); ?>
            </h2>
            <h3 class="post-subtitle">
              <?php echo $this->escape($status['post_subtitle']); ?>
            </h3>
          </a>
          <p class="post-meta">Posted by
            <a href="#"> <?php echo $this->escape($status['user_name']); ?> </a>
            on <?php echo $this->escape($status['created_at']); ?></p>
        </div>
        <hr>