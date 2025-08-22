<?php danupe()->view()->get('plugin-user', 'header'); ?>
<?php danupe()->view()->get('plugin-user', 'pageTitle', ['title' => $title]); ?>


<div class="mb-4">
    <a href='/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/texts' class="btn btn-solid-secondary">Texts</a>
</div>

<form method="POST" action="/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/texts/create_post" class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <?php echo danupe()->plugin('user', 'form')->csrf(); ?>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('key', 'Key'); ?>
        <?php echo danupe()->plugin('user', 'form')->input('key', '', danupe()->session()->old('key')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('text', 'Text'); ?>
        <?php echo danupe()->plugin('user', 'form')->input('text', '', danupe()->session()->old('text')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('language', 'Language'); ?>
        <?php echo danupe()->plugin('user', 'form')->select('language', danupe()->language()->getAllAvailableFrontendLanguageKeys(1), danupe()->session()->old('language') ?: danupe()->language()->getLocale(), ['class' => 'form-select w-full']); ?>
    </div>
    

    <?php echo danupe()->plugin('user', 'form')->submit(); ?>
</form>

<?php danupe()->view()->get('plugin-user', 'footer'); ?>