<?php require APPROOT . '/views/inc/header.php' ?>
    <?php flash('search_err_message') ?>
    <div class="row">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>
        <div class="col-md-6 pull-right">
            <form class="form-inline pull-right" action="<?php echo URLROOT; ?>/posts/search" method="post">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo $data['search']; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>   
    </div>


    <?php if (!empty($data['posts'])): ?>
        <?php foreach($data['posts'] as $post) : ?>
            <div class="card card-body mb-3">
                <h4 class="card-title">
                    <?php echo $post->title ?>
                </h4>
                <div class="bg-light p-2 mb-3">
                    Written by <?php echo $post->name ?> on <?php echo $post->postCreated ?>
                </div>
                <p class="card-text">
                    <?php echo $post->body; ?>
                </p>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">
                    More
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php' ?>