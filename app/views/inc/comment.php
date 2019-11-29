<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="comment-wrapper">
            <div class="card">
                <div class="card-header bg-info">
                    Comment panel
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/posts/comment/<?php echo $data['post']->id; ?>" method="post">
                        <textarea class="form-control" placeholder="Write a comment..." rows="3" name="content"></textarea>
                        <br>
                        <button type="submit" class="btn btn-info pull-right">Post</button>
                        <div class="clearfix"></div>
                        <hr>
                    </form>

                    <?php if(!empty($data['comments'])): ?>
                        <?php foreach($data['comments'] as $comment) : ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid" />
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                <a class="float-left" href="#"><strong><?php echo $comment->name; ?></strong></a>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>

                                            </p>
                                        <div class="clearfix"></div>
                                            <p><?php echo $comment->content; ?></p>
                                            <p>
                                                <a class="float-right btn btn-outline-primary ml-2"> <i class="fa fa-reply"></i> Reply</a>
                                                <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Like</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>