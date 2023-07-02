<section id="section-products" class="mt-5">
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3 mb-3">
                    <?php require __DIR__ . './Product.php'; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>