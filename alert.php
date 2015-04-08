<div class="divider padd" style="display: none;">

    <!--style="display: none;" by Faruk because it will implement in toast message , check in bottom off header_script.php page --> 
    <?php if (isset($msg) AND $msg != ''): ?>
        <div class="alert alert-success">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Success!</strong> <?php echo $msg; ?>
        </div>

    <?php endif; /* (isset($msg) AND $msg !='') */ ?>

    <?php if (isset($info) AND $info != ''): ?>
        <div class="alert alert-info">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Information!</strong> <?php echo $info; ?>
        </div>
    <?php endif; /* (isset($info) AND $info !='') */ ?>

    <?php if (isset($warning) AND $warning != ''): ?>

        <div class="alert alert-warning">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning!</strong> <?php echo $warning; ?>
        </div>
    <?php endif; /* (isset($warning) AND $warning !='') */ ?>


    <?php if (isset($err) AND $err != ''): ?>
        <div class="alert alert-danger">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> <?php echo $err; ?>
        </div>
    <?php endif; /* (isset($err) AND $err !='') */ ?>


</div>