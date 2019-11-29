<?php require APPROOT . '/views/inc/header.php' ?>
    <?php flash('comment_message') ?>

    <a href="<?php echo URLROOT ?>/posts" class="btn btn-light">
        <i class="fa fa-backward"></i> Back
    </a>
    <br>
    <h1><?php echo $data['post']->title ?></h1>
    <div class="bg-secondary text-white p-2 mb-3">
        Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?>
    </div>
    <?php echo $data['post']->body ?>

    <hr>

    <!-- Edit and Delete -->
    <div class="row mb-5">
        <div class="col">
            <?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>
                <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" class="pull-right" method="post">
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>

                <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark pull-right mr-1">Edit</a>
            <?php endif; ?>
        </div>
    </div>

    <hr>
    
    <!-- Comment for post -->
    <?php require APPROOT . '/views/inc/comment.php' ?>
<?php require APPROOT . '/views/inc/footer.php' ?>