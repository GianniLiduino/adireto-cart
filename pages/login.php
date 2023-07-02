<?php
require __DIR__ . './Layouts/html-top.php';
?>
<section id="section-login">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4 text-center">
                <a class="text-decoration-none text-black" href="/">
                    <h2><strong>Adireto - CART</strong></h2>
                </a>
            </div>
        </div>
        <?php if (isset($_SESSION['errors'])) { ?>
            <div class="row mb-3 g-2">
                <div class="col-11 col-sm-7 col-md-5 col-xxl-4 mx-auto bg-danger text-white">
                    <?php foreach ($_SESSION['errors'] as $field => $error) { ?>
                        <ul class="mb-0 pt-2">
                            <li>
                                <h5><?php echo $field ?></h5>
                                <p><?php echo $error ?></p>
                            </li>
                        </ul>
                    <?php }
                    unset($_SESSION['errors']) ?>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-11 col-sm-7 col-md-5 col-xxl-4 mx-auto">
                <form class="row g-2 mb-3" action="/login" method="POST">
                    <div class="col-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="col-12">
                        <label for="">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-success rounded-0 col-12 mt-2">ENTRAR</button>
                    </div>
                </form>
                <div class="d-flex align-items-center justify-content-end">
                    <p class="mb-0 me-2">Não possui conta?</p>
                    <a class="btn btn-primary rounded-0" href="/register">REGISTRAR</a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
require __DIR__ . './Layouts/html-bottom.php';
