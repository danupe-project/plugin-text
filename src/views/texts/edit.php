<?php danupe()->view()->get('plugin-user', 'header'); ?>
<?php danupe()->view()->get('plugin-user', 'pageTitle', ['title' => $title]); ?>


<div class="mb-4">
    <a href='/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/texts' class="btn btn-solid-secondary">Texts</a>
</div>


<form method="POST" action="/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/texts/update_post" class="grid grid-cols-1 md:grid-cols-4 gap-4">

    <?php echo danupe()->plugin('user', 'form')->csrf(); ?>
    <?php echo danupe()->plugin('user', 'form')->input('id', 'hidden', danupe()->data()->get($text, 'id')); ?>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('key', 'Key'); ?>
        <?php echo danupe()->plugin('user', 'form')->input('key', '', danupe()->data()->get($text, 'key') ?: danupe()->session()->old('key')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('text', 'Text'); ?>
        <?php echo danupe()->plugin('user', 'form')->input('text', '', danupe()->data()->get($text, 'text') ?: danupe()->session()->old('text')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('language', 'Language'); ?>
        <?php echo danupe()->plugin('user', 'form')->select('language', danupe()->language()->getAllAvailableFrontendLanguageKeys(1), danupe()->data()->get($text, 'language') ?: danupe()->session()->old('language') ?: danupe()->language()->getLocale(), ['class' => 'form-select w-full']); ?>
    </div>

    <div class="form-group">
    </div>


    <?php echo danupe()->plugin('user', 'form')->submit('submit'); ?>
</form>

<div class="divider divider-horizontal">OR</div>

<div class="mb-4">
    <form method="POST" action="/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/texts/delete_post" class="grid grid-cols-1 md:grid-cols-8 gap-4">
        <?php echo danupe()->plugin('user', 'form')->csrf(); ?>
        <?php echo danupe()->plugin('user', 'form')->input('id', 'hidden', danupe()->data()->get($text, 'id')); ?>
        <?php echo danupe()->plugin('user', 'form')->submit('delete', ['class' => 'btn btn-solid-error']); ?>
    </form>
</div>



<?php danupe()->view()->get('plugin-user', 'footer'); ?>